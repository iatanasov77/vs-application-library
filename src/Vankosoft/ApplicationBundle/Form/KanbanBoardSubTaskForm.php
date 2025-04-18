<?php namespace Vankosoft\ApplicationBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateType;

use Doctrine\ORM\EntityRepository;
use Vankosoft\ApplicationBundle\Component\ProjectIssue\KanbanboardTask as VsKanbanboardTask;

class KanbanBoardSubTaskForm extends AbstractType
{
    public function buildForm( FormBuilderInterface $builder, array $options ): void
    {
        $builder
            ->add( 'issue', ChoiceType::class, [
                'label'              => 'vs_application.form.kanbanboard_task.project_issue',
                'placeholder'        => 'vs_application.form.kanbanboard_task.project_issue_placeholder',
                'translation_domain' => 'VSApplicationBundle',
                'choices'            => $options['projectIssues'],
            ])
            
            ->add( 'priority', ChoiceType::class, [
                'required'           => true,
                'choices'            => \array_flip( VsKanbanboardTask::TASK_PRIORITIES ),
                'label'              => 'vs_application.form.kanbanboard_task.priority',
                'translation_domain' => 'VSApplicationBundle',
            ])
            
            ->add( 'status', ChoiceType::class, [
                'required'           => true,
                'choices'            => \array_flip( VsKanbanboardTask::TASK_STATUSES ),
                'label'              => 'vs_application.form.kanbanboard_task.status',
                'translation_domain' => 'VSApplicationBundle',
            ])
            
            ->add( 'dueDate', DateType::class, [
                'label'              => 'vs_application.form.kanbanboard_task.due_date',
                'translation_domain' => 'VSApplicationBundle',
                'widget'             => 'single_text',
                'html5'              => false,
                'required'           => false,
            ])
            
            ->add( 'assignedTo', ChoiceType::class, [
                'label'              => 'vs_application.form.kanbanboard_task.members',
                'translation_domain' => 'VSApplicationBundle',
                'choices'            => [],
                'multiple'           => true,
                'expanded'           => true,
                'required'           => false,
            ])
            
        ;
    }
    
    public function configureOptions( OptionsResolver $resolver ): void
    {
        parent::configureOptions( $resolver );
        
        $resolver->setDefaults([
            'csrf_protection'   => false,
            'projectIssues'     => [],
        ]);
    }
    
    public function getName()
    {
        return 'vs_application_project_kanbanboard_subtask';
    }
}
