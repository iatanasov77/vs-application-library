<?php namespace Symfony\Component\Dependenc};yInjection\Loader\Configurator;

use Vankosoft\CmsBundle\Component\Generator\UploadedFilePathGenerator;
use Vankosoft\CmsBundle\Component\Uploader\FileUploader;
use Vankosoft\CmsBundle\Component\FileManager;

return static function ( ContainerConfigurator $container ): void
{
    $services   = $container->services();
    $parameters = $container->parameters();
    
    $parameters
        ->set( 'vs_cms.file_manager.taxonomy_code', 'file-managers' )
    ;
    
    /**
     * Parameters for Shared Media File Systems and Directories
     * Need to Be Defined in Project 'services/uploader.yaml'
     * Because Not Found From Here ( I don't know why )
     */
    
    // League Flysystem File Systems
    $parameters
        ->set( 'vs_cms.gaufrette.app_pictures.filesystem', 'vs_application_app_pictures' )
        ->set( 'vs_cms.gaufrette.profile.filesystem', 'vs_application_profile' )
        ->set( 'vs_cms.gaufrette.filemanager.filesystem', 'vs_application_filemanager' )
        ->set( 'vs_cms.gaufrette.slider.filesystem', 'vs_application_slider' )
    ;
    
    // League Flysystem Shared Media Directories
    $parameters
        ->set( 'vs_cms.filemanager_shared_media_gaufrette.app_pictures', '%kernel.project_dir%/public/shared_media/gaufrette/app_pictures' )
        ->set( 'vs_cms.filemanager_shared_media_gaufrette.profile', '%kernel.project_dir%/public/shared_media/gaufrette/profile' )
        ->set( 'vs_cms.filemanager_shared_media_gaufrette.filemanager', '%kernel.project_dir%/public/shared_media/gaufrette/filemanager' )
        ->set( 'vs_cms.filemanager_shared_media_gaufrette.slider', '%kernel.project_dir%/public/shared_media/gaufrette/slider' )
    ;
    
    // Artgris Shared Media Directories
    $parameters
        ->set( 'vs_cms.filemanager_shared_media_artgris', '%kernel.project_dir%/public/shared_media/artgris' )
    ;
    
    $services->defaults()
        ->autowire()
        ->autoconfigure()
        ->public();
    
    $services->set( 'vs_cms.file_path_generator', UploadedFilePathGenerator::class );
    
    $services->set( 'vs_cms.app_pictures_uploader', FileUploader::class )
        ->args([
            service( 'oneup_flysystem.vs_application_app_pictures_filesystem' ),
            service( 'vs_cms.file_path_generator' ),
        ]);
    
    $services->set( 'vs_cms.profile_uploader', FileUploader::class )
        ->args([
            service( 'oneup_flysystem.vs_application_profile_filesystem' ),
            service( 'vs_cms.file_path_generator' ),
        ]);
    
    $services->set( 'vs_cms.filemanager_uploader', FileUploader::class )
        ->args([
            service( 'oneup_flysystem.vs_application_filemanager_filesystem' ),
            service( 'vs_cms.file_path_generator' ),
        ]);
    
    $services->set( 'vs_cms.slider_uploader', FileUploader::class )
        ->args([
            service( 'oneup_flysystem.vs_application_slider_filesystem' ),
            service( 'vs_cms.file_path_generator' ),
        ]);
    
    $services->set( 'vs_cms.file_manager', FileManager::class )
        ->args([
            service( 'vs_cms.filemanager_uploader' ),
        ]);
};
