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

// Login form
$app->get('/login', "WebLinks\Controller\HomeController::loginAction")->bind('login');

// User area zone - Add new link - ROLE_USER
$app->match('/userarea/link/submit', "\WebLinks\Controller\UserAreaController::submitLinkAction")->bind('link_submit');

// Admin zone
$app->get('/admin', "WebLinks\Controller\AdminController::indexAction")->bind('admin');

// Edit an existing link
$app->match('/admin/link/{id}/edit', "WebLinks\Controller\AdminController::editLinkAction")->bind('admin_link_edit');

// Remove an link
$app->get('/admin/link/{id}/delete', "WebLinks\Controller\AdminController::deleteLinkAction")->bind('admin_link_delete');

// Add a user
$app->match('/admin/user/add', "WebLinks\Controller\AdminController::addUserAction")->bind('admin_user_add');

// Edit an existing user
$app->match('/admin/user/{id}/edit', "WebLinks\Controller\AdminController::editUserAction")->bind('admin_user_edit');

// Remove a user
$app->get('/admin/user/{id}/delete', "WebLinks\Controller\AdminController::deleteUserAction")->bind('admin_user_delete');

// API : get all links
$app->get('/api/links', "WebLinks\Controller\ApiController::getLinksAction")->bind('api_links');

// API : get a link
$app->get('/api/link/{id}', "WebLinks\Controller\ApiController::getLinkAction")->bind('api_link');
