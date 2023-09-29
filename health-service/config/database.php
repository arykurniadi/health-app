<?php

return [
	'default' => getenv('DB_ADAPTER'),
	'connections' => [
		'mysql' => [
			'host' => getenv('DATABASE_HOST'),
			'port' => getenv('DATABASE_PORT'),
			'username' => getenv('DATABASE_USER'),
			'password' => getenv('DATABASE_PASS'),
			'dbname' => getenv('DATABASE_NAME')
		],
		'mongo' => [

		],
		'sqlite' => [
			
		],
		'pgsql' => [
			
		]
	]
];
