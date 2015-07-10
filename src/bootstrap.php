<?php

use Silex\Provider;

$app['debug'] = true;

date_default_timezone_set('America/Chicago');

$app->register(new Provider\TwigServiceProvider(), array(
	'twig.path' => __DIR__.'/views',
));

$app->register(new Silex\Provider\UrlGeneratorServiceProvider());

$app->register(new Provider\SessionServiceProvider());

$app->register(new Provider\ServiceControllerServiceProvider());

$app->register(
    new \BitolaCo\Silex\CapsuleServiceProvider(),
    array( 
         'capsule.connection' => array(
            'driver' => 'mysql',
            'host' => 'localhost',
            'database' => 'si-twi',
            'username' => 'root',
            'password' => '',
            'charset' => 'utf8',
            'collation' => 'utf8_unicode_ci',
            'prefix' => '',
            'logging' => false, // Toggle query logging on this connection.
        )
    )
);

$app['capsule'];

$app['app.controller'] = $app->share(function() use ($app) {
    return new SiTwi\Controllers\AppController($app);
});

require_once 'routes.php';

$app->run();