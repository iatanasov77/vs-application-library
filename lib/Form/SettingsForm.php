<?php namespace VS\ApplicationBundle\Form;

use Sylius\Bundle\ResourceBundle\Form\Type\AbstractResourceType;
use Sylius\Bundle\ThemeBundle\Form\Type\ThemeNameChoiceType;

use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\ButtonType;

use VS\ApplicationBundle\Model\GeneralSettings;

class SettingsForm extends AbstractResourceType
{
    protected $pageClass;
    
    public function __construct( string $dataClass, string $pageClass )
    {
        parent::__construct( $dataClass );
        
        $this->pageClass = $pageClass;
    }
    
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add( 'maintenanceMode', HiddenType::class )
            
            ->add( 'maintenanceMode', CheckboxType::class, ['label' => 'vs_application.form.maintenance_mode', 'translation_domain' => 'VSApplicationBundle',] )
            
            ->add( 'maintenancePage', EntityType::class, [
                'label'                 => 'vs_application.form.maintenance_page',
                'translation_domain'    => 'VSApplicationBundle',
                'class'                 => $this->pageClass,
                'placeholder'           => 'vs_application.form.maintenance_page_placeholder',
                'choice_label'          => 'title',
                'required'              => false
            ])
            
            ->add('theme', ThemeNameChoiceType::class, [
                'label'                 => 'vs_application.form.theme',
                'translation_domain'    => 'VSApplicationBundle',
                'required'              => false,
                'empty_data'            => null,
                'placeholder'           => 'vs_application.form.theme_placeholder',
            ])
            
            ->add( 'btnSave', SubmitType::class, ['label' => 'vs_application.form.save', 'translation_domain' => 'VSApplicationBundle',] )
            ->add( 'btnCancel', ButtonType::class, ['label' => 'vs_application.form.cancel', 'translation_domain' => 'VSApplicationBundle',] )
        ;
    }
    
    public function configureOptions( OptionsResolver $resolver ): void
    {
        parent::configureOptions( $resolver );
    }
}
