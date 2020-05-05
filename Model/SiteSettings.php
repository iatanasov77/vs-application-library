<?php namespace VS\ApplicationBundle\Model;

use VS\ApplicationBundle\Model\Interfaces\SiteSettingsInterface;
use VS\ApplicationBundle\Model\Interfaces\SettingsInterface;
use Sylius\Component\Taxonomy\Model\TaxonInterface;

class SiteSettings implements SiteSettingsInterface
{
    /** @var mixed */
    protected $id;
    
    /** @var TaxonInterface */
    protected $site;
    
    /** @var SettingsInterface */
    protected $settings;
    
    public function getId()
    {
        return $this->id;
    }
    
    public function getSite():  ?TaxonInterface
    {
        return $this->site;
    }
    
    public function setSite( ?TaxonInterface $site): SiteSettingsInterface
    {
        $this->site = $site;
        
        return $this;
    }
    
    public function getSettings():  ?SettingsInterface
    {
        return $this->settings;
    }
    
    public function setSettings( ?SettingsInterface $settings): SiteSettingsInterface
    {
        $this->settings = $settings;
        
        return $this;
    }
    
    
    public function __toString()
    {
        return $this->site ? $this->site->getName() : '';
    }
}
