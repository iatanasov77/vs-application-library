<?php namespace Symfony\Component\DependencyInjection\Loader\Configurator;

use Symfony\Component\Form\FormFactory;
use Vankosoft\CmsBundle\Form\PageCategoryForm;
use Vankosoft\CmsBundle\Form\PageForm;
use Vankosoft\CmsBundle\Form\DocumentCategoryForm;
use Vankosoft\CmsBundle\Form\DocumentForm;
use Vankosoft\CmsBundle\Form\TocPageForm;
use Vankosoft\CmsBundle\Form\FileManager\UploadFileForm;
use Vankosoft\CmsBundle\Form\VankosoftFileManagerForm;
use Vankosoft\CmsBundle\Form\VankosoftFileManagerFileForm;
use Vankosoft\CmsBundle\Form\HelpCenterQuestionForm;
use Vankosoft\CmsBundle\Form\QuickLinksCategoryForm;
use Vankosoft\CmsBundle\Form\QuickLinkForm;
use Vankosoft\CmsBundle\Form\SliderForm;
use Vankosoft\CmsBundle\Form\SliderItemForm;
use Vankosoft\CmsBundle\Form\BannerPlaceForm;
use Vankosoft\CmsBundle\Form\BannerForm;

return static function ( ContainerConfigurator $container ): void
{
    $services   = $container->services();
    $parameters = $container->parameters();
    
    $parameters
        ->set( 'vs_cms.form.use_ckeditor', 'env(resolve:USE_CKEDITOR)' )
        ->set( 'vs_cms.form.decription_field.ckeditor5_editor', 'default' )
        ->set( 'vs_cms.form.pages_field.ckeditor5_editor', 'default' )
        ->set( 'vs_cms.form.toc_page_field.ckeditor5_editor', 'default' )
    ;
    
    /**
     * Description Field Form Options
     */
    $parameters
        ->set( 'vs_cms.form.decription_field.ckeditor_uiColor', '#ffffff' )
        ->set( 'vs_cms.form.decription_field.ckeditor_extraAllowedContent', '*[*]{*}(*)' )
        ->set( 'vs_cms.form.decription_field.ckeditor_toolbar', 'description_toolbar' )
        ->set( 'vs_cms.form.decription_field.ckeditor_extraPlugins', 'font, justify' )
        ->set( 'vs_cms.form.decription_field.ckeditor_removeButtons', '' )
        ->set( 'vs_cms.form.decription_field.ckeditor_allowedContent', true )
    ;
    
    /**
     * Pages Form Options
     */
    $parameters
        ->set( 'vs_cms.form.pages.ckeditor_uiColor', '#ffffff' )
        ->set( 'vs_cms.form.pages.ckeditor_extraAllowedContent', '*[*]{*}(*)' )
        ->set( 'vs_cms.form.pages.ckeditor_toolbar', 'devpage_toolbar' )
        ->set( 'vs_cms.form.pages.ckeditor_extraPlugins', 'font, justify, codesnippet, lightbox' )
        ->set( 'vs_cms.form.pages.ckeditor_removeButtons', '' )
        ->set( 'vs_cms.form.pages.ckeditor_allowedContent', true )
    ;
    
    /**
     * TocPage Form Options
     */
    $parameters
        ->set( 'vs_cms.form.pages.ckeditor_uiColor', '#ffffff' )
        ->set( 'vs_cms.form.pages.ckeditor_extraAllowedContent', '*[*]{*}(*)' )
        ->set( 'vs_cms.form.pages.ckeditor_toolbar', 'devpage_toolbar' )
        ->set( 'vs_cms.form.pages.ckeditor_extraPlugins', 'liststyle, font, justify, codesnippet, lightbox, simplebox, simplebox-2, ckeditor_add_class' )
        ->set( 'vs_cms.form.pages.ckeditor_removeButtons', '' )
        ->set( 'vs_cms.form.pages.ckeditor_allowedContent', true )
    ;
    
    /**
     * SliderItem Form Options
     */
    $parameters
        ->set( 'vs_cms.form.slider_item.photo.max_size', '1024k' )
        ->set( 'vs_cms.form.slider_item.photo.description', '1920 x 1280' )
    ;
    
    /*
     * Override Symfony Service '@form.factory' to be Public
     * Needed in PagesController to Clone and Preview Forms
     */
    $services->set( 'form.factory', FormFactory::class )
        ->args([
            service( 'form.registry' ),
        ]);
    
    $services->set( 'vs_cms.resources.page_categories.form', PageCategoryForm::class )
        ->args([
            param( 'vs_cms.model.page_categories.class' ),
            service( 'vs_application.repository.locale' ),
            service( 'request_stack' ),
            service( 'vs_cms.repository.page_categories' ),
        ])
        ->tag( 'form.type' );
    
    $services->set( 'vs_cms.resources.pages.form', PageForm::class )
        ->args([
            param( 'vs_cms.model.pages.class' ),
            service( 'vs_application.repository.locale' ),
            service( 'request_stack' ),
            param( 'vs_cms.model.page_categories.class' ),
            param( 'vs_cms.form.use_ckeditor' ),
            param( 'vs_cms.form.decription_field.ckeditor5_editor' ),
        ])
        ->tag( 'form.type' );
    
    $services->set( 'vs_cms.resources.document_categories.form', DocumentCategoryForm::class )
        ->args([
            param( 'vs_cms.model.document_categories.class' ),
            service( 'vs_application.repository.locale' ),
            service( 'request_stack' ),
        ])
        ->tag( 'form.type' );
    
    $services->set( 'vs_cms.resources.document.form', DocumentForm::class )
        ->args([
            param( 'vs_cms.model.document.class' ),
            service( 'vs_application.repository.locale' ),
            service( 'request_stack' ),
            param( 'vs_cms.model.document_categories.class' ),
            param( 'vs_cms.model.toc_page.class' ),
            param( 'vs_cms.form.use_ckeditor' ),
            param( 'vs_cms.form.decription_field.ckeditor5_editor' ),
        ])
        ->tag( 'form.type' );
    
    $services->set( TocPageForm::class )
        ->args([
            param( 'vs_cms.model.toc_page.class' ),
            service( 'vs_application.repository.locale' ),
            service( 'request_stack' ),
            param( 'vs_cms.form.use_ckeditor' ),
            param( 'vs_cms.form.decription_field.ckeditor5_editor' ),
        ])
        ->tag( 'form.type' );
    
    $services->set( UploadFileForm::class )
        ->tag( 'form.type' );
    
    $services->set( 'vs_cms.resources.file_manager.form', VankosoftFileManagerForm::class )
        ->args([
            param( 'vs_cms.model.file_manager.class' ),
            service( 'vs_application.repository.locale' ),
            service( 'request_stack' ),
        ])
        ->tag( 'form.type' );
    
    $services->set( 'vs_cms.resources.file_manager_file.form', VankosoftFileManagerFileForm::class )
        ->args([
            param( 'vs_cms.model.file_manager_file.class' ),
        ])
        ->tag( 'form.type' );
    
    $services->set( 'vs_cms.resources.helpcenter_question.form', HelpCenterQuestionForm::class )
        ->args([
            param( 'vs_cms.model.helpcenter_question.class' ),
            service( 'vs_application.repository.locale' ),
            service( 'request_stack' ),
        ])
        ->tag( 'form.type' );
    
    $services->set( 'vs_cms.resources.quick_link_category.form', QuickLinksCategoryForm::class )
        ->args([
            param( 'vs_cms.model.quick_link_category.class' ),
            service( 'vs_application.repository.locale' ),
            service( 'request_stack' ),
        ])
        ->tag( 'form.type' );
    
    $services->set( 'vs_cms.resources.quick_link.form', QuickLinkForm::class )
        ->args([
            param( 'vs_cms.model.quick_link.class' ),
            param( 'vs_cms.model.quick_link_category.class' ),
            service( 'vs_application.repository.locale' ),
            service( 'request_stack' ),
        ])
        ->tag( 'form.type' );
    
    $services->set( 'vs_cms.resources.slider.form', SliderForm::class )
        ->args([
            param( 'vs_cms.model.slider.class' ),
            service( 'vs_application.repository.locale' ),
            service( 'request_stack' ),
        ])
        ->tag( 'form.type' );
    
    $services->set( 'vs_cms.resources.slider_item.form', SliderItemForm::class )
        ->args([
            param( 'vs_cms.model.slider_item.class' ),
            param( 'vs_cms.model.slider.class' ),
            service( 'vs_application.repository.locale' ),
            service( 'request_stack' ),
            param( 'vs_cms.form.use_ckeditor' ),
            param( 'vs_cms.form.decription_field.ckeditor5_editor' ),
        ])
        ->tag( 'form.type' );
    
    $services->set( 'vs_cms.resources.banner_place.form', BannerPlaceForm::class )
        ->args([
            param( 'vs_cms.model.banner_place.class' ),
            service( 'vs_application.repository.locale' ),
            service( 'request_stack' ),
            service( 'liip_imagine.filter.manager' ),
        ])
        ->tag( 'form.type' );
    
    $services->set( 'vs_cms.resources.banner.form', BannerForm::class )
        ->args([
            param( 'vs_cms.model.banner.class' ),
            param( 'vs_cms.model.banner_place.class' ),
            service( 'vs_application.repository.locale' ),
            service( 'request_stack' ),
        ])
        ->tag( 'form.type' );
};
