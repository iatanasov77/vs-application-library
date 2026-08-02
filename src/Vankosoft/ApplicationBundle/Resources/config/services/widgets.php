<?php namespace Symfony\Component\DependencyInjection\Loader\Configurator;

use Vankosoft\ApplicationBundle\Component\Widget\WidgetBuilder;
use Vankosoft\ApplicationBundle\Component\Widget\Widget;
use Vankosoft\ApplicationBundle\Twig\Renderer\WidgetRenderer;
use Vankosoft\ApplicationBundle\Twig\WidgetExtension;
use Vankosoft\ApplicationBundle\Controller\WidgetsConfigsController;
use Vankosoft\ApplicationBundle\Controller\WidgetsExtController;
use Vankosoft\ApplicationBundle\Command\LoadWidgetsCommand;
use Vankosoft\ApplicationBundle\EventListener\Widgets\UserInfoWidget;
use Vankosoft\ApplicationBundle\EventListener\Widgets\LocalesMenuWidget;
use Vankosoft\ApplicationBundle\EventListener\Widgets\ApplicationsMenuWidget;

return static function ( ContainerConfigurator $container ): void
{
    $services   = $container->services();
    $parameters = $container->parameters();

    $parameters
        ->set( 'vs_application.widgets.base_template', '@VSApplication/Widgets/widgetBase.html.twig' )
        ->set( 'vs_application.widgets.return_route', 'app_home' )
    ;
    
    $services->defaults()
        ->autowire()
        ->autoconfigure()
        ->public();
    
    /**
     * Widgets Builder Services
     */
    $services->set( 'vs_application.widgets_builder', WidgetBuilder::class )
        ->args([
            service( 'security.token_storage' ),
            service( 'vs_application.repository.widget' ),
            service( 'vs_application.repository.widgets_registry' ),
        ]);
    
    $services->set( 'vs_application.widgets_container', Widget::class )
        ->args([
            service( 'security.helper' ),
            service( 'event_dispatcher' ),
            service( 'vs_application.doctrine_dbal_cache' ),
            service( 'security.token_storage' ),
            service( 'doctrine' ),
            service( 'vs_application.repository.widgets_registry' ),
            service( 'vs_application.factory.widgets_registry' ),
            service( 'vs_application.repository.widget' ),
        ]);
    
    $services->set( 'vs_application.twig_widget_renderer', WidgetRenderer::class )
        ->args([
            service( 'twig' ),
            service( 'vs_application.doctrine_dbal_cache' ),
            service( 'security.token_storage' ),
            param( 'vs_application.widgets.base_template' ),
        ]);
    
    $services->set( WidgetExtension::class )
        ->args([
            service( 'vs_application.twig_widget_renderer' ),
            service( 'vs_application.widgets_builder' ),
            service( 'vs_application.widgets_container' ),
        ]);
    
    $services->set( WidgetsConfigsController::class )
        ->args([
            service( 'vs_application.doctrine_dbal_cache' ),
            service( 'doctrine' ),
            service( 'vs_application.widgets_container' ),
            service( 'vs_application.repository.widgets_registry' ),
            service( 'vs_application.factory.widgets_registry' ),
            service( 'vs_application.repository.widget' ),
            service( 'vs_users.repository.users' ),
        ])
        ->tag( 'controller.service_arguments' );
    
    $services->set( WidgetsExtController::class )
        ->args([
            service( 'vs_users.security_bridge' ),
            service( 'vs_application.repository.widget' ),
            service( 'vs_users.repository.user_roles' ),
        ])
        ->tag( 'controller.service_arguments' );
    
    $services->set( 'vs_application.command.load_widgets', LoadWidgetsCommand::class )
        ->args([
            service( 'vs_users.repository.users' ),
            service( 'vs_application.widgets_container' ),
        ])
        ->tag( 'console.command' );
    
    /**
     * Load Widgets
     */
    $services->set( UserInfoWidget::class )
        ->tag( 'kernel.event_listener', ['event' => ' widget.start', 'method' => 'builder'] );
    
    $services->set( LocalesMenuWidget::class )
        ->args([
            service( 'vs_application.repository.locale' ),
        ])
        ->tag( 'kernel.event_listener', ['event' => ' widget.start', 'method' => 'builder'] );
    
    $services->set( ApplicationsMenuWidget::class )
        ->args([
            service( 'vs_application.repository.application' ),
            service( 'vs_application_instalator.repository.instalation_info' ),
        ])
        ->tag( 'kernel.event_listener', ['event' => ' widget.start', 'method' => 'builder'] );
};
