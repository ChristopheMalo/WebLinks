<?php

namespace WebLinks\DAO;

use WebLinks\Domain\Link;

/**
 * Access to a data link
 *
 * @author      Christophe Malo
 * @version     1.0.0
 * @copyright   OpenClassrooms - Baptiste Pesquet
 */

class LinkDAO extends DAO 
{
    /**
     * The UserDAO
     * 
     * @var \WebLinks\Domain\UserDAO 
     */
    private $userDAO;
    
    /**
     * Sets the UserDAO -> to find the user associated to link
     * 
     * @param \WebLinks\DAO\UserDAO $userDAO
     */
    public function setUserDAO(UserDAO $userDAO)
    {
        $this->userDAO = $userDAO;
    }
    
    /**
     * Returns a list of all links, sorted by id.
     *
     * @return array A list of all links.
     */
    public function findAll()
    {
        $sql = "SELECT * FROM t_link ORDER BY link_id DESC";
        $result = $this->getDb()->fetchAll($sql);
        
        // Convert query result to an array of domain objects
        $links = array();
        foreach ($result as $row)
        {
            $linkId = $row['link_id'];
            $links[$linkId] = $this->buildDomainObject($row);
        }
        
        return $links;
    }

    /**
     * Builds an Link object based on a DB row.
     *
     * @param array $row The DB row containing Link data.
     * @return \WebLinks\Domain\Link $link
     */
    protected function buildDomainObject($row)
    {
        $link = new Link();
        $link->setId($row['link_id']);
        $link->setTitle($row['link_title']);
        $link->setUrl($row['link_url']);
        
        if (array_key_exists('user_id', $row))
        {
            $authorId = $row['user_id'];
            $author = $this->userDAO->find($authorId);
            $link->setAuthor($author);
        }
        
        // Debug to display object link
        //var_dump($link); // Returns object -> a link with data and user (the link creator)
        
        return $link;
    }
}
