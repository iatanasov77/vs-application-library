<?php namespace VS\ApplicationBundle\Model\Interfaces;

use Sylius\Component\Resource\Model\ResourceInterface;

interface SettingsInterface extends ResourceInterface
{
    public function getMaintenanceMode();
    public function getMaintenancePage(): ?PageInterface;
    public function getLanguages();
    public function getTheme();
}
