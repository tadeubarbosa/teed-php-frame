<?php

	class String
	{

		public static function toSlug( $str )
		{
			$str = iconv('utf-8', 'us-ascii//TRANSLIT', $str);
			return strtolower( preg_replace( '/[^A-Za-z0-9-]+/', '-', $str ) );
		}

		public static function toText( $str )
		{
			return ucwords( str_replace( '-', ' ', $str ) );
		}

		public static function emptyOrNull( $str, $isNull=null )
		{
			return isset( $str ) && !is_null( $str )? $str: $isNull;
		}

		public static function getFirstExplodeString( $delm, $string )
		{
			return explode( $delm, $string )[0];
		}

		public static function getEndExplodeString( $delm, $array )
		{
			$array = explode( $delm, $array );

			return end( $array );
		}

		static function getData( $array )
		{

			$response = [];

			$data = func_get_args();

			array_shift( $data );

			if( is_array($array) ):

				foreach( $array as &$row ):

					$attributes = (object) $row->attributes();

					foreach( $data as $value ):

						if( !$row->$value ) continue;

						$attributes->$value = $row->$value->attributes();

					endforeach;

					$row = $attributes;

				endforeach;

				$response = $array;

			else:

				$attributes = $array->attributes();

				foreach( $data as $key ):

					if( !$array->$key->attributes() ) continue;

					$attributes[ $key ] = $array->$key->attributes();

				endforeach;

				$response = $attributes;

			endif;

			return $response;

		}

		public static function php( $fn )
		{
			return "<?php $fn ?>";
		}

		public static function removeItemOfArray( $index, $array )
		{

			$response = [];

			foreach( $array as $key => $value ):

				if( $key !== $index ):

					if( is_numeric( $index ) ):

						$response[] = $value;

					else:

						$response[ $key ] = $value;

					endif;

				endif;

			endforeach;

			return $response;
		}

		public static function countExplode( $delm, $array )
		{
			$array = explode( $delm, $array );

			return count( $array );
		}

	}