<?php

use Symfony\Component\Process\Process;

function base_dir($dir = "")
{
    return BASE_DIR . ds . $dir;
}

function app_dir($dir = "")
{
    return base_dir("app" . $dir = "");
}

function config_dir($dir = "")
{
    return base_dir("config" . $dir = "");
}

function bin_dir($dir)
{
    return base_dir("bin" . ds . $dir);
}

function icecast($config, array $option=[])
{

    $command =
    $icecast = run_file('/usr/bin/icecast2'." -b -c $config");

    //return run_file($icecast);
    return $icecast;
}

function run_file($filename)
{
    $process = new Process($filename);
    $process->run();

// executes after the command finishes
    if (!$process->isSuccessful()) {
        throw new \RuntimeException($process->getErrorOutput()." :: ".$process->getOutput());
    }

    return trim($process->getOutput());
}
function config ($config){

    $chunk = explode('.',$config);
    die( var_export($chunk ));
}