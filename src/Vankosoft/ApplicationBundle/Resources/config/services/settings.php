<?php namespace Symfony\Component\DependencyInjection\Loader\Configurator;

use Vankosoft\ApplicationBundle\Component\Settings\Settings;

return static function ( ContainerConfigurator $container ): void
{
    $services   = $container->services();
    
    $services->defaults()
        ->autowire()
        ->autoconfigure()
        ->public();
    
    $services->set( 'vs_app.settings_manager', Settings::class )
        ->args([
            service( 'service_container' ),
            service( 'vs_application.doctrine_dbal_cache' ),
        ]);
};
