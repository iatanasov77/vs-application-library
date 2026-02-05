<?php namespace Vankosoft\ApplicationBundle\Controller\Traits;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Form\FormInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Doctrine\Persistence\ObjectRepository;

trait FilterFormTrait
{
    protected function getFilterForm( string $filterClass, ?mixed $selected, Request $request ): FormInterface
    {
        $filterForm     = $this->createFormBuilder()
                            ->add( 'filterByCategory', EntityType::class, [
                                'class'                 => $filterClass,
                                'choice_label'          => function ( $category ) use ( $request )
                                {
                                    return $category->getNameTranslated( $request->getLocale() );
                                },
                                'required'              => true,
                                'label'                 => 'vs_application.form.filter_by_category',
                                'placeholder'           => 'vs_application.form.category_placeholder',
                                'translation_domain'    => 'VSApplicationBundle',
                                'data'                  => $selected ?
                                                            $this->getFilterRepository()->find( $selected ) :
                                                            null,
                            ])
                            ->getForm();
        
        return $filterForm;
    }
    
    abstract protected function getFilterRepository(): ObjectRepository;
}
