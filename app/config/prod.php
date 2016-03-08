<?php
/**
 * Configuration file for the production phase
 * 
 * @author      Christophe Malo
 * @version     1.0.0
 * @copyright   OpenClassrooms - Baptiste Pesquet
 */

// Doctrine DBAL (db)
$app['db.options'] = array(
    'driver'   => 'pdo_mysql',
    'charset'  => 'utf8',
    'host'     => 'localhost',
    'port'     => '3306',
    'dbname'   => 'weblinks',
    'user'     => 'weblinks_user',
    'password' => 'secret',
);

// Sets the level of logs
$app['monolog.level'] = 'WARNING';
