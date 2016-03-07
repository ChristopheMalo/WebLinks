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
     * Returns a list of all links, sorted by id.
     *
     * @return array A list of all links.
     */
    public function findAll() {
        $sql = "select * from t_link order by link_id desc";
        $result = $this->getDb()->fetchAll($sql);
        
        // Convert query result to an array of domain objects
        $links = array();
        foreach ($result as $row) {
            $id = $row['link_id'];
            $links[$id] = $this->buildDomainObject($row);
        }
        return $links;
    }

    /**
     * Creates an Link object based on a DB row.
     *
     * @param array $row The DB row containing Link data.
     * @return \WebLinks\Domain\Link $links
     */
    protected function buildDomainObject($row) {
        $link = new Link();
        $link->setId($row['link_id']);
        $link->setUrl($row['link_title']);
        $link->setTitle($row['link_url']);
        
        return $link;
    }
}
