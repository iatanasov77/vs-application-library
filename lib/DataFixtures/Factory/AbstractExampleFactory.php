<?php namespace VS\ApplicationBundle\DataFixtures\Factory;

use Symfony\Component\OptionsResolver\OptionsResolver;

abstract class AbstractExampleFactory implements ExampleFactoryInterface
{
    abstract protected function configureOptions( OptionsResolver $resolver ): void;
}
