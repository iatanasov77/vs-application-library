<?php namespace VS\ApplicationBundle\Form;

use Sylius\Bundle\ResourceBundle\Form\Type\AbstractResourceType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\ButtonType;

use VS\ApplicationBundle\Component\I18N;

class AbstractForm extends AbstractResourceType
{
    public function buildForm( FormBuilderInterface $builder, array $options )
    {
        $builder
            ->add( 'btnApply', SubmitType::class, ['label' => 'vs_users_subscriptions.form.save', 'translation_domain' => 'VSUsersSubscriptionsBundle',] )
            ->add( 'btnSave', SubmitType::class, ['label' => 'vs_users_subscriptions.form.save', 'translation_domain' => 'VSUsersSubscriptionsBundle',] )
            ->add( 'btnCancel', ButtonType::class, ['label' => 'vs_users_subscriptions.form.cancel', 'translation_domain' => 'VSUsersSubscriptionsBundle',] )
        ;
    }
    
    public function configureOptions( OptionsResolver $resolver ): void
    {
        parent::configureOptions( $resolver );
    }
    
}

