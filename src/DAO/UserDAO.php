<?php

namespace WebLinks\DAO;

use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\User\UserProviderInterface;
use Symfony\Component\Security\Core\Exception\UsernameNotFoundException;
use Symfony\Component\Security\Core\Exception\UnsupportedUserException;
use WebLinks\Domain\User;

/**
 * Access to author's data 
 *
 * @author      Christophe Malo
 * @version     1.0.0
 * @copyright   OpenClassrooms - Baptiste Pesquet
 */

class UserDAO extends DAO implements UserProviderInterface
{
    /**
     * Returns a User matching the param id
     * 
     * @param integer $id The user id
     * @return \WebLinks\Domain\User
     * @throws \WebLinks\Domain\User\Exception if no matching user is found
     */
    public function find($id)
    {
        $sql = "SELECT user_id, user_name FROM t_user WHERE user_id=?";
        $row = $this->getDb()->fetchAssoc($sql, array($id));
        
        // Debug to display data row
        //var_dump($row); // Returns array -> an user with data from sql select
        
        if ($row)
        {
            return $this->buildDomainObject($row);
        }
        else
        {
            throw new \Exception('No user matching id ' . $id);
        }
    }
    
    /**
     * Returns a list (array) of all users, sorted by role and username
     * 
     * @return array $users a list of all users
     */
    public function findAll()
    {
        $sql = "SELECT * FROM t_user ORDER BY user_role, user_name";
        $result = $this->getDb()->fetchAll($sql);
        
        // Convert query result to an array of domain objects
        $users = array();
        foreach ($result as $row)
        {
            $id = $row['user_id'];
            $users[$id] = $this->buildDomainObject($row);
        }
        return $users;
    }
    
    /**
     * Saves the user in database
     * 
     * @param \WebLinks\Domain\User $user The user to save
     */
    public function save(User $user)
    {
        // Buils array with user values
        $userData = array(
            'user_name'     => $user->getUsername(),
            'user_salt'     => $user->getSalt(),
            'user_password' => $user->getPassword(),
            'user_role'     => $user->getRole()
        );
        
        if ($user->getId())
        {
            // The user exists: update it
            $this->getDb()->update('t_user', $userData, array('user_id' => $user->getId()));
        }
        else
        {
            // The user does not exist: insert it
            $this->getDb()->insert('t_user', $userData);
            
            // Gets the id of the newly created user and sets it in the entity
            $id = $this->getDb()->lastInsertId();
            $user->setId($id);
        }
    }
    
    /**
     * @inheritDoc
     */
    public function loadUserByUsername($username) {
        $sql = "select * from t_user where user_name=?";
        $row = $this->getDb()->fetchAssoc($sql, array($username));

        if ($row)
        {
            return $this->buildDomainObject($row);
        }
        else
        {
            throw new UsernameNotFoundException(sprintf('User "%s" not found.', $username));
        }
    }
    
    /**
     * @inheritDoc
     */
    public function refreshUser(UserInterface $user) {
        $class = get_class($user);
        if (!$this->supportsClass($class))
        {
            throw new UnsupportedUserException(sprintf('Instances of "%s" are not supported.', $class));
        }
        return $this->loadUserByUsername($user->getUsername());

    }
    
    /**
     * @inheritDoc
     */
    public function supportsClass($class) {
        return 'WebLinks\Domain\User' === $class;
    }
    
    /**
     * Removes an user from the database
     * 
     * @param int $id The user id
     */
    public function delete($id)
    {
        // Efface l'utilisateur
        $this->getDb()->delete('t_user', array('user_id' => $id));
    }
    
    /**
     * Builds a User object based on a DB row
     * 
     * @param array $row The DB row containing User data
     * @return \WebLinks\Domain\User
     */
    protected function buildDomainObject($row)
    {
        $user = New User();
        $user->setId($row['user_id']);
        $user->setUsername($row['user_name']);
        $user->setPassword($row['user_password']);
        $user->setSalt($row['user_salt']);
        $user->setRole($row['user_role']);
        
        return $user;
    }
}
