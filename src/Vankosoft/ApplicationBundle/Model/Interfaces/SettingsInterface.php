<?php namespace Vankosoft\ApplicationBundle\Model\Interfaces;

use Sylius\Component\Resource\Model\ResourceInterface;

interface SettingsInterface extends ResourceInterface
{
    public function getApplication();
    public function getTheme();
}
