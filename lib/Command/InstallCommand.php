<?php namespace VS\ApplicationBundle\Command;

use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;
use Symfony\Component\Process\Exception\RuntimeException;

use Symfony\Component\Console\Helper\ProgressBar;
use Symfony\Component\Console\Helper\Table;

final class InstallCommand extends AbstractInstallCommand
{
    protected static $defaultName = 'vankosoft:install';
    
}
