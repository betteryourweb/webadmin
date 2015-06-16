<?php

namespace Betteryourweb\Commands;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Process\Process;

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

            ->addOption('--port', null, InputOption::VALUE_NONE, 'Choodee port for SSH.')

            ;
    }

    public function execute(InputInterface $input, OutputInterface $output)
    {
        $port = $input->getOption('port');

        if ($port) {
            $port = "--port $port";
        }

        $options = " -avzp --delete -e ssh $port ";

        $source = $input->getArgument('source');
        $dest = $input->getArgument('dest');
        $command = "rsync $options $source $dest";
        $output->writeln("<info>$command</info>");
        $process = new Process($command);
        $process->run();
        if (!$process->isSuccessful()) {
            //throw new \RuntimeException($process->getErrorOutput());
              return $output->writeln("<info>\n\n ERROR :: ".$process->getErrorOutput().'</info>');
        }

        return $output->writeln('<info>'."\n\n\nSuccess ::".$process->getOutput().'</info>');
                //return openssl_encrypt('-1','passwd',$password);
    }
}
