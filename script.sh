#! /bin/bash

	composer install
	composer dump-autoload

	$DB_HOST 
	$DB_PORT 
	$DB_NAME 
	$DB_USERNAME
	$DB_PASSWORD

	echo 'Rewrite config file'
	echo 'DB_HOST:'
	read DB_HOST
	echo 'DB_PORT:'
	read DB_PORT 
	echo 'DB_NAME:'
	read DB_NAME 
	echo 'DB_USERNAME:'
	read DB_USERNAME
	echo 'DB_PASSWORD:'
	read DB_PASSWORD

	touch config/config.php
	echo '<?php'>config/config.php
	echo '$DB_HOST= '$DB_HOST';'>>config/config.php
	echo '$DB_PORT= '$DB_PORT';'>>config/config.php
	echo '$DB_NAME= '$DB_NAME';'>>config/config.php
	echo '$DB_USERNAME= '$DB_USERNAME';'>>config/config.php
	echo '$DB_PASSWORD= '$DB_PASSWORD';'>>config/config.php
	echo '?>'>>config/config.php

	cd public
	php -S localhost:8000