<?php namespace Symfony\Component\DependencyInjection\Loader\Configurator;

use Vankosoft\ApplicationInstalatorBundle\Installer\Requirement\SettingsRequirements;
use Vankosoft\ApplicationInstalatorBundle\Installer\Requirement\ExtensionsRequirements;
use Vankosoft\ApplicationInstalatorBundle\Installer\Requirement\FilesystemRequirements;
use Vankosoft\ApplicationInstalatorBundle\Installer\Requirement\ApplicationRequirements;

return static function ( ContainerConfigurator $container ): void
{
    $services   = $container->services();
    
    $services->defaults()
        ->autowire()
        ->autoconfigure()
        ->public();
    
    $services->set( 'vs_app.requirements.settings_requirements', SettingsRequirements::class )
        ->args([
            service( 'translator' ),
        ]);
    
    $services->set( 'vs_app.requirements.extensions_requirements', ExtensionsRequirements::class )
        ->args([
            service( 'translator' ),
        ]);
    
    $services->set( 'vs_app.requirements.filesystem_requirements', FilesystemRequirements::class )
        ->args([
            service( 'translator' ),
            param( 'kernel.cache_dir' ),
            param( 'kernel.logs_dir' ),
        ]);
    
    $services->set( 'vs_app.requirements', ApplicationRequirements::class )
        ->args([
            'requirementCollections' => [
                service( 'vs_app.requirements.settings_requirements' ),
                service( 'vs_app.requirements.extensions_requirements' ),
                service( 'vs_app.requirements.filesystem_requirements' ),
            ],
        ]);
};
