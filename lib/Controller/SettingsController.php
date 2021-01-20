<?php namespace VS\ApplicationBundle\Controller;

use Sylius\Bundle\ResourceBundle\Controller\ResourceController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

use VS\ApplicationBundle\Form\SettingsForm;

class SettingsController extends ResourceController
{
    public function indexAction( Request $request ): Response
    {
        $configuration  = $this->requestConfigurationFactory->create( $this->metadata, $request );
        
        $er             = $this->getRepository();
        $factory        = $this->getFactory();
        $settings       = $er->findBy( [], ['id'=>'DESC'], 1, 0 );
        
        $oSettings      = isset( $settings[0] ) ? $settings[0] : $factory->createNew();
        $form           = $this->resourceFormFactory->create( $configuration, $oSettings );
        //$form       = $this->createForm( SettingsForm::class, $oSettings, ['data' => $oSettings, 'method' => 'POST'] );
        
        $form->handleRequest( $request );
        if( $form->isSubmitted() && $form->isValid() ) {
            $em = $this->getDoctrine()->getManager();
            $em->persist( $form->getData() );
            $em->flush();
            
            return $this->redirect( $this->generateUrl( 'vs_application_settings' ) );
        }
        
        return $this->render( '@VSApplication/Settings/index.html.twig', [
            'form'          => $form->createView(),
            'settingsForm'  => $form,
            'item'          => $oSettings
        ]);
    }
    
    protected function getRepository()
    {
        return $this->get( 'vs_application.repository.settings' );
    }
    
    protected function getFactory()
    {
        return $this->get( 'vs_application.factory.settings' );
    }
}
