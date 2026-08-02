<?php namespace Symfony\Component\DependencyInjection\Loader\Configurator;

use Knp\Menu\MenuItem;
use Vankosoft\ApplicationBundle\Component\Menu\PathRolesService;
use Vankosoft\ApplicationBundle\Component\Menu\MenuBuilder;

return static function ( ContainerConfigurator $container ): void
{
    $services   = $container->services();
    $parameters = $container->parameters();

    $parameters
        ->set( 'vankosoft_host', 'env(HOST)' )
        ->set( 'vs_application.menu.config_file', '%kernel.project_dir%/config/admin-panel/packages/vs_application.yaml' )
        ->set( 'vs_application.main_menus', ['profileMenu', 'mainSystemMenu', 'mainCmsMenu'] )
    ;
    
    $services->defaults()
        ->autowire()
        ->autoconfigure()
        ->public();

    $services->set( 'vs_application.path_roles_service', PathRolesService::class )
        ->args([
            service( 'security.access_map' ),
        ]);
    
    $services->set( 'vs_app.menu_builder', MenuBuilder::class )
        ->args([
            param( 'vs_application.menu.config_file' ),
            service( 'security.authorization_checker' ),
            service( 'vs_application.path_roles_service' ),
            service( 'router' ),
            service( 'parameter_bag' ),
            service( 'translator' ),
            service( 'request_stack' ),
            param( 'env(APP_ENV)' ),
        ]);
    
    $services->set( 'vs_app.profile_menu', MenuItem::class )
        ->autowire( false )
        ->factory( [service( 'vs_app.menu_builder' ), 'profileMenu'] )
        ->args([
            service( 'knp_menu.factory' ),
        ])
        ->tag( 'knp_menu.menu', ['alias' => 'profile'] );
    
    $services->set( 'vs_app.main_menu_system', MenuItem::class )
        ->autowire( false )
        ->factory( [service( 'vs_app.menu_builder' ), 'mainMenu'] )
        ->args([
            service( 'knp_menu.factory' ),
            'mainSystemMenu'
        ])
        ->tag( 'knp_menu.menu', ['alias' => 'mainSystem'] );
    
    $services->set( 'vs_app.main_menu_cms', MenuItem::class )
        ->autowire( false )
        ->factory( [service( 'vs_app.menu_builder' ), 'mainMenu'] )
        ->args([
            service( 'knp_menu.factory' ),
            'mainCmsMenu'
        ])
        ->tag( 'knp_menu.menu', ['alias' => 'mainCms'] );
    
    $services->set( 'vs_app.breadcrumbs_menu', MenuItem::class )
        ->autowire( false )
        ->factory( [service( 'vs_app.menu_builder' ), 'breadcrumbsMenu'] )
        ->args([
            service( 'knp_menu.factory' ),
            param( 'vs_application.main_menus' ),
        ])
        ->tag( 'knp_menu.menu', ['alias' => 'breadcrumbs'] );
};
