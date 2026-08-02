<?php namespace Symfony\Component\DependencyInjection\Loader\Configurator;

use Vankosoft\ApplicationBundle\EventSubscriber\ResourceActionSubscriber;

return static function ( ContainerConfigurator $container ): void
{
    $services   = $container->services();
    
    $services->defaults()
        ->autowire()
        ->autoconfigure()
        ->public();
    
    $services->set( 'vs_application.resource_action_subscriber', ResourceActionSubscriber::class )
        ->args([
            service( 'vs_users.factory.user_activity' ),
            service( 'doctrine.orm.entity_manager' ),
            service( 'security.token_storage' ),
        ])
        ->tag( 'kernel.event_subscriber' );
};
