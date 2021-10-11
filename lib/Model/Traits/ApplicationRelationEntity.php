<?php namespace VS\ApplicationBundle\Model\Traits;

/**
 * @see \VS\ApplicationBundle\Model\Interfaces\ApplicationRelationInterface
 */
trait ApplicationRelationEntity
{
    /**
     * @var \VS\ApplicationBundle\Model\Interfaces\ApplicationInterface
     * 
     * @ORM\ManyToOne(targetEntity="App\Entity\Application\Application")
     */
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
