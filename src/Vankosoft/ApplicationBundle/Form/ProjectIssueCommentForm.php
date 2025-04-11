<?php namespace Vankosoft\ApplicationBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\ButtonType;
use daddl3\SymfonyCKEditor5WebpackViteBundle\Form\Ckeditor5TextareaType;

class ProjectIssueCommentForm extends AbstractType
{
    public function buildForm( FormBuilderInterface $builder, array $options )
    {
        $builder
            ->add( 'redirectUrl', HiddenType::class, ['required' => false, 'mapped' => false] )

            ->add( 'message', Ckeditor5TextareaType::class, [
                'label'                 => 'vs_application.form.kanbanboard_task.leave_comment',
                'translation_domain'    => 'VSApplicationBundle',
                'attr' => [
                    'data-ckeditor5-config' => 'devpage'
                ],
            ])
            
            ->add( 'btnSave', SubmitType::class, [
                'label'                 => 'vs_application.form.kanbanboard_task.post_comment',
                'translation_domain'    => 'VSApplicationBundle',
            ])
            
            ->add( 'btnCancel', ButtonType::class, [
                'label'                 => 'vs_application.form.cancel',
                'translation_domain'    => 'VSApplicationBundle',
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
