<?php namespace Vankosoft\ApplicationBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;

use Vankosoft\UsersBundle\Security\SecurityBridge;
use Vankosoft\ApplicationBundle\Component\Status;
use Vankosoft\ApplicationBundle\Component\Exception\VankosoftApiException;
use Vankosoft\ApplicationBundle\Component\ProjectIssue\ProjectIssue;
use Vankosoft\ApplicationBundle\Component\ProjectIssue\KanbanboardTask as VsKanbanboardTask;
use Vankosoft\ApplicationBundle\Form\KanbanboardTaskForm;
use Vankosoft\ApplicationBundle\Form\KanbanBoardSubTaskForm;
use Vankosoft\ApplicationBundle\Form\KanbanBoardTaskAttachmentForm;
use Vankosoft\ApplicationBundle\Form\ProjectIssueCommentForm;

class VankosoftIssueBoardController extends AbstractController
{
    /** @var SecurityBridge */
    private $securityBridge;
    
    /** @var ProjectIssue */
    private $vsProject;
    
    public function __construct(
        SecurityBridge $securityBridge,
        ProjectIssue $vsProject
    ) {
        $this->securityBridge   = $securityBridge;
        $this->vsProject        = $vsProject;
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
    
    public function showTaskAction( $taskId, Request $request ): Response
    {
        $apiEnabled = $this->getParameter( 'vs_application.vankosoft_api.enabled' );
        $apiBoard   = $this->getParameter( 'vs_application.vankosoft_api.kanbanboard' );
        
        if( ! $apiEnabled ) {
            throw new VankosoftApiException( 'VankoSoft API is NOT Enabled !!! Please Enable it and Configure it !!!' );
        }
        
        if ( $apiBoard === ProjectIssue::BOARD_UNDEFINED ) {
            throw new VankosoftApiException( 'VankoSoft API Kanbanboard Slug is NOT Defined !!!' );
        }
        
        $response       = $this->vsProject->getKanbanboardTask( $taskId );
        $designations   = VsKanbanboardTask::BOARD_MEMBER_DESIGNATIONS;
        
        return $this->render( '@VSApplication/Pages/ProjectIssuesBoardTask/show.html.twig', [
            'designations'  => $designations,
            'task'          => $response['task'],
            'board'         => $response['board'],
//             'taskId'        => $taskId,
//             'pipelineSlug'  => $board['pipelines'][$pipelineId]['slug'],
            
            'commentForm'   => $this->createForm( ProjectIssueCommentForm::class, null, [
                //'action'    => $formAction,
            ]),
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
    
    public function deleteMemberAction( $taskId, $memberId, Request $request ): Response
    {
        $response   = $this->vsProject->deleteKanbanboardTaskMember([
            'taskId'    => $taskId,
            'memberId'  => $memberId,
        ]);
        
        $redirectUrl    = $request->request->get( 'redirectUrl' );
        if ( $redirectUrl ) {
            return $this->redirect( $redirectUrl );
        }
        
        return new JsonResponse([
            'status'    => Status::STATUS_OK,
        ]);
    }
    
    public function createIssueAction( $pipelineId, $parentTaskId, Request $request ): Response
    {
        $user       = $this->securityBridge->getUser();
        if ( ! $user->getKanbanBboardMember() ) {
            return new JsonResponse([
                'status'    => Status::STATUS_ERROR,
                'message'   => 'The logged user should have a Kanban Board Member Created.',
            ]);
        }
        
        $issue  = $this->issuesFactory->createNew();
        $form   = $this->createForm( ProjectIssueForm::class, $issue, [
            'action'    => $this->generateUrl( 'vs_application_project_issues_kanbanboard_task_create_issue', [
                'pipelineId'    => $pipelineId,
                'parentTaskId'  => $parentTaskId
            ]),
            'method'    => 'POST',
        ]);
        
        $form->handleRequest( $request );
        if( $form->isSubmitted() && $form->isValid() ) {
            $submitedIssue  = $form->getData();
            $submitedIssue->setCreatedBy( $user->getKanbanBboardMember() );
            
            $this->doctrine->getManager()->persist( $submitedIssue );
            $this->doctrine->getManager()->flush();
            
            $this->eventDispatcher->dispatch( new GenericEvent( $submitedIssue ), ProjectIssueEvents::POST_CREATE );
            
            return new JsonResponse([
                'status'   => Status::STATUS_OK,
                'payload'   => [
                    'pipelineId'    => $pipelineId,
                    'parentTaskId'  => $parentTaskId,
                    'issueId'       => $submitedIssue->getId(),
                ],
            ]);
        }
        
        $tagsContext    = $this->tagsWhitelistContext->findByTaxonCode( 'project-issue-labels' );
        return $this->render( 'Pages/KanbanBoards/partial/create_issue_form.html.twig', [
            'form'              => $form,
            'labelsWhitelist'   => $tagsContext->getTagsArray(),
        ]);
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
    
    public function getSubTaskFormAction( $taskId, $issueId, $subTaskId, Request $request ): Response
    {
        $response       = $this->vsProject->getKanbanboardTask( $taskId );
        
        $formOptions    = [
            'action'    => $this->generateUrl( 'vs_application_project_issues_kanbanboard_task_get_subtask_form', [
                'taskId'    => $taskId,
                'subTaskId' => $subTaskId,
                'issueId'   => $issueId,
            ]),
            'method'    => 'POST',
        ];
        $form   = $this->createForm( KanbanBoardSubTaskForm::class, $subTask, $formOptions );
        
        $form->handleRequest( $request );
        if( $form->isSubmitted() && $form->isValid() ) {
            $subTask    = $form->getData();
            
            $em = $this->doctrine->getManager();
            $em->persist( $subTask );
            $em->flush();
            
            return $this->redirectToRoute( 'vs_application_project_issues_kanbanboard_task_show', [
                'taskId'        => $taskId
            ]);
        }
        
        return $this->render( 'Pages/KanbanBoardTasks/subtask_form.html.twig', [
            'form'          => $form,
            'item'          => $response['task'],
            'boardMembers'  => $response['board']['members'],
        ]);
    }
    
    public function getCommentFormAction( $taskId, Request $request ): Response
    {
        
    }
    
    public function saveCommentFormAction( $taskId, Request $request ): Response
    {
        
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
    
    public function downloadTaskAttachment( $taskId, $attachmentId, Request $request ): Response
    {
        return new JsonResponse([
            'status'    => Status::STATUS_ERROR,
            'message'   => 'Action NOT Implemented !!!',
        ]);
    }
    
    public function deleteTaskAttachment( $taskId, $attachmentId, Request $request ): Response
    {
        $response   = $this->vsProject->deleteKanbanboardTaskAttachment([
            'attachmentId'  => $attachmentId,
        ]);
        
        $redirectUrl    = $request->request->get( 'redirectUrl' );
        if ( $redirectUrl ) {
            return $this->redirect( $redirectUrl );
        }
        
        return new JsonResponse([
            'status'    => Status::STATUS_OK,
        ]);
    }
}
