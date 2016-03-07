<?php
/**
 * Configuration file for the development phase
 * 
 * @author      Christophe Malo
 * @version     1.0.0
 * @copyright   OpenClassrooms - Baptiste Pesquet
 */

// include the prod configuration
require __DIR__.'/prod.php';

// enable the debug mode
$app['debug'] = true;
