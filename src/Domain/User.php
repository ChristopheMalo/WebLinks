<?php

namespace WebLinks\Domain;

use Symfony\Component\Security\Core\User\UserInterface;

/**
 * Class representing an User
 *
 * @author      Christophe Malo
 * @version     1.0.0
 * @copyright   OpenClassrooms - Baptiste Pesquet
 */

class User implements UserInterface
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
     * User password
     * 
     * @var string
     */
    private $password;
    
    /**
     * Salt was used to encode the password
     * 
     * @var string
     */
    private $salt;
    
    /**
     * User role
     * Values : ROLE_USER or ROLE_ADMIN
     * @var string
     */
    private $role;
    
    
    
    
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
     * @inheritDoc
     */
    public function getUsername()
    {
        return $this->username;
    }
    
    /**
     * @inheritDoc
     */
    public function getPassword()
    {
        return $this->password;
    }
    
    /**
     * @inheritDoc
     */
    public function getSalt()
    {
        return $this->salt;
    }
    
    /**
     * Gets user role
     * 
     * @return string User role
     */
    public function getRole()
    {
        return $this->role;
    }

    /**
     * @inheritDoc
     */
    public function getRoles() {
        return array($this->getRole());
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
    
    /**
     * Sets user password
     * 
     * @param string $password
     * @return void
     */
    public function setPassword($password)
    {
        $this->password = $password;
    }
    
    /**
     * Sets the associated salt to the user's password
     * 
     * @param string $salt
     * @return void
     */
    public function setSalt($salt)
    {
        $this->salt = $salt;
    }
    
    /**
     * Sets user role
     * 
     * @param string $role
     * @return void
     */
    public function setRole($role)
    {
        $this->role = $role;
    }
    
    /**
     * @inheritDoc
     */
    public function eraseCredentials()
    {
       
    }          
}
