<?php namespace Symfony\Component\DependencyInjection\Loader\Configurator;

return static function( ContainerConfigurator $container ): void
{
    $services   = $container->services();
    $parameters = $container->parameters();
    
    $container->import( 'services/commands.php' );
    $container->import( 'services/commands_installer.php' );
    $container->import( 'services/installer.php' );
    $container->import( 'services/installer_requirements.php' );
    $container->import( 'services/fixtures_factories.php' );
    $container->import( 'services/fixtures_listeners.php' );
    $container->import( 'services/fixtures.php' );

    $parameters
        ->set( 'test_parameter', 'TEST' )
    ;
    
    $services->defaults()
        ->autowire()
        ->autoconfigure()
        ->public();
};
