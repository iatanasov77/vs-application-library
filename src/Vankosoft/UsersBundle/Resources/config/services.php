<?php namespace Symfony\Component\DependencyInjection\Loader\Configurator;

return static function( ContainerConfigurator $container ): void
{
    $services   = $container->services();
    
    $container->import( 'services/controller.php' );
    $container->import( 'services/security.php' );
    $container->import( 'services/registration.php' );
    //$container->import( 'services/reset_password.php' );
    $container->import( 'services/user_management.php' );
    $container->import( 'services/user_profile.php' );
    $container->import( 'services/twig.php' );
    
    $services->defaults()
        ->autowire()
        ->autoconfigure()
        ->public();
};
