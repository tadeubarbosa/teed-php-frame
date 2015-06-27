<?php

	class String
	{

		static function toSlug( $str, $replace=[], $delimiter='-' )
		{
			if( !empty($replace) ):

				$str = str_replace((array)$replace, ' ', $str);

			endif;

			$clean = iconv('UTF-8', 'ASCII//TRANSLIT', $str);
			$clean = preg_replace("/[^a-zA-Z0-9\/_|+ -]/", '', $clean);
			$clean = strtolower(trim($clean, '-'));
			$clean = preg_replace("/[\/_|+ -]+/", $delimiter, $clean);

			return $clean;
		}

		static function toText( $str )
		{
			return ucwords( str_replace( '-', ' ', $str ) );
		}

		static function emptyOrNull( $str, $isNull=null )
		{
			return isset( $str ) && !is_null( $str )? $str: $isNull;
		}

		static function getFirstExplodeString( $delm, $string )
		{
			return explode( $delm, $string )[0];
		}

		static function getEndExplodeString( $delm, $array )
		{
			$array = explode( $delm, $array );

			return end( $array );
		}

		static function getData( $array )
		{

			$response = [];

			$data = func_get_args();

			array_shift( $data );

			if(!count($array)) return;

			if( is_array($array) ):

				foreach( $array as &$row ):

					$attributes = (object) $row->attributes();

					if( count($data) ):

						foreach( $data as $key ):

							$attributes->$key = $row->$key->attributes();

						endforeach;

					endif;

					foreach( $attributes as $key => &$value ):

						if( is_array($value) ):

							foreach( $value as $collum => &$item ):

								if( !isset($attributes->$collum) ):

									$attributes->$collum = $item;

								endif;

								$item = utf8_encode( $item );

								if( $collum=='name' ):

									$value['slug'] = "{$attributes->id}-" . String::toSlug( $item, true );

								endif;

							endforeach;

							$value = (object) $value;

						else:

							$value = utf8_encode( $value );

							if( $key=='name' ):

								$attributes->slug = "{$attributes->id}-" . String::toSlug( $value, true );

							endif;

						endif;

					endforeach;

					$row = $attributes;

				endforeach;

				$response = $array;

			else:

				$attributes = $array->attributes();

				if( count($data) ):

					foreach( $data as $key ):

						$attributes[$key] = $array->$key->attributes();

					endforeach;

				endif;

				foreach( $attributes as $key => &$value ):

					if( is_array($value) ):

						foreach( $value as $collum => &$item ):

							if( !isset($attributes[$collum]) ):

								$attributes[$collum] = $item;

							endif;

							$item = utf8_encode( $item );

							if( $collum=='name' ):

								$value['slug'] = "{$attributes['id']}-" . String::toSlug( $item, true );

							endif;

						endforeach;

						$value = (object) $value;

					else:

						$value = utf8_encode( $value );

						if( $key=='name' ):

							$attributes['slug'] = "{$attributes['id']}-" . String::toSlug( $value, true );

						endif;

					endif;

				endforeach;

				$response = (object) $attributes;

			endif;

			return $response;

		}

		static function php( $fn )
		{
			return "<?php $fn ?>";
		}

		static function toObject( $array )
		{

			if(is_string($array) || is_object($array)):

				return utf8_encode( $array );

			elseif(is_array($array)):

				foreach( $array as &$value ):

					if(!is_scalar($value)):

						$value = (object) $value;

					endif;

				endforeach;

				return $array;

			endif;

		}

		static function toArray( $array )
		{
			if(is_string($array) || is_array($array)):

				return utf8_encode( $array );

			elseif(is_object($array)):

				foreach( $array as &$value ):

					if(!is_scalar($value)):

						$value = (object) $value;

					endif;

				endforeach;

				return $array;

			endif;

		}

		static function removeItemOfArray( $index, $array )
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

		static function countExplode( $delm, $array )
		{
			$array = explode( $delm, $array );

			return count( $array );
		}

	}