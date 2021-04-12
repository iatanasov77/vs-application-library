<?php namespace VS\ApplicationBundle\Model;

use VS\ApplicationBundle\Model\Interfaces\SiteInterface;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;

class Site implements SiteInterface
{   
    /** @var integer */
    protected $id;
    
    /** @var Collection|Settings[] */
    protected $settings;
    
    /** @var string */
    protected $title;
    
    public function __construct()
    {
        $this->settings = new ArrayCollection();
    }
    
    public function getId()
    {
        return $this->id;
    }
    
    public function getSettings() : Collection
    {
        return $this->settings;
    }
    
    public function getTitle()
    {
        return $this->title;
    }
    
    public function setTitle($title): self
    {
        $this->title = $title;
        
        return $this;
    }
}
