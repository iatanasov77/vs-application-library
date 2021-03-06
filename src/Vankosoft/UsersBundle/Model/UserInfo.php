<?php namespace Vankosoft\UsersBundle\Model;

use Doctrine\ORM\Mapping as ORM;

use Vankosoft\CmsBundle\Model\FileInterface;

class UserInfo implements UserInfoInterface
{
    /**
     * @var mixed
     */
    protected $id;
    
    /**
     * Relation to the User entity
     *
     * @var mixed
     */
    protected $user;
    
    
    /**
     * @var FileInterface|null
     */
    protected $avatar;
    
    /**
     * @var string
     */
    protected $firstName    = 'NOT_EDITED_YET';
    
    /**
     * @var string
     */
    protected $lastName     = 'NOT_EDITED_YET';
    
    /**
     * @var string
     */
    protected $country;
    
    /**
     * @var \DateTime|null
     */
    protected $birthday;
    
    /**
     * @var string
     */
    protected $mobile;
    
    /**
     * @var string
     */
    protected $website;
    
    /**
     * @var string
     */
    protected $occupation;
    
    public function getId()
    {
        return $this->id;
    }
    
    public function getUser()
    {
        return $this->user;
    }
    
    public function setUser( User $user ) : self
    {
        $this->user = $user;
        
        return $this;
    }
    
    public function getAvatar(): ?FileInterface
    {
        return $this->avatar;
    }
    
    public function setAvatar( ?FileInterface $avatar ): self
    {
        $avatar->setOwner( $this );
        $this->avatar   = $avatar;
        
        return $this;
    }
    
    public function getFirstName()
    {
        return $this->firstName;
    }
    
    public function setFirstName( $firstName ) : self
    {
        $this->firstName = $firstName;
        
        return $this;
    }
    
    public function getLastName()
    {
        return $this->lastName;
    }
    
    public function setLastName( $lastName ) : self
    {
        $this->lastName = $lastName;
        
        return $this;
    }
    
    public function getCountry()
    {
        return $this->country;
    }
    
    public function setCountry( $country ) : self
    {
        $this->country = $country;
        
        return $this;
    }
    
    public function getBirthday()
    {
        return $this->birthday;
    }
    
    public function setBirthday( \DateTime $birthday ) : self
    {
        $this->birthday = $birthday;
        
        return $this;
    }
    
    public function getMobile()
    {
        return $this->mobile;
    }
    
    public function setMobile( $mobile ) : self
    {
        $this->mobile = $mobile;
        
        return $this;
    }
    
    public function getWebsite()
    {
        return $this->website;
    }
    
    public function setWebsite( $website ) : self
    {
        $this->website = $website;
        
        return $this;
    }
    
    public function getOccupation() {
        return $this->occupation;
    }
    
    public function setOccupation( $occupation ) : self
    {
        $this->occupation = $occupation;
        
        return $this;
    }
    
    public function getFullName()
    {
        return $this->firstName . ' ' . $this->lastName;
    }
}
