<?php namespace VS\ApplicationBundle\Form;

use Sylius\Bundle\ResourceBundle\Form\Type\AbstractResourceType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\ButtonType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;

use Doctrine\ORM\EntityRepository;

class TaxonForm extends AbstractResourceType
{
    public function __construct( $dataClass )
    {
        parent::__construct( $dataClass );
    }
    
    public function buildForm( FormBuilderInterface $builder, array $options )
    {
        $builder
            ->add( 'currentLocale', HiddenType::class )

            ->add( 'parentTaxon', EntityType::class, [
                'mapped'                => false,
                'required'              => true,
                'label'                 => 'vs_application.form.parent',
                'translation_domain'    => 'VSApplicationBundle',
                'class'                 => $this->dataClass,
                'choice_label'          => 'name',
                'query_builder'         => function ( EntityRepository $er ) use ( $options )
                {
                    //var_dump( $er ); die;
                    return $er->createQueryBuilder( 't' )
                                ->where( 't.root = :rootTaxon' )
                                ->setParameter( 'rootTaxon', $options['rootTaxon'] );
                }
            ])
            
            ->add( 'name', TextType::class, ['label' => 'vs_application.form.name', 'translation_domain' => 'VSApplicationBundle',] )
            ->add( 'description', TextareaType::class, [
                'label'                 => 'vs_application.form.description', 
                'translation_domain'    => 'VSApplicationBundle', 
                'required'              => false
            ])

            ->add( 'btnSave', SubmitType::class, ['label' => 'vs_application.form.save', 'translation_domain' => 'VSApplicationBundle',] )
            ->add( 'btnCancel', ButtonType::class, ['label' => 'vs_application.form.cancel', 'translation_domain' => 'VSApplicationBundle',] )
        ;
    }

    public function configureOptions( OptionsResolver $resolver ): void
    {
        parent::configureOptions( $resolver );
        
        $resolver->setDefaults([
            'rootTaxon' => null,
        ]);
    }
}

