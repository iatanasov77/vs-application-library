<?php namespace VS\ApplicationBundle\Model\Interfaces;

use Sylius\Component\Resource\Model\ResourceInterface;
use Sylius\Component\Taxonomy\Model\TaxonInterface;

interface SiteSettingsInterface extends ResourceInterface
{
    public function getSettings(): ?SettingsInterface;
    
    public function setSettings( ?SettingsInterface $settings ): SiteSettingsInterface;
    
    public function getSite(): ?TaxonInterface;
    
    public function setSite( ?TaxonInterface $site ): SiteSettingsInterface;
}
