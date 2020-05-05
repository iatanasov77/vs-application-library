<?php namespace VS\ApplicationBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

use VS\ApplicationBundle\Form\SettingsForm;

class SettingsExtController extends Controller
{
    public function handle( Request $request ): Response
    {
        $er             = $this->get( 'vs_application.repository.settings' );
        $settings       = $er->findBy( [], ['id'=>'DESC'], 1, 0 );
        
        $oSettings  = isset( $settings[0] ) ? $settings[0] : $er->createNew();
        $form       = $this->createForm( SettingsForm::class, $oSettings );
        
        if ( in_array( $request->getMethod(), ['POST', 'PUT', 'PATCH'], true ) && $form->handleRequest( $request)->isValid() ) {
            $em     = $this->getDoctrine()->getManager();
            $entity = $form->getData();
            $site   = $this->getTaxon( (int)$request->attributes->get( 'siteId' ) );
            if ( $site ) {
                $siteSettings   = $entity->getSite();
                if ( ! $siteSettings ) {
                    $siteSettings   = $this->get( 'vs_application.factory.site_settings' )->createNew();
                    
                    $siteSettings->setSite( $site );
                    $siteSettings->setSettings( $entity );
                    
                    $em->persist( $siteSettings );
                    $entity->setSite( $siteSettings );
                }
            }
            
            $em->persist( $entity );
            $em->flush();
            
            return $this->redirect( $this->generateUrl( 'vs_application_settings_index' ) );
        }
    }
    
    protected function getTaxon( $taxonId )
    {
        if ( ! $taxonId ) {
            return null;
        }
        
        return $this->get( 'vs_application.repository.taxon' )->find( $taxonId );
    }
}
