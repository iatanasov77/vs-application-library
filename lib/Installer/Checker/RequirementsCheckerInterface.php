<?php namespace VS\ApplicationBundle\Installer\Checker;

use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

interface RequirementsCheckerInterface
{
    public function check( InputInterface $input, OutputInterface $output ): bool;
}
