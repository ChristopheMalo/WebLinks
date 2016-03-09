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
     * Returns a link matching the param id
     * 
     * @param int $id The link id
     * @return \WebLinks\Domain\Link A link object
     * @throws \Exception
     */
    public function find($id)
    {
        $sql = "SELECT * FROM t_link WHERE link_id=?";
        $row = $this->getDb()->fetchAssoc($sql, array($id));
        
        if ($row)
        {
            return $this->buildDomainObject($row);
        }
        else
        {
            throw new \Exception('No link matching id ' . $id);
        }
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
     * Saves a link in database
     * 
     * @param \WebLinks\Domain\Link $link The link to save
     * @return void
     */
    public function save(Link $link)
    {
        // Builds array with link and user values
        $linkData = array(
            'link_title'    => $link->getTitle(),
            'link_url'      => $link->getUrl(),
            'user_id'       => $link->getAuthor()->getId(),
        );
        
        // Debug to display array data
        //var_dump($linkData); // Returns array -> a link with user
        
        if ($link->getId())
        {
            // The link exists: update it
            $this->getDb()->update('t_link', $linkData, array('link_id' => $link->getId()));
        }
        else
        {
            // The link does not exist: insert it
            $this->getDb()->insert('t_link', $linkData);
            
            // Gets the id of the newly created link and sets it in the entity
            $id = $this->getDb()->lastInsertId();
            $link->setId($id);
        }
    }
    
    /**
     * Remove link from database
     * 
     * @param int $id The link id
     * @return void
     */
    public function delete($id)
    {
        $this->getDb()->delete('t_link', array('link_id' => $id));
    }
    
    /**
     * Remove all links of user from database
     * 
     * @param int $authorId The user id
     */
    public function deleteAllByAuthor($authorId)
    {
        $this->getDb()->delete('t_link', array('user_id' => $authorId));
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
            // Find and set the associated author
            $authorId = $row['user_id'];
            $author = $this->userDAO->find($authorId);
            $link->setAuthor($author);
        }
        
        // Debug to display object link
        //var_dump($link); // Returns object -> a link with data and user (the link creator)
        
        return $link;
    }
}
