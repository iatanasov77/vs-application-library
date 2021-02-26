<?php namespace VS\ApplicationBundle\Model;

use VS\ApplicationBundle\Model\Interfaces\SettingsInterface;
use VS\CmsBundle\Model\PageInterface;
use VS\ApplicationBundle\Model\Interfaces\SiteSettingsInterface;

class Settings implements SettingsInterface
{   
    /** @var integer */
    protected $id;

    /** @var boolean */
    protected $maintenanceMode;
    
    /** @var VS\CmsBundle\Model\PageInterface */
    protected $maintenancePage;
    
    /** @var string */
    protected $theme;
    
    /** @var SiteSettingsInterface */
    protected $site;
    
    public function getId()
    {
        return $this->id;
    }
  
    public function setMaintenanceMode($maintenanceMode)
    {
        $this->maintenanceMode = $maintenanceMode;

        return $this;
    }

    public function getMaintenanceMode()
    {
        return $this->maintenanceMode;
    }
    
    public function getMaintenancePage(): ?PageInterface
    {
        return $this->maintenancePage;
    }
    
    public function setMaintenancePage(?PageInterface $maintenancePage): self
    {
        $this->maintenancePage = $maintenancePage;
        
        return $this;
    }
    
    public function setTheme($theme)
    {
        $this->theme = $theme;
        
        return $this;
    }
    
    public function getTheme()
    {
        return $this->theme;
    }
    
    public function getSite(): ?SiteSettingsInterface
    {
        return $this->site;
    }
    
    public function setSite(?SiteSettingsInterface $site): self
    {
        $this->site = $site;
        
        return $this;
    }
}
