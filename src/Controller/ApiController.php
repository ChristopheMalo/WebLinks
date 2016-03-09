<?php

namespace WebLinks\Controller;

use Silex\Application;
use WebLinks\Domain\Link;

/**
 * Class manager controller of JSON API
 * 
 *
 * @author      Christophe Malo
 * @version     1.0.0
 * @copyright   OpenClassrooms - Baptiste Pesquet
 */

class ApiController
{
    /**
     * API links controller.
     *
     * @param Application $app Silex application
     *
     * @return All links in JSON format
     */
    public function getLinksAction(Application $app)
    {
        $links = $app['dao.link']->findAll();
        // Convert an array of objects ($links) into an array of associative arrays ($responseData)
        $responseData = array();
        foreach ($links as $link)
        {
            $responseData[] = $this->buildLinkArray($link);
        }
        // Create and return a JSON response
        return $app->json($responseData);
    }

    /**
     * API link details controller.
     *
     * @param integer $id Link id
     * @param Application $app Silex application
     *
     * @return Link details in JSON format
     */
    public function getLinkAction($id, Application $app)
    {
        $link = $app['dao.link']->find($id);
        $responseData = $this->buildLinkArray($link);
        // Create and return a JSON response
        return $app->json($responseData);
    }

    /**
     * Converts a link object into an associative array for JSON encoding
     *
     * @param Link $link Link object
     * @return array Associative array whose fields are the link properties.
     */
    private function buildLinkArray(Link $link)
    {
        // Format array for better reading in browser
        $data  = array(
            'Link' => array( // 'Link' is optional - Format option to better reading
                'id'     => $link->getId(),
                'title'  => $link->getTitle(),
                'url'    => $link->getUrl(),
                'author' => array( // Optional too
                    'id'    => $link->getAuthor()->getId(),
                    'name'  => $link->getAuthor()->getUsername()
                )
            )
        );
        return $data;
    }  
}
