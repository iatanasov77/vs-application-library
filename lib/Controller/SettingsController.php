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
        
        $er             = $this->getSettingsRepository();
        $settings       = $er->findBy( [], ['id'=>'DESC'], 1, 0 );
        
        $oSettings      = isset( $settings[0] ) ? $settings[0] : $er->createNew();
        $form           = $this->resourceFormFactory->create( $configuration, $oSettings );
        //$form       = $this->createForm( SettingsForm::class, $oSettings, ['data' => $oSettings, 'method' => 'POST'] );
        
        $form->handleRequest( $request );
        if( $form->isSubmitted() && $form->isValid() ) {
            $em = $this->getDoctrine()->getManager();
            $em->persist( $form->getData() );
            $em->flush();
            
            return $this->redirect($this->generateUrl( 'vs_app_settings' ));
        }
        
        return $this->render( '@VSApplicationBundle/Settings/index.html.twig', [
            'form'          => $form->createView(),
            'settingsForm'  => $form,
            'item'          => $oSettings
        ]);
    }
    
    protected function getSettingsRepository()
    {
        return $this->get( 'vs_application.repository.settings' );
    }
}
