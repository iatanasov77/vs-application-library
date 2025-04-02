<?php namespace Vankosoft\ApplicationBundle\Model;

use Sylius\Component\Locale\Model\Locale as BaseLocale;
use Sylius\Component\Resource\Model\ToggleableTrait;
use Vankosoft\ApplicationBundle\Model\Traits\TranslatableTrait;
use Vankosoft\ApplicationBundle\Model\Interfaces\LocaleInterface;

class Locale extends BaseLocale implements LocaleInterface
{
    use ToggleableTrait;    // About enabled field - $enabled (active)
    use TranslatableTrait;
    
    /** @var bool */
    protected $enabled = true;
    
    /** @var string | null */
    protected $title;
    
    public function __construct()
    {
        $this->fallbackLocale   = 'en_US';
    }
    
    public function getActive(): bool
    {
        return $this->enabled ? true : false;
    }
    
    public function setActive( ?bool $active ): self
    {
        $this->enabled = (bool) $active;
        
        return $this;
    }
    
    public function isActive(): bool
    {
        return $this->enabled ? true : false;
    }
    
    /**
     * There is getName() Method at \Sylius\Component\Locale\Model\Locale
     * 
     * {@inheritDoc}
     * @see \Vankosoft\ApplicationBundle\Model\Interfaces\LocaleInterface::getTitle()
     */
    public function getTitle(): ?string
    {
        return $this->title;
    }
    
    public function setTitle($title): LocaleInterface
    {
        $this->title = $title;
        
        return $this;
    }
}
