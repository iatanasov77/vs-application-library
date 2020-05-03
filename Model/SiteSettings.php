<?php namespace VS\ApplicationBundle\Model;

use Doctrine\ORM\Mapping as ORM;
use IA\CmsBundle\Entity\Page;

class SiteSettings extends Settings
{
    /** @var mixed */
    protected $id;
    
    /** @var TaxonInterface */
    protected $site;
    
    /**
     * /** @var SettingsInterface */
     * @ORM\ManyToOne(targetEntity="SettingsSite", inversedBy="settings")
     */
    protected $settings;
    
    
    
    public function getSite():  ?TaxonInterface
    {
        return $this->site;
    }
    
    public function setSite( ?TaxonInterface $site): self
    {
        $this->site = $site;
        if ( $site ) {
            $this->site_id = $site->getId();
            
        }
        return $this;
    }
    
    public function __toString()
    {
        return $this->site ? $this->site->getName() : '';
    }
}
