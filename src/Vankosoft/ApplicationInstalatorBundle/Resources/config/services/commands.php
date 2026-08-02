<?php namespace Symfony\Component\DependencyInjection\Loader\Configurator;

use Vankosoft\ApplicationInstalatorBundle\Command\CreateApplicationCommand;
use Vankosoft\ApplicationInstalatorBundle\Command\ClearInstallCommand;
use Vankosoft\ApplicationInstalatorBundle\Command\BumpVersionCommand;
use Vankosoft\ApplicationInstalatorBundle\Command\AssetsSourcesCommand;
use Vankosoft\ApplicationInstalatorBundle\Command\CheckAssetDependenciesCommand;
use Vankosoft\ApplicationInstalatorBundle\Command\InstallationInfoCommand;
use Vankosoft\ApplicationInstalatorBundle\Command\ProjectVersionSetupDependenciesCommand;
use Vankosoft\ApplicationInstalatorBundle\Command\ProjectVersionSetupDatabaseCommand;

return static function ( ContainerConfigurator $container ): void
{
    $services   = $container->services();
    
    $services->defaults()
        ->autowire()
        ->autoconfigure()
        ->public();
    
    $services->set( 'vs_app.command.create_application', CreateApplicationCommand::class )
        ->args([
            service( 'service_container' ),
            service( 'doctrine' ),
            service( 'validator' ),
        ])
        ->tag( 'console.command' );
    
    $services->set( 'vs_app.command.clear_install', ClearInstallCommand::class )
        ->args([
            service( 'service_container' ),
            service( 'doctrine' ),
            service( 'validator' ),
        ])
        ->tag( 'console.command' );
    
    $services->set( 'vs_app.command.bumpversion', BumpVersionCommand::class )
        ->tag( 'console.command' );
    
    $services->set( 'vs_app.command.assets.sources', AssetsSourcesCommand::class )
        ->args([
            service( 'filesystem' ),
        ])
        ->tag( 'console.command' );
    
    $services->set( 'vs_app.command.assets.dependencies', CheckAssetDependenciesCommand::class )
        ->args([
            service( 'filesystem' ),
        ])
        ->tag( 'console.command' );
    
    $services->set( 'vs_app.command.installation_info', InstallationInfoCommand::class )
        ->args([
            service( 'service_container' ),
            service( 'doctrine' ),
            service( 'validator' ),
        ])
        ->tag( 'console.command' );
    
    $services->set( 'vs_app.command.project-version.setup_dependencies', ProjectVersionSetupDependenciesCommand::class )
        ->args([
            service( 'service_container' ),
            service( 'doctrine' ),
            service( 'validator' ),
            param( 'kernel.project_dir' ),
        ])
        ->tag( 'console.command' );
    
    $services->set( 'vs_app.command.project-version.setup_database', ProjectVersionSetupDatabaseCommand::class )
        ->args([
            service( 'service_container' ),
            service( 'doctrine' ),
            service( 'validator' ),
            param( 'kernel.project_dir' ),
        ])
        ->tag( 'console.command' );
};
