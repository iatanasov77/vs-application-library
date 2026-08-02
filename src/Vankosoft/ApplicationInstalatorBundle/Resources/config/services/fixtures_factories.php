<?php namespace Symfony\Component\DependencyInjection\Loader\Configurator;

use Vankosoft\ApplicationInstalatorBundle\DataFixtures\Factory\GeneralSettingsExampleFactory;
use Vankosoft\ApplicationInstalatorBundle\DataFixtures\Factory\ApplicationsExampleFactory;
use Vankosoft\ApplicationInstalatorBundle\DataFixtures\Factory\TaxonomyExampleFactory;
use Vankosoft\ApplicationInstalatorBundle\DataFixtures\Factory\PageCategoriesExampleFactory;
use Vankosoft\ApplicationInstalatorBundle\DataFixtures\Factory\PagesExampleFactory;
use Vankosoft\ApplicationInstalatorBundle\DataFixtures\Factory\LocalesExampleFactory;
use Vankosoft\ApplicationInstalatorBundle\DataFixtures\Factory\UserRolesExampleFactory;
use Vankosoft\ApplicationInstalatorBundle\DataFixtures\Factory\UsersExampleFactory;
use Vankosoft\ApplicationInstalatorBundle\DataFixtures\Factory\CookieConsentTranslationsExampleFactory;
use Vankosoft\ApplicationInstalatorBundle\DataFixtures\Factory\TagsWhitelistContextsExampleFactory;
use Vankosoft\ApplicationInstalatorBundle\DataFixtures\Factory\TagsWhitelistTagsExampleFactory;
use Vankosoft\ApplicationInstalatorBundle\DataFixtures\Factory\WidgetsGroupsExampleFactory;
use Vankosoft\ApplicationInstalatorBundle\DataFixtures\Factory\WidgetsExampleFactory;

return static function ( ContainerConfigurator $container ): void
{
    $services   = $container->services();
    
    $services->defaults()
        ->autowire()
        ->autoconfigure()
        ->public();
    
    $services->set( 'vs_application.fixture.example_factory.general_settings', GeneralSettingsExampleFactory::class )
        ->args([
            service( 'vs_application.factory.settings' ),
            service( 'vs_application.factory.application' ),
        ]);
    
    $services->set( 'vs_application.fixture.example_factory.applications', ApplicationsExampleFactory::class )
        ->args([
            service( 'vs_application.factory.application' ),
        ]);
    
    $services->set( 'vs_application.fixture.example_factory.taxonomy', TaxonomyExampleFactory::class )
        ->args([
            service( 'vs_application.factory.taxonomy' ),
            service( 'vs_application.factory.taxon' ),
            service( 'vs_application.slug_generator' ),
        ]);
    
    $services->set( 'vs_application.fixture.example_factory.page_categories', PageCategoriesExampleFactory::class )
        ->args([
            service( 'vs_application.repository.taxonomy' ),
            service( 'vs_application.factory.taxon' ),
            service( 'vs_cms.factory.page_categories' ),
            service( 'vs_application.slug_generator' ),
        ]);
    
    $services->set( 'vs_application.fixture.example_factory.pages', PagesExampleFactory::class )
        ->args([
            service( 'vs_cms.repository.page_categories' ),
            service( 'vs_cms.factory.pages' ),
            service( 'vs_application.slug_generator' ),
        ]);
    
    $services->set( 'vs_application.fixture.example_factory.locales', LocalesExampleFactory::class )
        ->args([
            service( 'vs_application.factory.locale' ),
            service( 'vs_application.repository.locale' ),
        ]);
    
    $services->set( 'vs_application.fixture.example_factory.user_roles', UserRolesExampleFactory::class )
        ->args([
            service( 'vs_application.repository.taxonomy' ),
            service( 'vs_application.factory.taxon' ),
            service( 'vs_application.repository.taxon' ),
            service( 'vs_users.factory.user_roles' ),
            service( 'vs_users.repository.user_roles' ),
            service( 'vs_application.slug_generator' ),
        ]);
    
    $services->set( 'vs_application.fixture.example_factory.users', UsersExampleFactory::class )
        ->args([
            service( 'vs_users.manager.user' ),
            service( 'vs_users.repository.user_roles' ),
            service( 'vs_users.factory.user_info' ),
            param( 'locale' ),
            service( 'file_locator' ),
        ]);
    
    $services->set( 'vs_application.fixture.example_factory.cookie_consent_translations', CookieConsentTranslationsExampleFactory::class )
        ->args([
            service( 'vs_application.factory.cookie_consent_translation' ),
        ]);
    
    $services->set( 'vs_application.fixture.example_factory.tags_whitelist_contexts', TagsWhitelistContextsExampleFactory::class )
        ->args([
            service( 'vs_application.repository.taxonomy' ),
            service( 'vs_application.factory.taxon' ),
            service( 'vs_application.factory.tags_whitelist_context' ),
            service( 'vs_application.slug_generator' ),
        ]);
    
    $services->set( 'vs_application.fixture.example_factory.tags_whitelist_tags', TagsWhitelistTagsExampleFactory::class )
        ->args([
            service( 'vs_application.repository.tags_whitelist_context' ),
            service( 'vs_application.factory.tags_whitelist_tag' ),
        ]);
    
    $services->set( 'vs_application.fixture.example_factory.widgets_groups', WidgetsGroupsExampleFactory::class )
        ->args([
            service( 'vs_application.repository.taxonomy' ),
            service( 'vs_application.factory.taxon' ),
            service( 'vs_application.factory.widget_group' ),
            service( 'vs_application.slug_generator' ),
        ]);
    
    $services->set( 'vs_application.fixture.example_factory.widgets', WidgetsExampleFactory::class )
        ->args([
            service( 'vs_application.repository.widget_group' ),
            service( 'vs_application.factory.widget' ),
            service( 'vs_application.slug_generator' ),
            service( 'vs_users.repository.user_roles' ),
        ]);
};
