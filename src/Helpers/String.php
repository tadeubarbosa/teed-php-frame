<?php

	class String
	{

		static function toSlug( $str, $replace=[], $delimiter='-' )
		{
			if( !empty($replace) ):

				$str = str_replace((array)$replace, ' ', $str);

			endif;

			// $clean = iconv('UTF-8', 'ASCII//TRANSLIT', $str);
			// $clean = preg_replace("/[^a-zA-Z0-9\/_|+ -]/", '', $clean);
			// $clean = strtolower(trim($clean, '-'));
			// $clean = preg_replace("/[\/_|+ -]+/", $delimiter, $clean);

			return $str;
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

			$joins = func_get_args();

			array_shift( $joins );

			//

			if(!count($array)) return;

			if( !is_array($array) ):

				$uniq = true;

				$array = [$array];

			endif;

			foreach( $array as &$row ):

				$attributes = (object) $row->attributes();

				if( count($joins) ):

					foreach( $joins as $key ):

						$attributes->$key = $row->$key->attributes();

					endforeach;

				endif;

				foreach( $attributes as $key => &$value ):

					if( is_object($value) && get_class($value) == 'ActiveRecord\\DateTime' ):

						$newValue = [];

						foreach( $value as $int => $item ):

							$newValue[$int] = $item;

						endforeach;

						$value = $newValue['date'];

					endif;

					if( is_array($value) ):

						foreach( $value as $collum => &$item ):

							if( !isset($attributes->$collum) ):

								$attributes->$collum = $item;

							endif;

							$item = utf8_encode( $item );

						endforeach;

						if( isset($value['name']) ):

							$value['slug'] = "{$attributes->id}-" . String::toSlug( $value->name, true );

						endif;

						$value = (object) $value;

					else:

						$value = utf8_encode( $value );

					endif;

					if( isset($attributes->name) ):

						$attributes->slug = "{$attributes->id}-" . String::toSlug( $attributes->name, true);

					endif;

				endforeach;

				$row = (object) $attributes;

			endforeach;

			if( isset($uniq) ):

				$array = $array[0];

			endif;

			return $array;

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