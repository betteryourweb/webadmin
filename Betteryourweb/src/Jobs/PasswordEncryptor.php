<?php

namespace Betteryourweb\Jobs;

use Symfony\Component\Process\Process;

class PasswordEncryptor {
/**
 * [__construct description]
 */
  public function __construct(){

  }
/**
 * [open_ssl description]
 * @param  [type] $password [description]
 * @return [type]           [description]
 */
  public function open_ssl($password){
    $process = new Process("openssl passwd -1 $password");
    $process->run();
    if (!$process->isSuccessful()) {
      throw new \RuntimeException($process->getErrorOutput());
    }
    
    return  trim($process->getOutput());
  }
}
