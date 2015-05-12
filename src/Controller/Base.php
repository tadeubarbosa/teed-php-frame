<?php

	namespace Controller;

	use \App, \Files, \Engine, \Traits\Functions;

	trait Base
	{

		use Functions;

		static function getView( $file_name='index' )
		{

			$file_name = sprintf('%s/%s.php', self::$base, $file_name);

			self::returnView( $file_name );

		}

		static function getDefaultView( $pagina )
		{

			$pagina = "default/{$pagina}.php";

			self::returnView( $pagina );

		}

		static function returnView( $file_name )
		{

			self::$data['base'] = self::$base;

			Engine::$data['variables'] = self::$data;

			$file_name = App::getViewsDir($file_name);

			Engine::cacheTemplate( $file_name, true );

			///

			$template = App::getTemplateDir('template.php');

			Engine::cacheTemplate( $template );

		}

	}