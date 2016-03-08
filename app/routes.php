<?php
/**
 * Controller management of application routes
 * 
 * @author      Christophe Malo
 * @version     1.0.0
 * @copyright   OpenClassrooms - Baptiste Pesquet
 */

// Home page
$app->get('/', "WebLinks\Controller\HomeController::indexAction")->bind('home');
        
