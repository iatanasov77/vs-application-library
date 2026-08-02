<?php namespace Symfony\Component\DependencyInjection\Loader\Configurator;

return static function( ContainerConfigurator $container ): void
{
    $parameters = $container->parameters();
    
    $container->import( 'services/maker.php' );
    
    $parameters
        ->set( 'vs_application.supress_pdo_exception', true )
    ;
};
