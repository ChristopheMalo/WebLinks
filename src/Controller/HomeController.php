<?php

namespace WebLinks\Controller;

use Silex\Application;
use Symfony\Component\HttpFoundation\Request;
use WebLinks\Domain\Link;
use WebLinks\Form\Type\LinkType;

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
    
    /**
     * Add link controller.
     *
     * @param Request $request Incoming request
     * @param Application $app Silex application
     * @return View link_form
     */
    public function addLinkAction(Request $request, Application $app) {
        $link = new Link();
        
        $author = $app['user'];     // The user connected to the app
        $link->setAuthor($author);
        
        $linkForm = $app['form.factory']->create(new LinkType(), $link);
        $linkForm->handleRequest($request);
        
        var_dump($link);
        
        if ($linkForm->isSubmitted() && $linkForm->isValid()) {
            $app['dao.link']->save($link);
            $app['session']->getFlashBag()->add('success', 'The link was successfully created.');
        }
        return $app['twig']->render('link_form.html.twig', array(
            'title' => 'New link',
            'linkForm' => $linkForm->createView()));
    }
    
    public function loginAction(Request $request, Application $app)
    {
        return $app['twig']->render('login.html.twig', array(
            'error'         => $app['security.last_error']($request),
            'last_username' => $app['session']->get('_security.last_username')
        ));
    }
}
