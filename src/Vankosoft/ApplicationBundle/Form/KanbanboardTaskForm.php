<?php namespace Vankosoft\ApplicationBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use FOS\CKEditorBundle\Form\Type\CKEditorType;
use daddl3\SymfonyCKEditor5WebpackViteBundle\Form\Ckeditor5TextareaType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

use Vankosoft\ApplicationBundle\Component\ProjectIssue\ProjectIssue;
use Vankosoft\ApplicationBundle\Component\ProjectIssue\KanbanboardTask as VsKanbanboardTask;

class KanbanboardTaskForm extends AbstractType
{
    public function buildForm( FormBuilderInterface $builder, array $options ): void
    {
       $builder
           ->add( 'pipeline', HiddenType::class, [
               'data'      => $options['pipeline_id'],
           ])
           
           ->add( 'issue', ChoiceType::class, [
               'label'                 => 'vankosoft_org.form.kanbanboard_task.project_issue',
               'placeholder'           => 'vankosoft_org.form.kanbanboard_task.project_issue_placeholder',
               'translation_domain'    => 'VankoSoftOrg',
               'choices'               => [],
               
           ])
           
           ->add( 'issueType', ChoiceType::class, [
               'required'              => true,
               'choices'               => \array_flip( VsKanbanboardTask::ISSUE_TYPES ),
               'label'                 => 'vankosoft_org.form.kanbanboard_task.issue_type',
               'translation_domain'    => 'VankoSoftOrg',
           ])
           
           ->add( 'priority', ChoiceType::class, [
               'required'              => true,
               'choices'               => \array_flip( VsKanbanboardTask::TASK_PRIORITIES ),
               'label'                 => 'vankosoft_org.form.kanbanboard_task.priority',
               'translation_domain'    => 'VankoSoftOrg',
           ])
           
           ->add( 'status', ChoiceType::class, [
               'required'              => true,
               'choices'               => \array_flip( VsKanbanboardTask::TASK_STATUSES ),
               'label'                 => 'vankosoft_org.form.kanbanboard_task.status',
               'translation_domain'    => 'VankoSoftOrg',
           ])
           
           ->add( 'dueDate', DateType::class, [
               'label'                 => 'vankosoft_org.form.kanbanboard_task.due_date',
               'translation_domain'    => 'VankoSoftOrg',
               'widget'                => 'single_text',
               'html5'                 => false,
               'required'              => false,
           ])
           
           ->add( 'assignedTo', ChoiceType::class, [
               'label'                 => 'vankosoft_org.form.kanbanboard_task.members',
               'translation_domain'    => 'VankoSoftOrg',
               'choices'               => [],
               'multiple'              => true,
               'expanded'              => true,
               'required'              => false,
           ])
               
           ->add( 'btnSave', SubmitType::class, [
               'label' => 'Add Task',
           ])
        ;
    }
    
    public function configureOptions( OptionsResolver $resolver ): void
    {
        parent::configureOptions( $resolver );
        
        $resolver->setDefaults([
            'csrf_protection'   => false,
            'pipeline_id'       => 0,
        ]);
    }
    
    public function getName()
    {
        return 'vs_application_project_kanbanboard_task';
    }
}
