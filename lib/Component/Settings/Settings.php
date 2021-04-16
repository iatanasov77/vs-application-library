<?php namespace VS\ApplicationBundle\Component\Settings;

use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\Cache\Adapter\FilesystemAdapter;
use Symfony\Component\PropertyAccess\PropertyAccess;
use Symfony\Component\PropertyAccess\PropertyAccessor;

use VS\ApplicationBundle\Component\Exception\SettingsException;

class Settings
{
    private ContainerInterface $container;
    
    private FilesystemAdapter $cache;
    
    private PropertyAccessor $propertyAccessor;
    
    private array $settingsKeys;
    
    public function __construct( ContainerInterface $container )
    {
        $this->container        = $container;
        $this->cache            = new FilesystemAdapter();
        $this->propertyAccessor = PropertyAccess::createPropertyAccessor();
        $this->settingsKeys     = ['maintenanceMode', 'maintenancePage', 'theme'];
    }
    
    public function getSettings( $siteId )
    {
        $cacheId    = $siteId ? "settings_site_{$siteId}" : 'settings_general';
        
        $settingsCache  = $this->cache->getItem( $cacheId );
        if ( ! $settingsCache->isHit() ) {
            $settings   = $siteId ? $this->generalizeSettings( $siteId ) : $this->generalSettings();
            
            $settingsCache->set( json_encode( $settings ) );
            $this->cache->save( $settingsCache );
        } else {
            $settings   = json_decode( $settingsCache->get(), true );
        }
        
        return $settings;
    }
    
    public function clearCache( $siteId, $all = false )
    {
        if ( $all ) {
            $sites  = $this->getSiteRepository()->findAll();
            foreach ( $sites as $site ) {
                $this->cache->deleteItem( "settings_site_{$site->getId()}" );
            }
            
            $this->cache->deleteItem( 'settings_general' );
        } else {
            $cacheId    = $siteId ? "settings_site_{$siteId}" : 'settings_general';
            
            $this->cache->deleteItem( $cacheId );
        }
    }
    
    public function forceMaintenanceMode( bool $maintenanceMode )
    {
        // Sites Settings
        $sites  = $this->getSiteRepository()->findAll();
        foreach ( $sites as $site ) {
            $settings   = $this->getSettings( $site->getId() );
            $settings['maintenanceMode']    = $maintenanceMode;
            
            $settingsCache  = $this->cache->getItem( "settings_site_{$site->getId()}" );
            $settingsCache->set( json_encode( $settings ) );
            $this->cache->save( $settingsCache );
        }
        
        // General Settings
        $settings   = $this->getSettings( null );
        $settings['maintenanceMode']    = $maintenanceMode;
        
        $settingsCache  = $this->cache->getItem( 'settings_general' );
        $settingsCache->set( json_encode( $settings ) );
        $this->cache->save( $settingsCache );
    }
    
    private function generalizeSettings( $siteId ) : array
    {
        $site   = $this->getSiteRepository()->find( $siteId );
        if ( ! $site ) {
            throw new SettingsException( "Site With ID:{$siteId} Not Exists!" );
        }
        
        $generalSettings    = $this->getSettingsRepository()->getSettings();
        $siteSettings       = $this->getSettingsRepository()->getSettings( $site );
        //var_dump( $generalSettings ); die;
        
        $generalizedSettings    = [];
        foreach( $this->settingsKeys as $key ) {
            $value  = $siteSettings ? $this->propertyAccessor->getValue( $siteSettings, $key ) : null;
            if ( $value === null ) {
                $value  = $this->propertyAccessor->getValue( $generalSettings, $key );
            }
            
            $generalizedSettings[$key]  = is_object( $value ) ? $value->getId() : $value;
        }
  
        return $generalizedSettings;
    }
    
    private function generalSettings() : array
    {
        $generalSettings    = $this->getSettingsRepository()->getSettings();
        //var_dump( $generalSettings ); die;
        
        $settings    = [];
        foreach( $this->settingsKeys as $key ) {
            $value          = $this->propertyAccessor->getValue( $generalSettings, $key );
            $settings[$key] = is_object( $value ) ? $value->getId() : $value;
        }
        
        return $settings;
    }
    
    private function getSiteRepository()
    {
        return $this->container->get( 'vs_application.repository.site' );
    }
    
    private function getSettingsRepository()
    {
        return $this->container->get( 'vs_application.repository.settings' );
    }
}
