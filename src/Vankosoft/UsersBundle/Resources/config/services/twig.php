<?php namespace Symfony\Component\DependencyInjection\Loader\Configurator;

use Vankosoft\UsersBundle\Twig\FunctionsExtension;

return static function ( ContainerConfigurator $container ): void
{
    $services   = $container->services();
    
    $services->defaults()
        ->autowire()
        ->autoconfigure()
        ->public();
    
    $services->set( FunctionsExtension::class )
        ->tag( 'twig.extension' )
        ->args([
            service( 'vs_users.security_bridge' ),
        ]);
};
