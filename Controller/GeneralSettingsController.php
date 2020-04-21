<?php namespace VS\ApplicationBundle\Controller;

use Sylius\Bundle\ResourceBundle\Controller\ResourceController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

use VS\ApplicationBundle\Form\GeneralSettingsForm;

class GeneralSettingsController extends ResourceController
{
    public function indexAction( Request $request ): Response
    {
        $configuration  = $this->requestConfigurationFactory->create( $this->metadata, $request );
        
        $er             = $this->get( 'vs_application.repository.settings' );
        $settings       = $er->findBy( [], ['id'=>'DESC'], 1, 0 );
        
        $oSettings  = isset( $settings[0] ) ? $settings[0] : $er->createNew();
        $form       = $this->resourceFormFactory->create( $configuration, $oSettings );
        
        if ( in_array( $request->getMethod(), ['POST', 'PUT', 'PATCH'], true ) && $form->handleRequest( $request)->isValid() ) {
            $em = $this->getDoctrine()->getManager();
            $em->persist( $form->getData() );
            $em->flush();
            
            return $this->redirect( $this->generateUrl( 'vs_app_settings' ) );
        }
        
        return $this->render( '@VSApplication/Settings/index.html.twig', [
            'form'  => $form->createView(),
            'item'  => $oSettings
        ]);
    }
}
