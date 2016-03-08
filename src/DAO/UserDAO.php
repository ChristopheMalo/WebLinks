<?php

namespace WebLinks\DAO;

use WebLinks\Domain\User;

/**
 * Access to author's data 
 *
 * @author      Christophe Malo
 * @version     1.0.0
 * @copyright   OpenClassrooms - Baptiste Pesquet
 */

class UserDAO extends DAO
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
        
        return $user;
    }
}
