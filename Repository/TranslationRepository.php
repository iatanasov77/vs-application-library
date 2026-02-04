<?php namespace Vankosoft\ApplicationBundle\Repository;

use Gedmo\Translatable\Entity\Repository\TranslationRepository as BaseTranslationRepository;
use Sylius\Resource\Doctrine\Persistence\RepositoryInterface;
use Sylius\Bundle\ResourceBundle\Doctrine\ORM\ResourceRepositoryTrait;

class TranslationRepository extends BaseTranslationRepository implements RepositoryInterface
{
    use ResourceRepositoryTrait;
    
}