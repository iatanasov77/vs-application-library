<?php namespace VS\ApplicationBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

use VS\ApplicationBundle\Form\SettingsForm;

class SettingsExtController extends Controller
{
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
                $entity->setSite( $this->getSiteRepository()->find( $siteId ) );
            }
            
            $em = $this->getDoctrine()->getManager();
            $em->persist( $entity );
            $em->flush();
            
            $this->get( 'vs_app.settings_manager' )->clearCache( $siteId, true );
            
            return $this->redirect( $this->generateUrl( 'vs_application_settings_index' ) );
        }
        
        throw new \Exception( 'Settings Form Not Submited properly!' );
    }
    
    protected function getSiteRepository()
    {
        return $this->get( 'vs_application.repository.site' );
    }
}
