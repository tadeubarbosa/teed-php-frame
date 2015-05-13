<?php

	class Html
	{

		public static $data = [];

		public static function __callStatic( $meth, $args )
		{

			self::$data['name'] = $meth;

			self::$data['content'] = isset($args[0])? $args[0]: null;

			return new static;
		}

		public function __call( $meth, $args )
		{

			self::$data['attrs'][ $meth ] = $args[0];

			return new static;
		}

		public function __toString()
		{

			$attrs = '';

			if( count( self::$data['attrs'] ) ):

				$attrs = ' ';

				foreach( self::$data['attrs'] as $key => $value ):

					$attrs .= "{$key}=\"{$value}\" ";

				endforeach;

				$attrs = substr( $attrs, 0, strlen( $attrs ) - 1 );

			endif;

			$return = sprintf("<%s%s>%s</%s>", self::$data['name'], $attrs, self::$data['content'], self::$data['name']);

			self::$data = [];

			return $return;

		}

	}