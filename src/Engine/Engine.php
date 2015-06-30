<?php

	class Engine
	{

		use \Traits\Functions;

		static function verifyIfFileIsTeedTemplate($file)
		{

			$teed = str_replace('.php','.teed.php',$file);

			return file_exists($teed)? $teed: $file;

		}

		static function verifyDifference( $file, $cached )
		{

			if( !file_exists( $cached ) ) return true;

			$file = Carbon\Carbon::now()->timestamp(filemtime($file));

			$cached = Carbon\Carbon::now()->timestamp(filemtime($cached));

			return $cached < $file;

		}

		static function cacheTemplate( $file_name, $body=null )
		{
			include self::cacheFile( $file_name, $body );
		}

		static function cacheFile( $file_name, $body=null )
		{

			$file_name = self::verifyIfFileIsTeedTemplate($file_name);

			if( App::getEnv()->name == 'local' ):

				$cached_file =  App::getCacheDir( str_replace( [App::getSrcDir(),'/'], ['','-'], $file_name ) );

			else:

				$cached_file =  App::getCacheDir( sha1($file_name) );

			endif;

			$cached_file = str_replace(['.teed.php','.php'],'.cache-teed',$cached_file);

			if( !file_exists($file_name) || self::verifyDifference( $file_name, $cached_file ) ):

				$file = self::renderTemplate( $file_name, $body );

				if( App::getEnv()->compress_output ):

					$file = preg_replace('/<!--([^\[|(<!)].*)/', '', $file);
					$file = preg_replace('/(?<!\S)\/\/\s*[^\r\n]*/', '', $file);
					$file = preg_replace('/\s{2,}/', '', $file);
					$file = preg_replace('/(\r?\n)/', '', $file);

				endif;

				Files::putFile( $cached_file, $file, 'w+' );

			endif;

			return $cached_file;

		}

		static function renderTemplate( $file, $body=null )
		{

			$string = Files::getFile( $file );

			$string = "{{{ if(Engine::getAllData()['variables']){extract(Engine::getAllData()['variables']);} }}} {$string}";

			if( $body ):

				$string = "@setContent('body') {$string} @endcontent";

			endif;

			$variables = Files::getData( App::getTeedSrcDir('Engine/Variables.php'), true );

			foreach( $variables as $value ):

				$value = (array) $value;

				$value[0] = str_replace( ['(',')'], ['\(','\)'], $value[0] );

				$value[0] = str_replace( ['*'], ['(.*)'], $value[0] );

				$value[0] = "/({$value[0]})/" . (isset($value[2])? '': 'U');

				$string = preg_replace( $value[0], $value[1], $string );

			endforeach;

			return $string;

		}

	}