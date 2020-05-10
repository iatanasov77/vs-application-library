<?php namespace VS\ApplicationBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use VS\ApplicationBundle\Model\Interfaces\SettingsInterface;
use VS\ApplicationBundle\Form\SettingsForm;

class SettingsExtController extends Controller
{
    public function index( Request $request ): Response
    {
        $oSettings      = $this->getEntity( 0 );
        //var_dump($oSettings->getLanguages()); die;
        $form           = $this->createForm( SettingsForm::class, $oSettings, [
            'data'      => $oSettings,
            'method'    => 'POST'
        ]);
        
        $siteSettings   = [];
        if ( $this->container->getParameter( 'vs_application.multi_site' ) ) {
            $taxonomyIds    = $this->container->getParameter( 'vs_application.taxonomy' );
            $siteTaxonomy   = $this->get( 'vs_application.repository.taxonomy' )->find( $taxonomyIds['sites'] );
            
            foreach ( $siteTaxonomy->getTaxons() as $site ) {
                $oSettingsSite      = $this->getEntity( $site->getId() );
                $formSite           = $this->createForm( SettingsForm::class, $oSettingsSite, [
                    'data'      => $oSettingsSite,
                    'method'    => 'POST'
                ]);
                
                $siteSettings[] = [
                    'site'  => $site,
                    'form'  => $formSite->createView()
                ];
            }
        }
        
        return $this->render( '@VSApplication/Settings/index.html.twig', [
            'settingsForm'  => $form->createView(),
            'item'          => $oSettings,
            'siteSettings'  => $siteSettings
        ]);
    }
    
    public function handle( Request $request ): Response
    {
        $siteId     = (int)$request->attributes->get( 'siteId' );
        $em         = $this->getDoctrine()->getManager();
        
        $oSettings  = $this->getEntity( $siteId );
        $form       = $this->createForm( SettingsForm::class, $oSettings );
        
        if ( in_array( $request->getMethod(), ['POST', 'PUT', 'PATCH'], true ) && $form->handleRequest( $request)->isValid() ) {
            $entity = $form->getData();
            
            $em->persist( $entity );
            $em->flush();
        }
        
        return $this->redirect( $this->generateUrl( 'vs_app_settings_edit' ) );
    }
    
    protected function getEntity( $siteId ): SettingsInterface
    {
        $er     = $this->get( 'vs_application.repository.settings' );
        $fact   = $this->get( 'vs_application.factory.settings' );
        
        if ( $siteId ) {
            $site       = $this->getTaxon( $siteId );
            $oSettings  = $er->getSettings( $site );
            if ( ! $oSettings ) {
                $oSettings      = $fact->createNew();
                $siteSettings   = $this->get( 'vs_application.factory.site_settings' )->createNew();
                
                $siteSettings->setSite( $site );
                $siteSettings->setSettings( $oSettings );

                $oSettings->setSite( $siteSettings );
            }
        } else {
            $oSettings      = $er->getSettings();
            $oSettings      = $oSettings ?: $fact->createNew();
        }
        
        return $oSettings;
    }
    
    protected function getTaxon( $taxonId )
    {
        if ( ! $taxonId ) {
            return null;
        }
        
        return $this->get( 'vs_application.repository.taxon' )->find( $taxonId );
    }
}
