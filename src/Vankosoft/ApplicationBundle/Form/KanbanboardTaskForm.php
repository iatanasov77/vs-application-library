<?php namespace Vankosoft\ApplicationBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Vankosoft\ApplicationBundle\Component\ProjectIssue\KanbanboardTask as VsKanbanboardTask;

class KanbanboardTaskForm extends AbstractType
{
    public function buildForm( FormBuilderInterface $builder, array $options ): void
    {
       $builder
           ->add( 'pipeline', HiddenType::class, [
               'data'   => $options['pipeline_id'],
           ])
           
           ->add( 'issue', ChoiceType::class, [
               'label'              => 'vs_application.form.kanbanboard_task.project_issue',
               'placeholder'        => 'vs_application.form.kanbanboard_task.project_issue_placeholder',
               'translation_domain' => 'VSApplicationBundle',
               'choices'            => $options['projectIssues'],
               
           ])
           
           ->add( 'issueType', ChoiceType::class, [
               'required'           => true,
               'choices'            => \array_flip( VsKanbanboardTask::ISSUE_TYPES ),
               'label'              => 'vs_application.form.kanbanboard_task.issue_type',
               'translation_domain' => 'VSApplicationBundle',
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
               
           ->add( 'btnSave', SubmitType::class, [
               'label'              => 'vs_application.form.kanbanboard_task.add_task',
               'translation_domain' => 'VSApplicationBundle',
           ])
        ;
    }
    
    public function configureOptions( OptionsResolver $resolver ): void
    {
        parent::configureOptions( $resolver );
        
        $resolver->setDefaults([
            'csrf_protection'   => false,
            'pipeline_id'       => 0,
            'projectIssues'     => [],
        ]);
    }
    
    public function getName()
    {
        return 'vs_application_project_kanbanboard_task';
    }
}
