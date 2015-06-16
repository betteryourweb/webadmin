<?php

namespace Betteryourweb\Commands;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Process\Process;
use Betteryourweb\Jobs\PasswordEncryptor as Password;

class UserAddCommand extends Command
{
    public function __construct()
    {
        parent::__construct();
    }
    public function configure()
    {
        return  $this->setName('user:create')
            ->setDescription('Create new system user')
            ->addArgument('user', InputArgument::REQUIRED)

            ->addOption('password', null, InputOption::VALUE_OPTIONAL, 'Choose a password for the user', 'password');
    }

    public function execute(InputInterface $input, OutputInterface $output)
    {
        $shell = '/bin/bash';
        $user = $input->getArgument('user');
        $password = $input->getOption('password');
        $output->writeln("<info>\n\n".$password."\n\n</info>");
        $home_dir = '-m -d /web/home/'.$user;

        $encrypt = new Password();
        $enc_password = $encrypt->open_ssl($password);

        $message = 'Creating new system user '.$enc_password;

        $output->writeln("<info>\n\n$message\n\n</info>");
        $command = "useradd ${home_dir}  -s $shell --password '{$enc_password}' $user";
        $output->writeln("<info>\n\n$command\n\n</info>");

        $process = new Process($command);
        $process->run();
        if (!$process->isSuccessful()) {
            //throw new \RuntimeException($process->getErrorOutput());
              return $output->writeln("<info>\n\n ERROR :: ".$process->getErrorOutput()."</info>");
        }

        return $output->writeln('<info>'."\n\n\nSuccess ::".$process->getOutput().'</info>');
                //return openssl_encrypt('-1','passwd',$password);
    }
}
