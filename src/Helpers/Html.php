<?php

	class Html
	{

		public static $content;

		public static $name;

		public static $attrs = [];

		public static function __callStatic( $meth, $args )
		{

			self::$name = $meth;

			self::$content = isset($args[0])? $args[0]: null;

			return new static;
		}

		public function __call( $meth, $args )
		{

			self::$attrs[ $meth ] = $args[0];

			return new static;
		}

		public function __toString()
		{

			$attrs = '';

			if( count( self::$attrs ) ):

				$attrs = ' ';

				foreach( self::$attrs as $key => $value ):

					$attrs .= "{$key}=\"{$value}\" ";

				endforeach;

				$attrs = substr( $attrs, 0, strlen( $attrs ) - 1 );

			endif;

			return sprintf("<%s%s>%s</%s>", self::$name, $attrs, self::$content, self::$name);
		}

	}