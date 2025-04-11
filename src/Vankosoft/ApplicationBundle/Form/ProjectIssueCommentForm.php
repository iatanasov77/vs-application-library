<?php namespace Vankosoft\ApplicationBundle\Form;

use Sylius\Bundle\ResourceBundle\Form\Type\AbstractResourceType;

use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\ButtonType;
use daddl3\SymfonyCKEditor5WebpackViteBundle\Form\Ckeditor5TextareaType;

class ProjectIssueCommentForm extends AbstractResourceType
{
    public function buildForm( FormBuilderInterface $builder, array $options )
    {
        $entity = $builder->getData();
        
        $builder
            ->add( 'redirectUrl', HiddenType::class, ['required' => false, 'mapped' => false] )

            ->add( 'message', Ckeditor5TextareaType::class, [
                'label'                 => 'vankosoft_org.form.blog_post_comment.message',
                'translation_domain'    => 'VankoSoftOrg',
                'attr' => [
                    'data-ckeditor5-config' => 'devpage'
                ],
            ])
            
            ->add( 'btnSave', SubmitType::class, [
                'label'                 => 'vankosoft_org.form.blog_post_comment.save',
                'translation_domain'    => 'VankoSoftOrg',
            ])
            
            ->add( 'btnCancel', ButtonType::class, [
                'label'                 => 'vankosoft_org.form.cancel',
                'translation_domain'    => 'VankoSoftOrg',
            ])
        ;
    }
    
    public function configureOptions( OptionsResolver $resolver ): void
    {
        $resolver
            ->setDefaults([
                'csrf_protection'   => false,
            ])
        ;
    }
    
    public function getName()
    {
        return 'vs_org_project_issue_comments';
    }
}
