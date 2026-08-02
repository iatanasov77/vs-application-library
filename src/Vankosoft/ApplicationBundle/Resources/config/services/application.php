<?php namespace Symfony\Component\DependencyInjection\Loader\Configurator;

use Vankosoft\ApplicationBundle\Component\Application\Project;
use Vankosoft\ApplicationBundle\Component\Context\HostnameBasedRequestResolver;
use Vankosoft\ApplicationBundle\Component\Context\ApplicationContext;

use Vankosoft\ApplicationBundle\Component\Application\Project;
use Vankosoft\ApplicationBundle\Component\Context\ApplicationContext;
use Vankosoft\ApplicationBundle\Component\Context\ApplicationContextInterface;

use Vankosoft\ApplicationBundle\EventListener\ExceptionListener;
use Vankosoft\ApplicationBundle\Component\SlugGenerator;
use Vankosoft\ApplicationBundle\Component\VsDoctrineDbalCache;
use Vankosoft\ApplicationBundle\Component\ComposerInfo\ComposerInfo;
use Vankosoft\ApplicationBundle\Component\Application\VersionInfo;

return static function ( ContainerConfigurator $container ): void
{
    $services   = $container->services();
    $parameters = $container->parameters();

    $parameters
        ->set( 'vs_application.doctrine_dbal_cache_dsn', 'env(resolve:DATABASE_URL)' )
    ;
    
    $services->defaults()
        ->autowire()
        ->autoconfigure()
        ->public();

    $services->set( 'vs_application.project_type', Project::class )
        ->args([
            param( 'vs_application.project_type' ),
        ]);
    
    $services->set( 'vs_application.context.application.hostname_based_request_resolver', HostnameBasedRequestResolver::class )
        ->args([
            service( 'vs_application.repository.application' ),
        ])
        ->tag( 'vs_application.context.application.request_based_resolver' );
    
    $services->set( 'vs_application.context.application', ApplicationContext::class )
        ->args([
            service( 'vs_application.context.application.hostname_based_request_resolver' ),
            service( 'request_stack' ),
            param( 'vs_application.app_host' ),
        ])
        ->tag( 'vs_application.context.application' );
    
    // Create Aliases for Autowiring
    $services->alias( Project::class, 'vs_application.project_type' );
    $services->alias( ApplicationContext::class, 'vs_application.context.application' );
    $services->alias( ApplicationContextInterface::class, ApplicationContext::class );
    
    $services->set( 'vs_application.exception_listener', ExceptionListener::class )
        ->args([
            service( 'twig' ),
        ])
        ->tag( 'kernel.event_listener', ['event' => 'kernel.exception', 'method' => 'onKernelException'] );
    
    $services->set( 'vs_application.slug_generator', SlugGenerator::class )
        ->args([
            service( 'request_stack' ),
        ]);
    
    $services->set( 'vs_application.doctrine_dbal_cache', VsDoctrineDbalCache::class )
        ->args([
            param( 'vs_application.doctrine_dbal_cache_dsn' ),
        ]);
    
    $services->set( 'vs_application.composer_info', ComposerInfo::class )
        ->args([
            param( 'kernel.project_dir' ),
        ]);
    
    $services->set( 'vs_application.version_info', VersionInfo::class )
        ->args([
            service( 'vs_application_instalator.repository.instalation_info' ),
            service( 'vs_application_instalator.factory.instalation_info' ),
            param( 'kernel.project_dir' ),
        ]);
};
