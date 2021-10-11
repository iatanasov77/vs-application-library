<?php namespace VS\ApplicationBundle\Model\Traits;

use VS\UsersBundle\Model\UserInterface;

/**
 * @see \VS\ApplicationBundle\Model\Interfaces\UserAwareInterface
 */
trait UserAwareTrait
{
    /** @var \VS\UsersBundle\Model\UserInterface */
    protected $user;
    
    public function getUser()
    {
        return $this->user;
    }
    
    public function setUser( ?UserInterface $user ) : self
    {
        $this->user  = $user;
        
        return $this;
    }
}
