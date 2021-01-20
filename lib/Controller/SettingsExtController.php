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
    
    public function handle( Request $request ): Response
    {
        $form   = $this->createForm( SettingsForm::class );
        $form->handleRequest( $request );
        if( $form->isSubmitted() && $form->isValid() ) {
            $em = $this->getDoctrine()->getManager();
            $em->persist( $form->getData() );
            $em->flush();
            
            return $this->redirect( $this->generateUrl( 'vs_application_settings_index' ) );
        }
        
        throw new \Exception( 'Settings Form Not Submited properly!' );
    }
}
