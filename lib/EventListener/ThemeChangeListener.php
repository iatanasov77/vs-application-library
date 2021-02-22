<?php namespace VS\ApplicationBundle\EventListener;

use Symfony\Component\HttpKernel\Event\GetResponseEvent;
use Sylius\Bundle\ThemeBundle\Context\ThemeContextInterface;
use Sylius\Bundle\ThemeBundle\Repository\ThemeRepositoryInterface;

use VS\ApplicationBundle\Repository\SettingsRepositoryInterface;

class ThemeChangeListener
{
    protected $themeContext;
    protected $themeRepository;
    protected $settingsRepository;
    
    public function __construct(
        ThemeContextInterface $themeContext,
        ThemeRepositoryInterface $themeRepository,
        SettingsRepositoryInterface $settingsRepository
    ) {
        $this->themeContext         = $themeContext;
        $this->themeRepository      = $themeRepository;
        $this->settingsRepository   = $settingsRepository;
    }
    
    public function onKernelRequest(GetResponseEvent $event)
    {
        $settings   = $this->settingsRepository->findBy( [], ['id'=>'DESC'], 1, 0 );
        
        if( isset( $settings[0] ) && $settings[0]->getTheme() ) {
            $theme      = $this->themeRepository->findOneByName( $settings[0]->getTheme() );
            //$theme      = $this->themeRepository->findOneByName( 'vankosoft/test-theme' );
            if ( $theme ) {
                $this->themeContext->setTheme( $theme );
            }
        }
    }
}
