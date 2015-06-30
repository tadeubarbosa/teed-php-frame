<?php

	class Teed
	{

		static function setContent( $content, $function )
		{
			Engine::$data['content'][$content] = $function;
		}

		static function getContent( $content )
		{

			if( !isset( Engine::$data['content'][$content] ) ) return;

			$function = Engine::$data['content'][$content];

			$function( Engine::$data['variables'] );

		}

		static function setVariable( $name, $str )
		{
			Engine::$data['variables'][$name] = $str;
		}

		static function getVariable( $name, $nullValue=null )
		{

			if( !isset( Engine::$data['variables'][$name] ) ):

				echo $nullValue;

			else:

				$data = Engine::$data['variables'][$name];

				if( is_array($data) || is_object($data) ) return $data;

				echo $data;

			endif;
		}

		static function getVariables()
		{
			return Engine::$data['variables'];
		}

		static function includeFile( $file )
		{

			if( file_exists($file) ) return include Engine::cacheFile( $file );

			echo Html::h3( "File not found: <em style=\"color:#777;\">{$file}</em>" )->class( 'error' );

		}

		static function includePartial( $file )
		{

			$file = str_replace('.','/',$file);

			$file = App::getSrcDir("templates/{$file}.php");

			include Engine::cacheFile($file);

		}

	}