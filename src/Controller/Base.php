<?php

	namespace Controller;

	use \App, \Files, \Engine, \Traits\Functions;

	trait Base
	{

		use Functions;

		static function getBase()
		{

			if( !isset(self::$base) ):

				preg_match_all('/((?:^|[A-Z])[a-z]+)/', get_class(), $matches);

				$base = \String::toSlug( implode( '-', $matches[0] ) );

			else:

				$base = self::$base;

			endif;

			return $base;

		}

		static function getView( $file_name='index' )
		{

			$file_name = sprintf('%s/%s.php', self::getBase(), $file_name);

			self::returnView( $file_name );

		}

		static function getDefaultView( $page, $lateral=null )
		{

			self::$data['menulateral'] = !$lateral? 'default': self::getBase();

			self::$data['page'] = $page;

			self::returnView("default/page.php");

		}

		static function returnView( $file_name )
		{

			self::$data['base'] = self::getBase();

			//

			Engine::$data['variables'] = self::$data;

			$file_name = App::getViewsDir($file_name);

			Engine::cacheTemplate( $file_name, true );

			///

			$template = App::getTemplateDir('template.php');

			Engine::cacheTemplate( $template );

		}

	}