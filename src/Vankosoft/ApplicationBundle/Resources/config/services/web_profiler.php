<?php namespace Symfony\Component\DependencyInjection\Loader\Configurator;

use Vankosoft\ApplicationBundle\DataCollector\VsApplicationCollector;
use Vankosoft\ApplicationBundle\DataCollector\ApplicationCollector;

return static function ( ContainerConfigurator $container ): void
{
    $services   = $container->services();
    
    $services->defaults()
        ->autowire()
        ->autoconfigure()
        ->public();

    $services->set( 'vs_application.data_collector.core', VsApplicationCollector::class )
        ->args([
            service( 'vs_application.project_type' ),
            service( 'vs_application.repository.locale' ),
            service( 'vs_application_instalator.repository.instalation_info' ),
            param( 'vs_application.version' ),
            param( 'kernel.bundles' ),
            param( 'locale' ),
        ])
        ->tag( 'data_collector', ['id' => 'vs_application.core_collector', 'template' => '@VSApplication/DataCollector/vs_application.html.twig'] );
    
    $services->set( 'vs_application.data_collector.application', ApplicationCollector::class )
        ->args([
            service( 'vs_application.repository.application' ),
            service( 'vs_application.context.application' ),
        ])
        ->tag( 'data_collector', ['id' => 'vs_application.application_collector', 'template' => '@VSApplication/DataCollector/application.html.twig'] );
};
