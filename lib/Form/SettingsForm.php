<?php namespace VS\ApplicationBundle\Form;

use Sylius\Bundle\ResourceBundle\Form\Type\AbstractResourceType;

use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
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
            ->add( 'maintenanceMode', CheckboxType::class, ['label' => 'Maintenance Mode'] )
            
            ->add( 'maintenancePage', EntityType::class, [
                'class'         => $this->pageClass,
                'placeholder'   => '-- Choose a Page --',
                'choice_label'  => 'title',
                'required'      => false
            ])
            
            ->add( 'language', TextType::class, ['label' => 'Language'] )
            ->add( 'theme', TextType::class, ['label' => 'Theme'] )
            
            ->add( 'btnSave', SubmitType::class, ['label' => 'Save'] )
            ->add( 'btnCancel', ButtonType::class, ['label' => 'Cancel'] )
        ;
    }
    
    public function configureOptions( OptionsResolver $resolver ): void
    {
        parent::configureOptions( $resolver );
        
//         $resolver->setDefaults([
//             'data_class' => GeneralSettings::class
//         ]);
    }
}
