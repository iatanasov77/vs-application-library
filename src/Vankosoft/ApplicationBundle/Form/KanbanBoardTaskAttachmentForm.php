<?php namespace Vankosoft\ApplicationBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\Extension\Core\Type\FileType;

class KanbanBoardTaskAttachmentForm extends AbstractForm
{
    public function buildForm( FormBuilderInterface $builder, array $options ): void
    {
        $builder
            /**
             * Hidden Fields Needed For OneUp Uploader
             */
            ->add( 'id', HiddenType::class, [
                'data'      => $options['fileId'],
                'mapped'    => false,
            ])
            ->add( 'fileId', HiddenType::class, [
                'data'      => $options['fileId'],
                'mapped'    => false,
            ])
            ->add( 'ownerId', HiddenType::class, [
                'data'      => $options['taskId'],
                'mapped'    => false,
            ])
//             ->add( 'fileClass', HiddenType::class, [
//                 'data'      => $options['fileClass'],
//                 'mapped'    => false,
//             ])
//             ->add( 'ownerClass', HiddenType::class, [
//                 'data'      => $options['taskClass'],
//                 'mapped'    => false,
//             ])
            
            /**
             * Main Entity Fields
             */
            ->add( 'attachment', FileType::class, [
                'mapped'                => false,
                'required'              => true,
                
                'label'                 => 'vankosoft_org.form.kanbanboard_task.attachment',
                'translation_domain'    => 'VankoSoftOrg',
            ])
        ;
    }
    
    public function configureOptions( OptionsResolver $resolver ): void
    {
        parent::configureOptions( $resolver );
        
        $resolver->setDefaults([
            'csrf_protection'   => false,
            
            'fileId'    => 0,
            'taskId'    => 0,
//             'fileClass' => KanbanBoardTaskAttachment::class,
//             'taskClass' => KanbanBoardTask::class,
        ]);
    }
    
    public function getName()
    {
        return 'vs_application_project_kanbanboard_task_attachment';
    }
}
