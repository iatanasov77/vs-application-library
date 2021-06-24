<?php namespace VS\ApplicationBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

use VS\ApplicationBundle\Form\SettingsForm;

use VS\ApplicationBundle\Component\Settings\Settings as SettingsManager;
use Sylius\Bundle\ResourceBundle\Doctrine\ORM\EntityRepository;

class SettingsExtController extends AbstractController
{
    protected $settingsManager;
    
    protected $siteRepository;
    
    public function __construct(
        SettingsManager $settingsManager,
        EntityRepository $siteRepository
    ) {
        $this->settingsManager  = $settingsManager;
        $this->siteRepository   = $siteRepository;
    }
    
    public function index( Request $request ): Response
    {
        die ( 'NOT IMPLEMENTED !!!' );
    }
    
    public function handle( int $siteId, Request $request ): Response
    {
        $form   = $this->createForm( SettingsForm::class );
        $form->handleRequest( $request );
        if( $form->isSubmitted() && $form->isValid() ) {
            $entity = $form->getData();
            if ( $siteId && ( ! $entity->getSite() ) ) {
                $entity->setSite( $this->siteRepository->find( $siteId ) );
            }
            
            $em = $this->getDoctrine()->getManager();
            $em->persist( $entity );
            $em->flush();
            
            //$this->settingsManager->clearCache( $siteId, true );
            $this->settingsManager->saveSettings( $siteId );
            
            return $this->redirect( $this->generateUrl( 'vs_application_settings_index' ) );
        }
        
        throw new \Exception( 'Settings Form Not Submited properly!' );
    }
}
