<?php

namespace WebLinks\Controller;

use Symfony\Component\HttpFoundation\Request;

use Silex\Application;

/**
 * Class manager controllers accessible from the home page 
 *
 * @author      Christophe Malo
 * @version     1.0.0
 * @copyright   OpenClassrooms - Baptiste Pesquet
 */

class HomeController
{
    /**
     * Home page controller to display all links
     * 
     * @param Application $app Silex application
     * @return Index view
     */
    public function indexAction(Application $app)
    {
        $links = $app['dao.link']->findAll();
        return $app['twig']->render('index.html.twig', array('links' => $links));
    }
    
    public function loginAction(Request $request, Application $app)
    {
        return $app['twig']->render('login.html.twig', array(
            'error'         => $app['security.last_error']($request),
            'last_username' => $app['session']->get('_security.last_username')
        ));
    }
}
