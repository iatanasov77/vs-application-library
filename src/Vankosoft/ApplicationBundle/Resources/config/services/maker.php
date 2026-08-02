<?php namespace Symfony\Component\DependencyInjection\Loader\Configurator;

use Vankosoft\ApplicationBundle\Maker\Doctrine\EntityClassGenerator;
use Vankosoft\ApplicationBundle\Maker\Renderer\FormTypeRenderer;
use Vankosoft\ApplicationBundle\Maker\MakeResourceCrud;
use Vankosoft\ApplicationBundle\Maker\MakeTaxonomyResourceCrud;
use Vankosoft\ApplicationBundle\Maker\MakeResourceEntity;
use Vankosoft\ApplicationBundle\Maker\MakeTheme;

return static function ( ContainerConfigurator $container ): void
{
    $services   = $container->services();
    
    $services->defaults()
        ->autowire()
        ->autoconfigure();
    
    $services->set( 'vs_application.maker.doctrine.entity_class_generator', EntityClassGenerator::class )
        ->args([
            service( 'kernel' ),
            service( 'maker.generator' ),
            service( 'maker.doctrine_helper' ),
        ]);
    
    $services->set( 'vs_application.maker.renderer.form_type_renderer', FormTypeRenderer::class )
        ->args([
            service( 'kernel' ),
            service( 'maker.generator' ),
        ]);
    
    $services->set( 'vs_application.maker.make_resource', MakeResourceCrud::class )
        ->args([
            service( 'kernel' ),
            service( 'maker.doctrine_helper' ),
            service( 'vs_application.maker.renderer.form_type_renderer' ),
            service( 'vs_application.repository.application' ),
            service( 'vs_application.repository.settings' ),
            service( 'vs_application.slug_generator' ),
        ])
        ->tag( 'maker.command' );
    
    $services->set( 'vs_application.maker.make_taxonomy_resource', MakeTaxonomyResourceCrud::class )
        ->args([
            service( 'kernel' ),
            service( 'maker.doctrine_helper' ),
            service( 'vs_application.maker.renderer.form_type_renderer' ),
            service( 'vs_application.repository.application' ),
            service( 'vs_application.repository.settings' ),
            service( 'vs_application.slug_generator' ),
        ])
        ->tag( 'maker.command' );
    
    $services->set( 'vs_application.maker.make_resource_entity', MakeResourceEntity::class )
        ->args([
            service( 'maker.file_manager' ),
            service( 'maker.doctrine_helper' ),
            service( 'maker.generator' ),
            service( 'vs_application.maker.doctrine.entity_class_generator' ),
            service( 'maker.php_compat_util' ),
        ])
        ->tag( 'maker.command' );
    
    $services->set( 'vs_application.maker.make_theme', MakeTheme::class )
        ->args([
            service( 'kernel' ),
            service( 'vs_application.slug_generator' ),
        ])
        ->tag( 'maker.command' );
};
