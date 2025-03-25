<?php namespace Vankosoft\ApplicationBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Form\FormInterface;
use Sylius\Resource\Doctrine\Persistence\RepositoryInterface;
use Sylius\Component\Resource\Factory\FactoryInterface;

use Vankosoft\ApplicationBundle\Component\Exception\VankosoftApiException;
use Vankosoft\ApplicationBundle\Component\ProjectIssue\ProjectIssue;
use Vankosoft\ApplicationBundle\Form\ProjectIssueForm;

class VankosoftIssueBoardController extends AbstractController
{
    /** @var ProjectIssue */
    private $vsProject;
    
    /** @var RepositoryInterface */
    private $pipelinesRepository;
    
    /** @var FactoryInterface */
    private $tasksFactory;
    
    public function __construct(
        ProjectIssue $vsProject
//         RepositoryInterface $pipelinesRepository,
//         FactoryInterface $tasksFactory
    ) {
        $this->vsProject            = $vsProject;
//         $this->pipelinesRepository  = $pipelinesRepository;
//         $this->tasksFactory         = $tasksFactory;
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
        
        $board = $this->vsProject->getKanbanboard( $apiBoard );
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
        
        $board = $this->vsProject->getKanbanboard( $apiBoard );
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
        
        $board = $this->vsProject->getKanbanboard( $apiBoard );
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
        
        $board = $this->vsProject->getKanbanboard( $apiBoard );
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
        
        $board = $this->vsProject->getKanbanboard( $apiBoard );
        
        $pipeline   = $this->pipelinesRepository->find( $pipelineId );
        $task       = $this->tasksFactory->createNew();
        $task->setPipeline( $pipeline );
        
        $form   = $this->createForm( KanbanBoardCreateTaskForm::class, $task, [
            'action'    => $this->generateUrl( 'vsorg_kanbanboard_pipeline_create_task', [
                'pipelineId'    => $pipelineId,
            ]),
            'method'    => 'POST',
        ]);
        
        return $this->render( '@VSApplication/Pages/ProjectIssuesBoard/partial/create_task_form.html.twig', [
            'form'          => $form,
            'boardMembers'  => $board['members'],
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
        
        $board = $this->vsProject->getKanbanboard( $apiBoard );
        //echo '<pre>'; var_dump( $issues ); die;
        
        return $this->render( '@VSApplication/Pages/ProjectIssuesBoardTask/show.html.twig', [
            'board' => $board
        ]);
    }
}
