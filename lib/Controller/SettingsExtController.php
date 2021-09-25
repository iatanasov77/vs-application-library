<?php namespace VS\ApplicationBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

use VS\ApplicationBundle\Form\SettingsForm;
use VS\ApplicationBundle\Repository\TaxonomyRepository;
use VS\ApplicationBundle\Component\Settings\Settings as SettingsManager;
use Sylius\Bundle\ResourceBundle\Doctrine\ORM\EntityRepository;
use Sylius\Component\Resource\Factory\Factory;

class SettingsExtController extends AbstractController
{
    protected $settingsManager;
    
    protected $siteRepository;
    
    protected $settingsRepository;
    
    protected $settingsFactory;
    
    /** @var TaxonomyRepository */
    protected $taxonomyRepository;
    
    public function __construct(
        SettingsManager $settingsManager,
        EntityRepository $siteRepository,
        EntityRepository $settingsRepository,
        Factory $settingsFactory,
        TaxonomyRepository $taxonomyRepository
    ) {
        $this->settingsManager      = $settingsManager;
        $this->siteRepository       = $siteRepository;
        $this->settingsRepository   = $settingsRepository;
        $this->settingsFactory      = $settingsFactory;
        $this->taxonomyRepository   = $taxonomyRepository;
    }
    
    public function index( int $siteId, Request $request ): Response
    {
        $site                       = $this->siteRepository->find( $siteId );
        $settings                   = $this->settingsRepository->getSettings( $site );
        $form                       = $this->createForm( SettingsForm::class, $settings ?: 
                                            $this->settingsFactory->createNew() );
        $taxonomyPagesCategories    = $this->taxonomyRepository->findByCode(
                                            $this->getParameter( 'vs_application.page_categories.taxonomy_code' )
                                        );
        
        return $this->render( '@VSApplication/Pages/Settings/partial/settings-form.html.twig', [
            'siteId'        => $siteId,
            'form'          => $form->createView(),
            'pcTaxonomyId'  => $taxonomyPagesCategories ? $taxonomyPagesCategories->getId() : 0,
        ]);
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
