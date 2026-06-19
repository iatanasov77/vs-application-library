<?php namespace Vankosoft\CmsBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;
use Doctrine\Persistence\ManagerRegistry;

use Vankosoft\CmsBundle\Repository\SliderItemRepository;
use Vankosoft\CmsBundle\Repository\BannerRepository;
use Vankosoft\CmsBundle\Repository\QuickLinkRepository;

use Vankosoft\ApplicationBundle\Component\Status;

class SortController extends AbstractController
{
    /** @var ManagerRegistry */
    protected $doctrine;
    
    /** @var SliderItemRepository */
    protected $sliderItemRepository;
    
    /** @var BannerRepository */
    protected $bannerRepository;
    
    /** @var QuickLinkRepository */
    protected $quickLinkRepository;
    
    public function __construct(
        ManagerRegistry $doctrine,
        SliderItemRepository $sliderItemRepository,
        BannerRepository $bannerRepository,
        QuickLinkRepository $quickLinkRepository
    ) {
        $this->doctrine             = $doctrine;
        $this->sliderItemRepository = $sliderItemRepository;
        $this->bannerRepository     = $bannerRepository;
        $this->quickLinkRepository  = $quickLinkRepository;
    }
    
    public function sortSliderItemsAction( $id, $insertAfterId, Request $request ): Response
    {
        $em             = $this->doctrine->getManager();
        $item           = $this->sliderItemRepository->find( $id );
        $insertAfter    = $this->sliderItemRepository->find( $insertAfterId );
        $this->sliderItemRepository->insertAfter( $item, $insertAfterId );
        
        $position       = $insertAfter ? ( $insertAfter->getPosition() + 1 ) : 1;
        $item->setPosition( $position );
        $em->persist( $item );
        $em->flush();
        
        return new JsonResponse([
            'status'   => Status::STATUS_OK
        ]);
    }
    
    public function sortBannersAction( $id, $insertAfterId, Request $request ): Response
    {
        $em             = $this->doctrine->getManager();
        $item           = $this->bannerRepository->find( $id );
        $insertAfter    = $this->bannerRepository->find( $insertAfterId );
        $this->bannerRepository->insertAfter( $item, $insertAfterId );
        
        $position       = $insertAfter ? ( $insertAfter->getPosition() + 1 ) : 1;
        $item->setPosition( $position );
        $em->persist( $item );
        $em->flush();
        
        return new JsonResponse([
            'status'   => Status::STATUS_OK
        ]);
    }
    
    public function sorQuickLinksAction( $id, $insertAfterId, Request $request ): Response
    {
        $em             = $this->doctrine->getManager();
        $item           = $this->quickLinkRepository->find( $id );
        $insertAfter    = $this->quickLinkRepository->find( $insertAfterId );
        $this->quickLinkRepository->insertAfter( $item, $insertAfterId );
        
        $position       = $insertAfter ? ( $insertAfter->getPosition() + 1 ) : 1;
        $item->setPosition( $position );
        $em->persist( $item );
        $em->flush();
        
        return new JsonResponse([
            'status'   => Status::STATUS_OK
        ]);
    }
}