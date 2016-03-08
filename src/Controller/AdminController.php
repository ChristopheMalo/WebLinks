<?php

namespace WebLinks\Controller;

use Silex\Application;

/**
 * Class manager controllers backoffice 
 *
 * @author      Christophe Malo
 * @version     1.0.0
 * @copyright   OpenClassrooms - Baptiste Pesquet
 */

class AdminController
{
    /**
     * Admin home page controller
     * 
     * @param Application $app Silex application
     * @return View admin index
     */
    public function indexAction(Application $app)
    {
        $links = $app['dao.link']->findAll();
        $users = $app['dao.user']->findAll();
        return $app['twig']->render('admin.html.twig', array(
            'links' => $links,
            'users' => $users
        ));
    }
}
