<?php

	class Response
	{

		static function json( $array )
		{
			echo json_encode( self::utf8( $array ) );
		}

		static function utf8($input)
		{

			if(is_string($input)):

				$input = utf8_encode($input);

			elseif(is_array($input)):

				foreach($input as $key => $value):

					$input[$key] = self::utf8($value);

				endforeach;

				unset($value);

			elseif(is_object($input)):

				$vars = get_object_vars($input);

				foreach($vars as $key => $var):

					$input->$key = self::utf8($var);

				endforeach;

			endif;

			return $input;
		}

	}