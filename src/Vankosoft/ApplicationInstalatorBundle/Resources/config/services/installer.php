<?php namespace Symfony\Component\DependencyInjection\Loader\Configurator;

use Vankosoft\ApplicationInstalatorBundle\Installer\Checker\CommandDirectoryChecker;
use Vankosoft\ApplicationInstalatorBundle\Installer\Checker\ApplicationRequirementsChecker;
use Vankosoft\ApplicationInstalatorBundle\Installer\Provider\DatabaseSetupCommandsProvider;
use Vankosoft\ApplicationInstalatorBundle\Installer\Setup\LocaleSetup;
use Vankosoft\ApplicationInstalatorBundle\Installer\Setup\ApplicationSetup;

return static function ( ContainerConfigurator $container ): void
{
    $services   = $container->services();
    
    $services->defaults()
        ->autowire()
        ->autoconfigure()
        ->public();
    
    $services->set( 'vs_app.installer.checker.command_directory', CommandDirectoryChecker::class )
        ->args([
            service( 'filesystem' ),
        ]);
    
    $services->set( 'vs_app.installer.checker.application_requirements', ApplicationRequirementsChecker::class )
        ->args([
            service( 'vs_app.requirements' ),
        ]);
    
    $services->set( 'vs_app.commands_provider.database_setup', DatabaseSetupCommandsProvider::class )
        ->args([
            service( 'doctrine' ),
        ]);
    
    $services->set( 'vs_app.setup.locale', LocaleSetup::class )
        ->args([
            service( 'stof_doctrine_extensions.listener.translatable' ),
            service( 'vs_application.repository.locale' ),
            service( 'vs_application.factory.locale' ),
            'en_US'
        ]);
    
    $services->set( 'vs_application.installer.setup_application', ApplicationSetup::class )
        ->args([
            service( 'service_container' ),
            service( 'twig' ),
            service( 'vs_application.slug_generator' ),
        ]);
};
