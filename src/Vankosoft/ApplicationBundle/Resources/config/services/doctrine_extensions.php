<?php namespace Symfony\Component\DependencyInjection\Loader\Configurator;

use Vankosoft\ApplicationBundle\Component\GedmoListener\LoggableListener;

return static function ( ContainerConfigurator $container ): void
{
    $services   = $container->services();
    
    $services->set( 'stof_doctrine_extensions.listener.loggable', LoggableListener::class )
        ->args([
            param( 'kernel.default_locale' ),
        ])
        ->tag( 'doctrine.event_listener', ['event' => 'onFlush'] )
        ->tag( 'doctrine.event_listener', ['event' => 'loadClassMetadata'] )
        ->tag( 'doctrine.event_listener', ['event' => 'postPersist'] );
};
