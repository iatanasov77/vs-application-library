<?php namespace Vankosoft\ApplicationBundle\Model\Interfaces;

use Sylius\Component\Locale\Model\LocaleInterface as BaseLocaleInterface;

interface LocaleInterface extends BaseLocaleInterface, TranslatableInterface
{
    public function getActive(): bool;
    public function isActive(): bool;
    public function setTranslatableLocale( $locale ): LocaleInterface;
    public function getTitle();
}
