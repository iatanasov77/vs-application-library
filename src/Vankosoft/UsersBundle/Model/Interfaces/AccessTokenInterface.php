<?php namespace Vankosoft\UsersBundle\Model\Interfaces;

interface AccessTokenInterface
{
    public function getAccessToken(): ?string;
    public function setAccessToken( ?string $accessToken ): self;
}
