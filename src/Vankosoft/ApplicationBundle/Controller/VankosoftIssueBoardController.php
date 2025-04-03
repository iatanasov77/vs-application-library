<?php namespace Vankosoft\ApplicationBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Form\FormInterface;
use Sylius\Resource\Doctrine\Persistence\RepositoryInterface;
use Sylius\Component\Resource\Factory\FactoryInterface;

use Vankosoft\ApplicationBundle\Component\Exception\VankosoftApiException;
use Vankosoft\ApplicationBundle\Component\ProjectIssue\ProjectIssue;
use Vankosoft\ApplicationBundle\Form\KanbanboardTaskForm;

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
        //echo '<pre>'; var_dump( $issues ); die;
        
        return $this->render( '@VSApplication/Pages/ProjectIssuesBoard/kanbanboard.html.twig', [
            'board' => $board
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
        
        $board = $this->vsProject->getKanbanboard();
        //echo '<pre>'; var_dump( $issues ); die;
        
        return $this->render( '@VSApplication/Pages/ProjectIssuesBoardTask/show.html.twig', [
            'board'         => $board,
            'task'          => $board['pipelines'][$pipelineId]['tasks'][$taskId],
            'pipelineId'    => $pipelineId,
            'taskId'        => $taskId,
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
        
        $board = $this->vsProject->getKanbanboard();
        //echo '<pre>'; var_dump( $issues ); die;
        
        return $this->render( '@VSApplication/Pages/ProjectIssuesBoardTask/show.html.twig', [
            'board' => $board
        ]);
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
        
        $board = $this->vsProject->getKanbanboard();
        //echo '<pre>'; var_dump( $issues ); die;
        
        return $this->render( '@VSApplication/Pages/ProjectIssuesBoardTask/show.html.twig', [
            'board' => $board
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
        
        $formOptions    = $this->vsProject->getPipelineTaskFormData();
        $form           = $this->createForm( KanbanboardTaskForm::class, null, [
            'action'        => $this->generateUrl( 'vs_application_project_issues_kanbanboard_pipeline_create_task', [
                'pipelineId'    => $pipelineId,
            ]),
            'method'        => 'POST',
            
            'pipeline_id'   => $pipelineId,
            'projectIssues' => $formOptions['issues'],
        ]);
        
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
        $apiEnabled = $this->getParameter( 'vs_application.vankosoft_api.enabled' );
        $apiBoard   = $this->getParameter( 'vs_application.vankosoft_api.kanbanboard' );
        
        if( ! $apiEnabled ) {
            throw new VankosoftApiException( 'VankoSoft API is NOT Enabled !!! Please Enable it and Configure it !!!' );
        }
        
        if ( $apiBoard === ProjectIssue::BOARD_UNDEFINED ) {
            throw new VankosoftApiException( 'VankoSoft API Kanbanboard Slug is NOT Defined !!!' );
        }
        
        $board = $this->vsProject->getKanbanboard();
        //echo '<pre>'; var_dump( $issues ); die;
        
        return $this->render( '@VSApplication/Pages/ProjectIssuesBoardTask/show.html.twig', [
            'board' => $board
        ]);
    }
}
