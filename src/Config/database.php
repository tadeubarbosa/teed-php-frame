<?php

	$env = null;

	foreach( $data as $key => $values ):

		$key = str_Replace('*','(.*)', $key);

		if( !preg_match("({$key})", $_SERVER['SERVER_NAME']) ) return;

		$env = "mysql://{$values[1]}:{$values[2]}@{$values[0]}/{$values[3]}";

		break;

	endforeach;

	if( !$env ):

		echo Html::h1('Ops! Seu arquivo src/config/database.php está incorreto...');

		exit();

	endif;

	$data = Files::getFile( App::getConfigDir('database.php') );

	$cfg = ActiveRecord\Config::instance();

	$cfg->set_model_directory('src/service/');

	$cfg->set_connections( $data );

	ActiveRecord\Config::initialize(function($cfg) use($env)
	{
		$cfg->set_default_connection( $env );
	});