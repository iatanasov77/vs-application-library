<?php namespace Symfony\Component\DependencyInjection\Loader\Configurator;

use Vankosoft\ApplicationInstalatorBundle\Command\InstallCommand;
use Vankosoft\ApplicationInstalatorBundle\Command\CheckRequirementsCommand;
use Vankosoft\ApplicationInstalatorBundle\Command\InstallDatabaseCommand;
use Vankosoft\ApplicationInstalatorBundle\Command\InstallApplicationConfigurationCommand;
use Vankosoft\ApplicationInstalatorBundle\Command\SetupSuperAdminApplicationCommand;
use Vankosoft\ApplicationInstalatorBundle\Command\SetupApplicationsCommand;
use Vankosoft\ApplicationInstalatorBundle\Command\CreateApplicationUserCommand;
use Vankosoft\ApplicationInstalatorBundle\Command\InstallAssetsCommand;
use Vankosoft\ApplicationInstalatorBundle\Command\InstallSampleDataCommand;
use Vankosoft\ApplicationInstalatorBundle\Command\InstallExtendedSampleDataCommand;
use Vankosoft\ApplicationInstalatorBundle\Command\SetupFinalizeCommand;

return static function ( ContainerConfigurator $container ): void
{
    $services   = $container->services();
    
    $services->defaults()
        ->autowire()
        ->autoconfigure()
        ->public();
    
    $services->set( 'vs_app.command.install', InstallCommand::class )
        ->args([
            service( 'service_container' ),
            service( 'doctrine' ),
            service( 'validator' ),
        ])
        ->tag( 'console.command' );
    
    $services->set( 'vs_app.command.check_requirements', CheckRequirementsCommand::class )
        ->args([
            service( 'service_container' ),
            service( 'doctrine' ),
            service( 'validator' ),
        ])
        ->tag( 'console.command' );
    
    $services->set( 'vs_app.command.install.database', InstallDatabaseCommand::class )
        ->args([
            service( 'service_container' ),
            service( 'doctrine' ),
            service( 'validator' ),
        ])
        ->tag( 'console.command' );
    
    $services->set( 'vs_app.command.install.application_configuration', InstallApplicationConfigurationCommand::class )
        ->args([
            service( 'service_container' ),
            service( 'doctrine' ),
            service( 'validator' ),
        ])
        ->tag( 'console.command' );
    
    $services->set( 'vs_app.command.install.setup_super_admin', SetupSuperAdminApplicationCommand::class )
        ->args([
            service( 'service_container' ),
            service( 'doctrine' ),
            service( 'validator' ),
        ])
        ->tag( 'console.command' );
    
    $services->set( 'vs_app.command.install.setup_applications', SetupApplicationsCommand::class )
        ->args([
            service( 'service_container' ),
            service( 'doctrine' ),
            service( 'validator' ),
        ])
        ->tag( 'console.command' );
    
    $services->set( 'vs_app.command.install.application_user', CreateApplicationUserCommand::class )
        ->args([
            service( 'service_container' ),
            service( 'doctrine' ),
            service( 'validator' ),
            service( 'file_locator' ),
            service( 'vs_cms.profile_uploader' ),
        ])
        ->tag( 'console.command' );
    
    $services->set( 'vs_app.command.install.assets', InstallAssetsCommand::class )
        ->args([
            service( 'service_container' ),
            service( 'doctrine' ),
            service( 'validator' ),
        ])
        ->tag( 'console.command' );
    
    $services->set( 'vs_app.command.install.sample_data', InstallSampleDataCommand::class )
        ->args([
            service( 'service_container' ),
            service( 'doctrine' ),
            service( 'validator' ),
        ])
        ->tag( 'console.command' );
    
    $services->set( 'vs_app.command.install.extended_sample_data', InstallExtendedSampleDataCommand::class )
        ->args([
            service( 'service_container' ),
            service( 'doctrine' ),
            service( 'validator' ),
        ])
        ->tag( 'console.command' );
    
    $services->set( 'vs_app.command.install.finalize_setup', SetupFinalizeCommand::class )
        ->args([
            service( 'service_container' ),
            service( 'doctrine' ),
            service( 'validator' ),
        ])
        ->tag( 'console.command' );
};
