<?php

namespace WebLinks\Controller;

use Silex\Application;
use Symfony\Component\HttpFoundation\Request;
use WebLinks\Domain\Link;
use WebLinks\Form\Type\LinkType;

/**
 * Class manager controllers accessible from the user area<br>
 * For the moment, just one action -> add link<br>
 * but the user can perform several actions in this area<br>
 * <ul>
 *      <li>- manage his profile</li>
 *      <li>- manage his links
 *      <li>- and so on</li>
 * </ul>
 * 
 * With hierarchy setup in app file, ROLE_USER and ROLE_ADMIN can add link
 *
 * @author cmalo
 * @version     1.0.0
 */

class UserAreaController {
    /**
     * Add link controller.
     *
     * @param Request $request Incoming request
     * @param Application $app Silex application
     * @return View link_form
     */
    public function submitLinkAction(Request $request, Application $app)
    {
        
        $link = new Link();
            
        // The user is authenticated, sets the user
        // needs to have no error with phpunit test urls
        if ($app['security.authorization_checker']->isGranted('ROLE_USER'))
        {
            $author = $app['user'];     // The user connected to the app
            $link->setAuthor($author);          
        }
        $linkForm = $app['form.factory']->create(new LinkType(), $link);
        $linkForm->handleRequest($request);

        // Debug to display the link object
        // var_dump($link); // Returns a link object with user

        if ($linkForm->isSubmitted() && $linkForm->isValid())
        {
            $app['dao.link']->save($link);
            $app['session']->getFlashBag()->add('success', 'The link was successfully created.');
        }
        return $app['twig']->render('link_form.html.twig', array(
            'title' => 'New link',
            'linkForm' => $linkForm->createView()
        ));
    }
}
