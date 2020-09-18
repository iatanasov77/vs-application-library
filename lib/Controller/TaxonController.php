<?php namespace VS\ApplicationBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

use VS\ApplicationBundle\Entity\GeneralSettings;
use VS\ApplicationBundle\Form\GeneralSettingsForm;

class TaxonController extends Controller
{
    public function index( Request $request ): Response
    {
        $settings   = $this->getDoctrine()->getRepository( GeneralSettings::class )
                                            ->findBy( [], ['id'=>'DESC'], 1, 0 );
        
        $oSettings  = isset( $settings[0] ) ? $settings[0] : new GeneralSettings();
        $form       = $this->createForm( SettingsForm::class, $oSettings, ['data' => $oSettings, 'method' => 'POST'] );
        
        $form->handleRequest( $request );
        if( $form->isSubmitted() && $form->isValid() ) {
            $em = $this->getDoctrine()->getManager();
            $em->persist( $form->getData() );
            $em->flush();
            
            return $this->redirect($this->generateUrl( 'app_settings_index' ));
        }
        
        return $this->render( '@VSApplicationBundle/Settings/index.html.twig', [
            'form'  => $form->createView(),
            'item'  => $oSettings
        ]);
    }
}
