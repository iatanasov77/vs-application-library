<?php namespace Symfony\Component\DependencyInjection\Loader\Configurator;

use Vankosoft\CmsBundle\Controller\GetImageController;
use Vankosoft\CmsBundle\Controller\PagesCategoryExtController;
use Vankosoft\CmsBundle\Controller\PagesExtController;
use Vankosoft\CmsBundle\Controller\MultiPageTocPageController;
use Vankosoft\CmsBundle\Controller\ArtgrisFileManagerController;
use Vankosoft\CmsBundle\Controller\VankosoftFileManagerExtController;
use Vankosoft\CmsBundle\Controller\SliderItemExtController;
use Vankosoft\CmsBundle\Controller\BannerExtController;
use Vankosoft\CmsBundle\Controller\QuickLinkExtController;
use Vankosoft\CmsBundle\Controller\SortController;

return static function ( ContainerConfigurator $container ): void
{
    $services   = $container->services();
    
    $services->defaults()
        ->autowire()
        ->autoconfigure();
    
    $services->set( GetImageController::class )
        ->args([
            service( 'liip_imagine.binary.loader.default' ),
            service( 'liip_imagine.filter.manager' ),
        ])
        ->tag( 'controller.service_arguments' );
    
    $services->set( PagesCategoryExtController::class )
        ->args([
            service( 'translator' ),
            service( 'vs_cms.repository.page_categories' ),
        ])
        ->tag( 'controller.service_arguments' );
    
    $services->set( PagesExtController::class )
        ->args([
            service( 'doctrine' ),
            service( 'vs_application.repository.taxonomy' ),
            service( 'vs_application.repository.taxon' ),
            service( 'vs_cms.repository.pages' ),
            service( 'vs_cms.repository.page_categories' ),
            service( 'vs_application.repository.logentry' ),
            service( 'vs_cms.factory.pages' ),
            service( 'vs_application.repository.tags_whitelist_context' ),
        ])
        ->tag( 'controller.service_arguments' );
    
    $services->set( MultiPageTocPageController::class )
        ->args([
            service( 'doctrine' ),
            service( 'vs_cms.repository.document' ),
            service( 'vs_cms.repository.toc_page' ),
            service( 'vs_cms.factory.toc_page' ),
        ])
        ->tag( 'controller.service_arguments' );
    
    $services->set( ArtgrisFileManagerController::class )
        ->args([
            service( 'vs_cms.file_manager' ),
        ])
        ->tag( 'controller.service_arguments' );
    
    $services->set( VankosoftFileManagerExtController::class )
        ->args([
            service( 'doctrine' ),
            service( 'vs_cms.repository.file_manager' ),
            service( 'vs_cms.repository.file_manager_file' ),
            service( 'vs_cms.factory.file_manager_file' ),
            service( 'vs_cms.file_manager' ),
        ])
        ->tag( 'controller.service_arguments' );
    
    $services->set( SliderItemExtController::class )
        ->args([
            service( 'doctrine' ),
            service( 'vs_cms.repository.slider' ),
            service( 'vs_cms.repository.slider_item' ),
            service( 'vs_cms.factory.slider_item' ),
            service( 'vs_cms.file_manager' ),
            param( 'vs_cms.form.slider_item.photo.description' ),
        ])
        ->tag( 'controller.service_arguments' );
    
    $services->set( BannerExtController::class )
        ->args([
            service( 'doctrine' ),
            service( 'vs_cms.repository.banner_place' ),
            service( 'vs_cms.repository.banner' ),
            service( 'vs_cms.factory.banner' ),
            service( 'vs_cms.file_manager' ),
        ])
        ->tag( 'controller.service_arguments' );
    
    $services->set( QuickLinkExtController::class )
        ->args([
            service( 'doctrine' ),
            service( 'vs_cms.repository.quick_link_category' ),
            service( 'vs_cms.repository.quick_link' ),
            service( 'vs_cms.factory.quick_link' ),
        ])
        ->tag( 'controller.service_arguments' );
    
    $services->set( SortController::class )
        ->args([
            service( 'doctrine' ),
            service( 'vs_cms.repository.slider_item' ),
            service( 'vs_cms.repository.banner' ),
            service( 'vs_cms.repository.quick_link' ),
        ])
        ->tag( 'controller.service_arguments' );
};
