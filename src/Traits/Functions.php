<?php

	namespace Traits;

	trait Functions
	{

		static $data = [];

		static function __callStatic( $meth, $args )
		{

			$action = substr( $meth, 0, 3 );

			$name = strtolower( substr( $meth, 3, strlen( $meth ) ) );

			if( $action == 'get' ):

				if( !isset(self::$data[$name]) ):

					return null;

				else:

					if( isset( $args[0] ) ):

						return self::$data[$name] . $args[0];

					elseif( isset( $args[1] ) ):

						return self::$data[$name] . $args[0] . $args[1];

					else:

						return self::$data[$name];

					endif;

				endif;

			elseif( $action == 'set' ):

				self::$data[$name] = $args[0];

			endif;

		}

		static function getAllData()
		{
			return self::$data;
		}

		static function setAllData( $data )
		{
			self::$data = array_merge( self::$data, (array) $data );
		}

	}