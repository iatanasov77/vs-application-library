<?php namespace Symfony\Component\DependencyInjection\Loader\Configurator;

use Vankosoft\ApplicationBundle\Form\DataTransformer\TaxonsToCodesTransformer;
use Vankosoft\ApplicationBundle\Form\Type\ApplicationCollectionType;
use Vankosoft\ApplicationBundle\Form\ApplicationForm;
use Vankosoft\ApplicationBundle\Form\SettingsForm;
use Vankosoft\ApplicationBundle\Form\TaxonomyForm;
use Vankosoft\ApplicationBundle\Form\TaxonForm;
use Vankosoft\ApplicationBundle\Form\LocaleForm;
use Vankosoft\ApplicationBundle\Form\CookieConsentTranslationForm;
use Vankosoft\ApplicationBundle\Form\TagsWhitelistContextForm;
use Vankosoft\ApplicationBundle\Form\WidgetsGroupForm;
use Vankosoft\ApplicationBundle\Form\WidgetForm;
use Vankosoft\ApplicationBundle\Form\TagsWhitelistContextTagsForm;
use Vankosoft\ApplicationBundle\Form\Type\WhitelistContextTagType;

return static function ( ContainerConfigurator $container ): void
{
    $services   = $container->services();
    
    $services->defaults()
        ->autowire()
        ->autoconfigure()
        ->public();

    $services->set( 'vs_application.form.data_transformer.taxons_to_codes', TaxonsToCodesTransformer::class )
        ->args([
            service( 'vs_application.repository.taxon' ),
        ]);
    
    $services->set( 'vs_application.form.type.application_collection', ApplicationCollectionType::class )
        ->args([
            service( 'vs_application.repository.application' ),
        ])
        ->tag( 'form.type' );
    
    $services->set( 'vs_application.resources.application.form', ApplicationForm::class )
        ->args([
            param( 'vs_application.model.application.class' ),
        ])
        ->tag( 'form.type' );
    
    $services->set( 'vs_application.resources.settings.form', SettingsForm::class )
        ->args([
            param( 'vs_application.model.settings.class' ),
            param( 'vs_cms.model.pages.class' ),
        ])
        ->tag( 'form.type' );
    
    $services->set( 'vs_application.resources.taxonomy.form', TaxonomyForm::class )
        ->args([
            param( 'vs_application.model.taxonomy.class' ),
            service( 'vs_application.repository.locale' ),
            service( 'request_stack' ),
        ])
        ->tag( 'form.type' );
    
    $services->set( 'vs_application.resources.taxon.form', TaxonForm::class )
        ->args([
            param( 'vs_application.model.taxon.class' ),
        ])
        ->tag( 'form.type' );
    
    $services->set( 'vs_application.resources.locale.form', LocaleForm::class )
        ->args([
            param( 'vs_application.model.locale.class' ),
            service( 'vs_application.repository.locale' ),
            service( 'request_stack' ),
        ])
        ->tag( 'form.type' );
    
    $services->set( 'vs_application.resources.cookie_consent_translation.form', CookieConsentTranslationForm::class )
        ->args([
            param( 'vs_application.model.cookie_consent_translation.class' ),
            service( 'vs_application.repository.locale' ),
        ])
        ->tag( 'form.type' );
    
    $services->set( 'vs_application.resources.tags_whitelist_context.form', TagsWhitelistContextForm::class )
        ->args([
            param( 'vs_application.model.tags_whitelist_context.class' ),
        ])
        ->tag( 'form.type' );
    
    $services->set( 'vs_application.resources.widget_group.form', WidgetsGroupForm::class )
        ->args([
            param( 'vs_application.model.widget_group.class' ),
        ])
        ->tag( 'form.type' );
    
    $services->set( 'vs_application.resources.widget.form', WidgetForm::class )
        ->args([
            param( 'vs_application.model.widget.class' ),
            service( 'request_stack' ),
            service( 'vs_application.repository.locale' ),
            param( 'vs_application.model.widget_group.class' ),
            param( 'vs_users.model.user_roles.class' ),
        ])
        ->tag( 'form.type' );
    
    $services->set( 'vs_application..form.tags_whitelist_context_tags', TagsWhitelistContextTagsForm::class )
        ->args([
            param( 'vs_application.model.tags_whitelist_context.class' ),
        ])
        ->tag( 'form.type' );
    
    $services->set( 'vs_application..form.tags_whitelist_context_tags_type', WhitelistContextTagType::class )
        ->args([
            param( 'vs_application.model.tags_whitelist_tag.class' ),
        ])
        ->tag( 'form.type' );
};
