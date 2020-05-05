<?php namespace VS\ApplicationBundle\Controller;

use Sylius\Bundle\ResourceBundle\Controller\ResourceController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class SettingsController extends ResourceController
{
    public function indexAction( Request $request ): Response
    {
        $configuration  = $this->requestConfigurationFactory->create( $this->metadata, $request );
        
        $er             = $this->get( 'vs_application.repository.settings' );
        $settings       = $er->findBy( [], ['id'=>'DESC'], 1, 0 );
        
        $oSettings  = isset( $settings[0] ) ? $settings[0] : $er->createNew();
        $form       = $this->resourceFormFactory->create( $configuration, $oSettings );
        
        /**
         * @NOTE '->createView()' from '$form' variable is removed here 
         *          so it can to use form multiple times
         */
        return $this->render( '@VSApplication/Settings/index.html.twig', [
            'settingsForm'  => $form,   // $form->createView()
            'item'  => $oSettings
        ]);
    }
}
