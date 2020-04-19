<?php namespace VS\ApplicationBundle;

use Symfony\Component\HttpKernel\Bundle\Bundle;

class VSApplicationBundle extends Bundle
{
    public function getContainerExtension()
    {
        return new \VS\ApplicationBundle\DependencyInjection\VSApplicationExtension();
    }
}
