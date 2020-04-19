<?php namespace VS\ApplicationBundle\Model;

use Doctrine\ORM\Mapping as ORM;
use IA\CmsBundle\Entity\Page;

class SiteSettings extends Settings
{
    /**
     * @ORM\ManyToOne(targetEntity="SettingsSite", inversedBy="settings")
     */
    private $site;
    
    public function getSite(): ?SettingsSite
    {
        return $this->site;
    }
    
    public function setSite(?SettingsSite $site): self
    {
        $this->site = $site;
        if ( $site ) {
            $this->site_id = $site->getId();
            
        }
        return $this;
    }
}
