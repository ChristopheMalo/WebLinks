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

class UserDAO
{
    public function find($id)
    {
        $sql = "SELECT user_id, user_name WHERE user_id=?";
        $row = $this->getDb()->fetchAssoc($sql, array($id));
        
        if ($row)
        {
            return $this->buildObjectDomain($row);
        }
        else
        {
            throw new \Exception('No user matching id ' . $id);
        }
    }
    
    protected function buildObjectDomain($row)
    {
        $user = New User();
        $user->setId($row['user_id']);
        $user->setUsername($row['user_name']);
        
        return $user;
    }
}
