<?php namespace VS\ApplicationBundle\Model\Traits;

/**
 * @see \VS\ApplicationBundle\Model\Interfaces\ApplicationRelationInterface
 */
trait ApplicationRelationTrait
{
    /** @var \VS\ApplicationBundle\Model\Interfaces\ApplicationInterface */
    protected $application;
    
    public function getApplication()
    {
        return $this->application;
    }
    
    public function setApplication( $application ) : self
    {
        $this->application  = $application;
        
        return $this;
    }
}
