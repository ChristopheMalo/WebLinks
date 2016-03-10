<?php

use Symfony\Component\Debug\ErrorHandler;
use Symfony\Component\Debug\ExceptionHandler;
use Symfony\Component\HttpFoundation\Request;

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
// Doctrine DBAL
$app->register(new Silex\Provider\DoctrineServiceProvider());

// Twig
$app->register(new Silex\Provider\TwigServiceProvider(), array(
    'twig.path' => __DIR__.'/../views',
));

// Text extension to use truncate
$app['twig'] = $app->share($app->extend('twig', function(Twig_Environment $twig, $app) { 
    $twig->addExtension(new Twig_Extensions_Extension_Text());
    return $twig;
}));

// Twig-bridge - use PATH
$app->register(new Silex\Provider\UrlGeneratorServiceProvider());

// Security acces to admin zone
$app->register(new Silex\Provider\SessionServiceProvider()); // Automatically start the PHP session management
$app->register(new Silex\Provider\SecurityServiceProvider(), array(
    'security.firewalls' => array(
        'secured' => array(
            'pattern' => '^/', // Defines the secure part of the site - here entire site
            'anonymous' => true, // An unauthenticated user can access secure parts - see links here
            'logout' => true, // disconnection possibility for user authenticated
            'form' => array('login_path' => '/login', 'check_path' => '/login_check'), // Using a form for authentication
            'users' => $app->share(function () use ($app) {
                return new WebLinks\DAO\UserDAO($app['db']); // Sets the provider access to users
            }),
        ),
    ),              
    // Submit access to back office                
    'security.role_hierarchy' => array(
        'ROLE_ADMIN' => array('ROLE_USER'), // Sets a hierarchy
    ),
    'security.access_rules' => array( // Protect the admin area
        array('^/admin', 'ROLE_ADMIN'),
        array('^/userarea', 'ROLE_USER'),
    ),
));

// Form
$app->register(new Silex\Provider\FormServiceProvider());
$app->register(new Silex\Provider\TranslationServiceProvider());
$app->register(new Silex\Provider\ValidatorServiceProvider());

// Log - Debug bar
$app->register(new Silex\Provider\MonologServiceProvider(), array(
    'monolog.logfile' => __DIR__.'/../var/logs/weblinks.log',
    'monolog.name' => 'WebLinks',
    'monolog.level' => $app['monolog.level']
));
$app->register(new Silex\Provider\ServiceControllerServiceProvider());
if (isset($app['debug']) && $app['debug'])
{
    $app->register(new Silex\Provider\HttpFragmentServiceProvider());
    $app->register(new Silex\Provider\WebProfilerServiceProvider(), array(
        'profiler.cache_dir' => __DIR__.'/../var/cache/profiler'
    ));
}




// Register services
$app['dao.user'] = $app->share(function ($app)          // User
{
    return new WebLinks\DAO\UserDAO($app['db']);
});
$app['dao.link'] = $app->share(function ($app) {        // Link
    $linkDAO = new WebLinks\DAO\LinkDAO($app['db']);
    $linkDAO->setUserDAO($app['dao.user']);
    return $linkDAO;
});
$app->error(function (\Exception $e, $code) use ($app) { // Error
    // Construction d'un message d'erreur
    switch ($code) {
        case 403:
            $message = 'Access denied.';
            break;
        case 404:
            $message = 'The requested resource could not be found.';
            break;
        default:
            $message = "Something went wrong.";
    }
    return $app['twig']->render('error.html.twig', array('message' => $message));
});
$app->before(function (Request $request) {          // JSON API
    if (0 === strpos($request->headers->get('Content-Type'), 'application/json')) {
        $data = json_decode($request->getContent(), true);
        $request->request->replace(is_array($data) ? $data : array());
    }
});
