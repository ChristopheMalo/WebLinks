<?php

namespace WebLinks\Domain;

/**
 * Class representing an User
 *
 * @author      Christophe Malo
 * @version     1.0.0
 * @copyright   OpenClassrooms - Baptiste Pesquet
 */

class User
{
    /**
     * User id
     * 
     * @var integer 
     */
    private $id;
    
    /**
     * User name
     * 
     * @var string 
     */
    private $username;
    
    
    
    
    /**
     * Returns user id
     * 
     * @return integer $id The user id
     */
    public function getId()
    {
        return $this->id;
    }
    
    /**
     * Returns user name
     * 
     * @return string $username The user name
     */
    public function getusername()
    {
        return $this->username;
    }
    
    
    
    
    /**
     * Sets user id
     * 
     * @param integer $id
     * @return void
     */
    public function setId($id)
    {
        $this->id = $id;
    }
    
    /**
     * Sets user name
     * 
     * @param string $username
     * @return void
     */
    public function setUsername($username)
    {
        $this->username = $username;
    }
}
