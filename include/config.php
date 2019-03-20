<?php

require_once __DIR__.'/Application.php';
require_once __DIR__.'/User.php';

/**
 * DB connection parameters
 */
define('BD_HOST', '127.0.0.1');
define('BD_NAME', 'Restomatic');
define('BD_USER', 'user');
define('BD_PASS', '');

/**
 * UTF-8 support configuration, localisation (language, country) and timezone
 */
ini_set('default_charset', 'UTF-8');
setLocale(LC_ALL, 'es_ES.UTF.8');
date_default_timezone_set('Europe/Madrid');

// Inicializa la aplicación
$app = Application::getInstance();
$app->init(array('host'=>BD_HOST, 'bd'=>BD_NAME, 'user'=>BD_USER, 'pass'=>BD_PASS));

/**
 * @see http://php.net/manual/en/function.register-shutdown-function.php
 * @see http://php.net/manual/en/language.types.callable.php
 */
register_shutdown_function(array($app, 'shutdown'));