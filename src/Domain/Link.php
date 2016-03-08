<?php

namespace WebLinks\Domain;

/**
 * Class representing a Link
 *
 * @author      Christophe Malo
 * @version     1.0.0
 * @copyright   OpenClassrooms - Baptiste Pesquet
 */

class Link 
{
    /**
     * Link id
     *
     * @var integer
     */
    private $id;

    /**
     * Link title
     *
     * @var string
     */
    private $title;

    /**
     * Link url
     *
     * @var string
     */
    private $url;
    
    /**
     * Link author
     * 
     * @var \WebLinks\Domain\User
     */
    private $author;

    
    
    
    /**
     * Returns link id
     * 
     * @return integer $id The link id
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Returns link title
     * 
     * @return string $title The link title
     */
    public function getTitle()
    {
        return $this->title;
    }
    
    /**
     * Returns link url
     * 
     * @return string $url The link url
     */
    public function getUrl()
    {
        return $this->url;
    }
    
    /**
     * Returns link author
     * 
     * @return \WebLinks\Domain\User The link author
     */
    public function getAuthor()
    {
        return $this->author;
    }

    
    
    
    /**
     * Sets link id
     * 
     * @param int $id
     * @return void
     */
    public function setId($id)
    {
        $this->id = $id;
    }
    
    /**
     * Sets link title
     * 
     * @param string $title
     * @return void
     */
    public function setTitle($title)
    {
        $this->title = $title;
    }

    /**
     * Sets link url
     * 
     * @param string $url
     * @return void
     */
    public function setUrl($url)
    {
        $this->url = $url;
    }
    
    /**
     * Sets link author
     * 
     * @param \WebLinks\Domain\User $author
     * @return void
     */
    public function setAuthor(User $author)
    {
        $this->author = $author;
    }
}
