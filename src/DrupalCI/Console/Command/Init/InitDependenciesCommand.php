<?php

/**
 * @file
 * Command class for init.
 */

namespace DrupalCI\Console\Command\Init;

//use Symfony\Component\Console\Command\Command as SymfonyCommand;
use DrupalCI\Console\Command\DrupalCICommandBase;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputOption;

class InitDependenciesCommand extends DrupalCICommandBase {

  /**
   * {@inheritdoc}
   */
  protected function configure() {
    $this
      ->setName('init:dependencies')
      ->setDescription('Validate and install any required DrupalCI dependencies')
      #->addOption(
      #  'dbtype', '', InputOption::VALUE_OPTIONAL | InputOption::VALUE_IS_ARRAY, 'Database types to support'
      #)
    ;
  }

  /**
   * {@inheritdoc}
   */
  public function execute(InputInterface $input, OutputInterface $output) {
    $output->writeln("<info>Executing init:dependencies</info>");
    $output->writeln('<comment>TODO: Implement init:dependency command.</comment>');
    $output->writeln('');
    # Check for presence of various binaries
    # curl
    # php
    # Others?
    #$this->showArguments($input, $output);
  }

}
