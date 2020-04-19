<?php namespace VS\ApplicationBundle\Model;

use Sylius\Component\Resource\Model\ResourceInterface;

class Taxonomy implements ResourceInterface
{
    protected $id;
    
    public function getId()
    {
        return $this->id;
    }
}
