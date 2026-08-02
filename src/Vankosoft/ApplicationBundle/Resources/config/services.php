<?php namespace Symfony\Component\DependencyInjection\Loader\Configurator;

return static function( ContainerConfigurator $container ): void
{
    $services   = $container->services();
    $parameters = $container->parameters();
    
    $container->import( 'services/application.php' );
    $container->import( 'services/controller.php' );
    $container->import( 'services/settings.php' );
    $container->import( 'services/form.php' );
    $container->import( 'services/maintenance.php' );
    $container->import( 'services/theme.php' );
    $container->import( 'services/menu.php' );
    $container->import( 'services/i18n.php' );
    $container->import( 'services/doctrine_extensions.php' );
    $container->import( 'services/commands.php' );
    $container->import( 'services/web_profiler.php' );
    $container->import( 'services/repository.php' );
    $container->import( 'services/twig.php' );
    $container->import( 'services/sylius_resource.php' );
    $container->import( 'services/widgets.php' );

    $parameters
        ->set( 'applicationIcon', 'build/default/images/superman.svg' )
        ->set( 'applicationTitle', 'vs_application.template.super_admin_panel' )
        ->set( 'hasTopSearch', true )
        
        ->set( 'vs_application.version', \Vankosoft\ApplicationBundle\Component\Application\Kernel::VERSION )
        ->set( 'vs_application.public_dir', '%kernel.project_dir%/public/admin-panel' )
        ->set( 'vs_application.supress_pdo_exception', false )
        ->set( 'vs_application.page_categories.taxonomy_code', 'page-categories' )
        ->set( 'vs_application.document_categories.taxonomy_code', 'document-categories' )
        ->set( 'vs_application.user_roles.taxonomy_code', 'user-roles' )
        ->set( 'vs_application.tags_whitelist_contexts.taxonomy_code', 'tags-whitelist-contexts' )
        ->set( 'vs_application.widgets_groups.taxonomy_code', 'widgets-groups' )
        ->set( 'vs_application.sliders.taxonomy_code', 'sliders' )
        ->set( 'vs_application.banner_places.taxonomy_code', 'banner-places' )
        ->set( 'vs_application.mailer_user', 'env(resolve:MAILER_USER)' )
        ->set( 'vs_application.app_host', 'env(resolve:HOST)' )
    ;
    
    $services->defaults()
        ->autowire()
        ->autoconfigure()
        ->public();
};
