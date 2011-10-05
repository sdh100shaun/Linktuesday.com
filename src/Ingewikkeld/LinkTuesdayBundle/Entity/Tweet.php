<?php

namespace Ingewikkeld\LinkTuesdayBundle\Entity;

use Ingewikkeld\LinkTuesdayBundle\Entity\Link;

/**
 * @orm:Entity
 */
class Tweet
{
    /**
     * @var integer
     *
     * @orm:Id
     * @orm:Column(type="integer")
     * @orm:GeneratedValue(strategy="IDENTITY")
     */
    protected $id;

    /**
     * @var string
     *
     * @orm:Column(type="string", length="255")
     */
    protected $uri;

    /**
     * @var string
     *
     * @orm:Column(type="string", length="255")
     */
    protected $content;

    /**
     * @var string
     *
     * @orm:Column(type="string", length="25")
     */
    protected $user;

    /**
     * @var string
     *
     * @orm:Column(type="string", length="255")
     */
    protected $profile_image;

    /**
     * @var \DateTime
     *
     * @orm:Column(type="datetime")
     */
    protected $date;

    /**
     * @var array
     *
     * @orm:ManyToOne(targetEntity="Link", inversedBy="tweet")
     * @orm:JoinColumn(name="link_id", referencedColumnName="id", onDelete="CASCADE")
     */
    protected $link;

    public function getId()
    {
        return $this->id;
    }

    public function setId($id)
    {
        $this->id = $id;
    }

    public function getUri()
    {
        return $this->uri;
    }

    public function setUri($uri)
    {
        $this->uri = $uri;
    }

    public function getContent()
    {
        return $this->content;
    }

    public function setContent($content)
    {
        $this->content = $content;
    }

    public function getLink()
    {
        return $this->link;
    }

    public function setLink(Link $link)
    {
        $this->link = $link;
    }

    public function getUser()
    {
        return $this->user;
    }

    public function setUser($user)
    {
        $this->user = $user;
    }

    public function getProfileImage()
    {
        return $this->profile_image;
    }

    public function setProfileImage($profile_image)
    {
        $this->profile_image = $profile_image;
    }

    public function setDate(\DateTime $date)
    {
        $this->date = $date;
    }

    public function getDate()
    {
        return $this->date;
    }

    public function getDisplayDate()
    {
      return $this->date->format('c');
    }
    
}