<?php namespace Symfony\Component\DependencyInjection\Loader\Configurator;

use Vankosoft\ApplicationBundle\EventSubscriber\LocaleSubscriber;
use Vankosoft\ApplicationBundle\EventSubscriber\UserLocaleSubscriber;

return static function ( ContainerConfigurator $container ): void
{
    $services   = $container->services();

    $services->defaults()
        ->autowire()
        ->autoconfigure()
        ->public();
    
    $services->set( 'vs_app.subscriber.locale', LocaleSubscriber::class )
        ->args([
            param( 'kernel.default_locale' ),
        ])
        ->tag( 'kernel.event_subscriber' );
    
    $services->set( 'vs_app.subscriber.user_locale', UserLocaleSubscriber::class )
        ->tag( 'kernel.event_subscriber' );
};
