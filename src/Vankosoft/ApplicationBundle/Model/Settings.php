<?php namespace Vankosoft\ApplicationBundle\Model;

use Vankosoft\ApplicationBundle\Model\Interfaces\SettingsInterface;
use Vankosoft\ApplicationBundle\Model\Interfaces\ApplicationInterface;
use Vankosoft\CmsBundle\Model\Interfaces\PageInterface;

class Settings implements SettingsInterface
{   
    /** @var integer */
    protected $id;
    
    /** @var string */
    protected $theme;
    
    /** @var ApplicationInterface */
    protected $application;
    
    public function getId()
    {
        return $this->id;
    }
    
    public function setTheme( $theme )
    {
        $this->theme    = $theme;
        
        return $this;
    }
    
    public function getTheme()
    {
        return $this->theme;
    }
    
    public function getApplication()
    {
        return $this->application;
    }
    
    public function setApplication( $application ) : self
    {
        $this->application  = $application;
        
        return $this;
    }
}
