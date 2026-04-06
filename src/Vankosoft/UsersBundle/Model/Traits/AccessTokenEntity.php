<?php namespace Vankosoft\UsersBundle\Model\Traits;

use Doctrine\ORM\Mapping as ORM;

trait AccessTokenEntity
{
    /** @var string */
    #[ORM\Column(name: "access_token", type: "string", length: 255, nullable: true)]
    protected $accessToken;
    
    public function getAccessToken(): ?string
    {
        return $this->accessToken;
    }
    
    public function setAccessToken( ?string $accessToken ): self
    {
        $this->accessToken = $accessToken;
        
        return $this;
    }
}
