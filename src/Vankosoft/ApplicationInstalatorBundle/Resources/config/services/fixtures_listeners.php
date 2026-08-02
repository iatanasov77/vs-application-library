<?php namespace Symfony\Component\DependencyInjection\Loader\Configurator;

use Vankosoft\ApplicationInstalatorBundle\DataFixtures\Listener\SampleDataPurgerListener;

return static function ( ContainerConfigurator $container ): void
{
    $services   = $container->services();
    
    $services->defaults()
        ->autowire()
        ->autoconfigure()
        ->public();
    
    $services->set( 'vs_application.fixture.listener.sample_data_purger', SampleDataPurgerListener::class )
        ->args([
            service( 'doctrine' ),
        ])
        ->tag( 'sylius_fixtures.listener' );
};
