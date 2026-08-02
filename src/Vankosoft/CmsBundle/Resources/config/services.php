<?php namespace Symfony\Component\DependencyInjection\Loader\Configurator;

return static function( ContainerConfigurator $container ): void
{
    $services   = $container->services();
    
    //$container->import( 'services/resources.php' );
    $container->import( 'services/controller.php' );
    $container->import( 'services/form.php' );
    $container->import( 'services/uploader.php' );
    
    $services->defaults()
        ->autowire()
        ->autoconfigure()
        ->public();
};
