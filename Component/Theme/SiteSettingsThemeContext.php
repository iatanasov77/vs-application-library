<?php namespace VS\ApplicationBundle\Component\Theme;

use Sylius\Bundle\ThemeBundle\Context\ThemeContextInterface;
use Sylius\Bundle\ThemeBundle\Repository\ThemeRepositoryInterface;
use Sylius\Bundle\ThemeBundle\Model\ThemeInterface;
use Sylius\Bundle\ResourceBundle\Doctrine\ORM\EntityRepository;
use VS\ApplicationBundle\Model\Interfaces\SettingsInterface;

final class SiteSettingsThemeContext implements ThemeContextInterface
{
    private $theme;
    
    public function __construct( ThemeRepositoryInterface $themeRepository, EntityRepository $settingsRepository )
    {
        $settings   = $settingsRepository->findBy( [], ['id'=>'DESC'], 1, 0 );
        $themeName  = is_array( $settings ) && isset( $settings[0] ) ? $settings[0]->getTheme() : null;
        
        if ( $themeName ) {
            $this->theme    = $themeRepository->findOneByName( $themeName );
        }
    }
    
    public function getTheme(): ?ThemeInterface
    {
        return $this->theme;
    }
}
