<?php

namespace Betteryourweb\Commands;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Process\Process;
use Betteryourweb\Jobs\PasswordEncryptor as Password;

class SyncCommand extends Command
{
    public function __construct()
    {
        parent::__construct();
    }
    public function configure()
    {
        return  $this->setName('sync')
            ->setDescription('Syncing for secondary servers')
            ->addArgument('source', InputArgument::REQUIRED)
            ->addArgument('dest', InputArgument::REQUIRED)


            ->addOption('--files', null, InputOption::VALUE_NONE,'Force deletion of all user files')

            ;

    }

    public function execute(InputInterface $input, OutputInterface $output)
    {
      $force = $input->getOption('force');
      if($force) $force = "--force";

      $remove = $input->getOption('remove');
      if($remove) $remove = "--remove";

      $options = " $force $remove ";

      $user = $input->getArgument('user');
      $command =  "userdel $options $user";
      $output->writeln("<info>$command</info>");
    }
}
