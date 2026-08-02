<?php namespace Symfony\Component\DependencyInjection\Loader\Configurator;

use Vankosoft\UsersBundle\Component\UserNotifications;
use Vankosoft\UsersBundle\Controller\UsersNotificationsController;
use Vankosoft\UsersBundle\Controller\UsersActivitiesController;

return static function ( ContainerConfigurator $container ): void
{
    $services   = $container->services();
    
    $services->defaults()
        ->autowire()
        ->autoconfigure()
        ->public();
    
    $services->set( 'vs_users.notifications', UserNotifications::class )
        ->args([
            service( 'vs_users.repository.user_roles' ),
            service( 'vs_users.factory.user_notification' ),
            service( 'doctrine.orm.entity_manager' ),
        ]);
    
    $services->set( UsersNotificationsController::class )
        ->tag( 'controller.service_arguments' )
        ->args([
            service( 'doctrine' ),
            service( 'twig' ),
            service( 'vs_users.security_bridge' ),
            service( 'vs_users.repository.user_notification' ),
        ])
        ->call( 'setContainer', [service( 'service_container' )] );
    
    $services->set( UsersActivitiesController::class )
        ->tag( 'controller.service_arguments' )
        ->args([
            service( 'doctrine' ),
            service( 'vs_users.security_bridge' ),
        ])
        ->call( 'setContainer', [service( 'service_container' )] );
};
