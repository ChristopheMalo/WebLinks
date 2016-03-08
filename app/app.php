<?php

use Symfony\Component\Debug\ErrorHandler;
use Symfony\Component\Debug\ExceptionHandler;


/**
 * Configuration file of Silex Application
 * 
 * @author      Christophe Malo
 * @version     1.0.0
 * @copyright   OpenClassrooms - Baptiste Pesquet
 */

// Register global error and exception handlers
ErrorHandler::register();
ExceptionHandler::register();

// Register service providers
$app->register(new Silex\Provider\DoctrineServiceProvider());           // Doctrine DBAL
$app->register(new Silex\Provider\TwigServiceProvider(), array(         // Twig
    'twig.path' => __DIR__.'/../views',
));
$app->register(new Silex\Provider\UrlGeneratorServiceProvider());       // Twig-bridge - use PATH
$app->register(new Silex\Provider\MonologServiceProvider(), array(      // Log - Debug bar
    'monolog.logfile' => __DIR__.'/../var/logs/weblinks.log',
    'monolog.name' => 'WebLinks',
    'monolog.level' => $app['monolog.level']
));
$app->register(new Silex\Provider\ServiceControllerServiceProvider());  // Log- Debug bar
if (isset($app['debug']) && $app['debug'])
{
    $app->register(new Silex\Provider\HttpFragmentServiceProvider());
    $app->register(new Silex\Provider\WebProfilerServiceProvider(), array(
        'profiler.cache_dir' => __DIR__.'/../var/cache/profiler'
    ));
}

// Register services
$app['dao.user'] = $app->share(function ($app)
{
    return new WebLinks\DAO\UserDAO($app['db']);
});
$app['dao.link'] = $app->share(function ($app) {
    $linkDAO = new WebLinks\DAO\LinkDAO($app['db']);
    $linkDAO->setUserDAO($app['dao.user']);
    return $linkDAO;
});
