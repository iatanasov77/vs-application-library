<?php namespace Symfony\Component\DependencyInjection\Loader\Configurator;

use Vankosoft\ApplicationBundle\Twig\Alerts;
use Vankosoft\ApplicationBundle\EventSubscriber\MaintenanceSubscriber;

return static function ( ContainerConfigurator $container ): void
{
    $services   = $container->services();
    $parameters = $container->parameters();

    $parameters
        ->set( 'vs_application.maintenance_template', 'maintenance.html.twig' )
    ;
    
    $services->defaults()
        ->autowire()
        ->autoconfigure()
        ->public();

    $services->set( 'vs_app.twig.alerts', Alerts::class );

    $services->set( 'vs_app.subscriber.maintenance', MaintenanceSubscriber::class )
        ->args([
            service( 'twig' ),
            param( 'vs_application.maintenance_template' ),
        ])
        ->tag( 'kernel.event_subscriber' );
};
