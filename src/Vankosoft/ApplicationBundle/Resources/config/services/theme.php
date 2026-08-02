<?php namespace Symfony\Component\DependencyInjection\Loader\Configurator;

use Vankosoft\ApplicationBundle\EventListener\ThemeChangeListener;

return static function ( ContainerConfigurator $container ): void
{
    $services   = $container->services();

    $services->defaults()
        ->autowire()
        ->autoconfigure()
        ->public();

    $services->alias( 'vs_app.theme_repository', 'sylius.repository.theme' );
    
    $services->set( 'vs_app.listener.theme_change', ThemeChangeListener::class )
        ->args([
            service( 'sylius.theme.context.settable' ),
            service( 'sylius.repository.theme' ),
            service( 'vs_application.repository.settings' ),
            service( 'vs_application.context.application' ),
        ])
        ->tag( 'kernel.event_listener', ['event' => 'kernel.request', 'method' => 'onKernelRequest'] );
};
