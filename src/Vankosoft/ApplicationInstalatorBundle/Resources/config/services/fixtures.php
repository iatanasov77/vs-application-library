<?php namespace Symfony\Component\DependencyInjection\Loader\Configurator;

use Vankosoft\ApplicationInstalatorBundle\DataFixtures\VankosoftApplicationFixtures\GeneralSettingsFixture;
use Vankosoft\ApplicationInstalatorBundle\DataFixtures\VankosoftApplicationFixtures\TaxonomyFixture;
use Vankosoft\ApplicationInstalatorBundle\DataFixtures\VankosoftApplicationFixtures\PageCategoriesFixture;
use Vankosoft\ApplicationInstalatorBundle\DataFixtures\VankosoftApplicationFixtures\ApplicationsFixture;
use Vankosoft\ApplicationInstalatorBundle\DataFixtures\VankosoftApplicationFixtures\PagesFixture;
use Vankosoft\ApplicationInstalatorBundle\DataFixtures\VankosoftApplicationFixtures\LocalesFixture;
use Vankosoft\ApplicationInstalatorBundle\DataFixtures\VankosoftApplicationFixtures\UserRolesFixture;
use Vankosoft\ApplicationInstalatorBundle\DataFixtures\VankosoftApplicationFixtures\UsersFixture;
use Vankosoft\ApplicationInstalatorBundle\DataFixtures\VankosoftApplicationFixtures\CookieConsentTranslationsFixture;
use Vankosoft\ApplicationInstalatorBundle\DataFixtures\VankosoftApplicationFixtures\TagsWhitelistContextsFixture;
use Vankosoft\ApplicationInstalatorBundle\DataFixtures\VankosoftApplicationFixtures\TagsWhitelistTagsFixture;
use Vankosoft\ApplicationInstalatorBundle\DataFixtures\VankosoftApplicationFixtures\WidgetsGroupsFixture;
use Vankosoft\ApplicationInstalatorBundle\DataFixtures\VankosoftApplicationFixtures\WidgetsFixture;

return static function ( ContainerConfigurator $container ): void
{
    $services   = $container->services();
    
    $services->defaults()
        ->autowire()
        ->autoconfigure()
        ->public();
    
    $services->set( 'vs_application.fixture.general_settings', GeneralSettingsFixture::class )
        ->args([
            service( 'doctrine.orm.default_entity_manager' ),
            service( 'vs_application.fixture.example_factory.general_settings' ),
        ])
        ->tag( 'sylius_fixtures.fixture' );
    
    $services->set( 'vs_application.fixture.taxonomy', TaxonomyFixture::class )
        ->args([
            service( 'doctrine.orm.default_entity_manager' ),
            service( 'vs_application.fixture.example_factory.taxonomy' ),
        ])
        ->tag( 'sylius_fixtures.fixture' );
    
    $services->set( 'vs_application.fixture.page_categories', PageCategoriesFixture::class )
        ->args([
            service( 'doctrine.orm.default_entity_manager' ),
            service( 'vs_application.fixture.example_factory.page_categories' ),
        ])
        ->tag( 'sylius_fixtures.fixture' );
    
    $services->set( 'vs_application.fixture.applications', ApplicationsFixture::class )
        ->args([
            service( 'doctrine.orm.default_entity_manager' ),
            service( 'vs_application.fixture.example_factory.applications' ),
        ])
        ->tag( 'sylius_fixtures.fixture' );
    
    $services->set( 'vs_application.fixture.pages', PagesFixture::class )
        ->args([
            service( 'doctrine.orm.default_entity_manager' ),
            service( 'vs_application.fixture.example_factory.pages' ),
        ])
        ->tag( 'sylius_fixtures.fixture' );
    
    $services->set( 'vs_application.fixture.locales', LocalesFixture::class )
        ->args([
            service( 'doctrine.orm.default_entity_manager' ),
            service( 'vs_application.fixture.example_factory.locales' ),
        ])
        ->tag( 'sylius_fixtures.fixture' );
    
    $services->set( 'vs_application.fixture.user_roles', UserRolesFixture::class )
        ->args([
            service( 'doctrine.orm.default_entity_manager' ),
            service( 'vs_application.fixture.example_factory.user_roles' ),
        ])
        ->tag( 'sylius_fixtures.fixture' );
    
    $services->set( 'vs_application.fixture.users', UsersFixture::class )
        ->args([
            service( 'doctrine.orm.default_entity_manager' ),
            service( 'vs_application.fixture.example_factory.users' ),
        ])
        ->tag( 'sylius_fixtures.fixture' );
    
    $services->set( 'vs_application.fixture.cookie_consent_translations', CookieConsentTranslationsFixture::class )
        ->args([
            service( 'doctrine.orm.default_entity_manager' ),
            service( 'vs_application.fixture.example_factory.cookie_consent_translations' ),
        ])
        ->tag( 'sylius_fixtures.fixture' );
    
    $services->set( 'vs_application.fixture.tags_whitelist_contexts', TagsWhitelistContextsFixture::class )
        ->args([
            service( 'doctrine.orm.default_entity_manager' ),
            service( 'vs_application.fixture.example_factory.tags_whitelist_contexts' ),
        ])
        ->tag( 'sylius_fixtures.fixture' );
    
    $services->set( 'vs_application.fixture.tags_whitelist_tags', TagsWhitelistTagsFixture::class )
        ->args([
            service( 'doctrine.orm.default_entity_manager' ),
            service( 'vs_application.fixture.example_factory.tags_whitelist_tags' ),
        ])
        ->tag( 'sylius_fixtures.fixture' );
    
    $services->set( 'vs_application.fixture.widgets_groups', WidgetsGroupsFixture::class )
        ->args([
            service( 'doctrine.orm.default_entity_manager' ),
            service( 'vs_application.fixture.example_factory.widgets_groups' ),
        ])
        ->tag( 'sylius_fixtures.fixture' );
    
    $services->set( 'vs_application.fixture.widgets', WidgetsFixture::class )
        ->args([
            service( 'doctrine.orm.default_entity_manager' ),
            service( 'vs_application.fixture.example_factory.widgets' ),
        ])
        ->tag( 'sylius_fixtures.fixture' );
};
