<?php namespace Vankosoft\ApplicationBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Form\FormInterface;
use Sylius\Resource\Doctrine\Persistence\RepositoryInterface;
use Sylius\Component\Resource\Factory\FactoryInterface;

use Vankosoft\ApplicationBundle\Component\Status;
use Vankosoft\ApplicationBundle\Component\Exception\VankosoftApiException;
use Vankosoft\ApplicationBundle\Component\ProjectIssue\ProjectIssue;
use Vankosoft\ApplicationBundle\Component\ProjectIssue\KanbanboardTask as VsKanbanboardTask;
use Vankosoft\ApplicationBundle\Form\KanbanboardTaskForm;
use Vankosoft\ApplicationBundle\Form\KanbanBoardTaskAttachmentForm;

class VankosoftIssueBoardController extends AbstractController
{
    /** @var ProjectIssue */
    private $vsProject;
    
    public function __construct(
        ProjectIssue $vsProject
    ) {
        $this->vsProject            = $vsProject;
    }
    
    public function showKanbanboardAction( Request $request ): Response
    {
        $apiEnabled = $this->getParameter( 'vs_application.vankosoft_api.enabled' );
        $apiBoard   = $this->getParameter( 'vs_application.vankosoft_api.kanbanboard' );
        
        if( ! $apiEnabled ) {
            throw new VankosoftApiException( 'VankoSoft API is NOT Enabled !!! Please Enable it and Configure it !!!' );
        }
        
        if ( $apiBoard === ProjectIssue::BOARD_UNDEFINED ) {
            throw new VankosoftApiException( 'VankoSoft API Kanbanboard Slug is NOT Defined !!!' );
        }
        
        $board = $this->vsProject->getKanbanboard();
        
        return $this->render( '@VSApplication/Pages/ProjectIssuesBoard/kanbanboard.html.twig', [
            'board'         => $board,
            'addMembers'    => false,
        ]);
    }
    
    public function showTaskAction( $pipelineId, $taskId, Request $request ): Response
    {
        $apiEnabled = $this->getParameter( 'vs_application.vankosoft_api.enabled' );
        $apiBoard   = $this->getParameter( 'vs_application.vankosoft_api.kanbanboard' );
        
        if( ! $apiEnabled ) {
            throw new VankosoftApiException( 'VankoSoft API is NOT Enabled !!! Please Enable it and Configure it !!!' );
        }
        
        if ( $apiBoard === ProjectIssue::BOARD_UNDEFINED ) {
            throw new VankosoftApiException( 'VankoSoft API Kanbanboard Slug is NOT Defined !!!' );
        }
        
        $board          = $this->vsProject->getKanbanboard();
        $designations   = VsKanbanboardTask::BOARD_MEMBER_DESIGNATIONS;
        
        return $this->render( '@VSApplication/Pages/ProjectIssuesBoardTask/show.html.twig', [
            'designations'  => $designations,
            'board'         => $board,
            'task'          => $board['pipelines'][$pipelineId]['tasks'][$taskId],
            'pipelineId'    => $pipelineId,
            'taskId'        => $taskId,
            'pipelineSlug'  => $board['pipelines'][$pipelineId]['slug'],
        ]);
    }
    
    public function moveTaskAction( $taskId, $pipelineId, Request $request ): Response
    {
        $apiEnabled = $this->getParameter( 'vs_application.vankosoft_api.enabled' );
        $apiBoard   = $this->getParameter( 'vs_application.vankosoft_api.kanbanboard' );
        
        if( ! $apiEnabled ) {
            throw new VankosoftApiException( 'VankoSoft API is NOT Enabled !!! Please Enable it and Configure it !!!' );
        }
        
        if ( $apiBoard === ProjectIssue::BOARD_UNDEFINED ) {
            throw new VankosoftApiException( 'VankoSoft API Kanbanboard Slug is NOT Defined !!!' );
        }
        
        $response = $this->vsProject->moveKanbanboardTask( $taskId, $pipelineId );
        
        return new JsonResponse( $response );
    }
    
    public function assignMemberAction( $taskId, $memberId, Request $request ): Response
    {
        $apiEnabled = $this->getParameter( 'vs_application.vankosoft_api.enabled' );
        $apiBoard   = $this->getParameter( 'vs_application.vankosoft_api.kanbanboard' );
        
        if( ! $apiEnabled ) {
            throw new VankosoftApiException( 'VankoSoft API is NOT Enabled !!! Please Enable it and Configure it !!!' );
        }
        
        if ( $apiBoard === ProjectIssue::BOARD_UNDEFINED ) {
            throw new VankosoftApiException( 'VankoSoft API Kanbanboard Slug is NOT Defined !!!' );
        }
        
        $response = $this->vsProject->assignKanbanboardTaskMember( $taskId, $memberId );
        
        return new JsonResponse( $response );
    }
    
    public function createTaskAction( $pipelineId, Request $request ): Response
    {
        $apiEnabled = $this->getParameter( 'vs_application.vankosoft_api.enabled' );
        $apiBoard   = $this->getParameter( 'vs_application.vankosoft_api.kanbanboard' );
        
        if( ! $apiEnabled ) {
            throw new VankosoftApiException( 'VankoSoft API is NOT Enabled !!! Please Enable it and Configure it !!!' );
        }
        
        if ( $apiBoard === ProjectIssue::BOARD_UNDEFINED ) {
            throw new VankosoftApiException( 'VankoSoft API Kanbanboard Slug is NOT Defined !!!' );
        }
        
        $formOptions = $this->vsProject->getPipelineTaskFormData();
        $form = $this->createForm( KanbanboardTaskForm::class, null, [
            'action'        => $this->generateUrl( 'vs_application_project_issues_kanbanboard_pipeline_create_task', [
                'pipelineId'    => $pipelineId,
            ]),
            'method'        => 'POST',
            
            'pipeline_id'   => $pipelineId,
            'projectIssues' => $formOptions['issues'],
        ]);
        
        $form->handleRequest( $request );
        if( $form->isSubmitted() && $form->isValid() ) {
            $formData   = $form->getData();
            //echo '<pre>'; var_dump( $formData ); die;
            
            $response   = $this->vsProject->createKanbanboardTask( $formData );
            //echo '<pre>'; var_dump( $response ); die;
            
            return $this->redirect( $this->generateUrl( 'vs_application_project_issues_kanbanboard_show' ) );
        }
        
        return $this->render( '@VSApplication/Pages/ProjectIssuesBoard/partial/create_task_form.html.twig', [
            'form'          => $form,
            'boardMembers'  => $formOptions['members'],
        ]);
    }
    
    public function getAttachmentFormAction( $taskId, Request $request ): Response
    {
        $attachmentId   = 0;
        $formOptions    = [
            'action'    => $this->generateUrl( 'vs_application_project_issues_kanbanboard_task_save_attachment', [
                'taskId'        => $taskId,
                'attachmentId'  => $attachmentId,
            ]),
            'method'    => 'POST',
            'taskId'    => $taskId,
            'fileId'    => $attachmentId,
        ];
        $form   = $this->createForm( KanbanBoardTaskAttachmentForm::class, null, $formOptions );
        
        return $this->render( '@VSApplication/Pages/ProjectIssuesBoard/partial/attach_file_form.html.twig', [
            'form'      => $form,
            'fileId'    => $attachmentId,
        ]);
    }
    
    public function saveTaskAttachment( $taskId, $attachmentId, Request $request ): Response
    {
        if ( $request->isMethod( 'POST' ) ) {
            $em     = $this->doctrine->getManager();
            
            $id     = \intval( $request->request->get( 'attachmentId' ) );
            $entity = $this->attachmentsRepository->find( $id );
            
            
            $task   = $this->tasksRepository->find( $taskId );
            $entity->setTask( $task );
            
            $em->persist( $entity );
            $em->flush();
            
            return new JsonResponse([
                'status'   => Status::STATUS_OK
            ]);
        }
        
        return new JsonResponse([
            'status'    => Status::STATUS_ERROR,
            'message'   => 'Form NOT Submitted Properly !',
        ]);
    }
}
