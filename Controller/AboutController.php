<?php namespace Vankosoft\ApplicationBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Vankosoft\ApplicationBundle\Component\Application\VersionInfo;
use Vankosoft\ApplicationInstalatorBundle\Model\InstalationInfoInterface;

class AboutController extends AbstractController
{
    /** @var VersionInfo */
    protected $versionInfo;
    
    public function __construct( VersionInfo $versionInfo )
    {
        $this->versionInfo  = $versionInfo;
    }
    
    public function index( Request $request ): Response
    {
        $versionInfo    = null;
        $versionData    = null;
        
        $currentVersion = $this->versionInfo->getCurrentVersion();
        if ( $currentVersion !== InstalationInfoInterface::VERSION_UNDEFINED ) {
            $versionInfo    = $this->versionInfo->getVersionInfo( $currentVersion );
        }
        
        if ( $versionInfo && $versionInfo->getId() ) {
            $versionData    = $versionInfo->getData();
        }
        
        return $this->render( '@VSApplication/Pages/Dashboard/about.html.twig', [
            'versionData' => $versionData,
        ]);
    }
}
