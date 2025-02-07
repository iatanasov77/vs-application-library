<?php namespace Vankosoft\ApplicationBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Form\FormInterface;
use Sylius\Resource\Doctrine\Persistence\RepositoryInterface;

use Vankosoft\ApplicationBundle\Component\Exception\VankosoftApiException;
use Vankosoft\ApplicationBundle\Component\Application\ProjectIssue;
use Vankosoft\ApplicationBundle\Form\ProjectIssueForm;

class VankosoftIssueBoardController extends AbstractController
{
    /** @var ProjectIssue */
    private $vsProject;
    
    public function __construct(
        ProjectIssue $vsProject
    ) {
        $this->vsProject    = $vsProject;
    }
    
    public function showAction( Request $request ): Response
    {
        $apiEnabled = $this->getParameter( 'vs_application.vankosoft_api.enabled' );
        $apiBoard   = $this->getParameter( 'vs_application.vankosoft_api.kanbanboard' );
        
        if( ! $apiEnabled ) {
            throw new VankosoftApiException( 'VankoSoft API is NOT Enabled !!! Please Enable it and Configure it !!!' );
        }
        
        if ( $apiBoard === ProjectIssue::BOARD_UNDEFINED ) {
            throw new VankosoftApiException( 'VankoSoft API Kanbanboard Slug is NOT Defined !!!' );
        }
        
        return $this->render( '@VSApplication/Pages/ProjectIssuesBoard/show.html.twig', [
            
        ]);
    }
}
