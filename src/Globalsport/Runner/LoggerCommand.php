<?php

namespace Globalsport\Runner;

use GearmanWorker;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class LoggerCommand extends Command
{
    protected function configure()
    {
        $this->setName('gearman:execution-time');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $worker = new GearmanWorker();
        $worker->addServer();
        $worker->addFunction("executionTime", function ($e) {

            $fsockopen = fsockopen('tcp://0.0.0.0', 12122);
            fwrite($fsockopen, $e->workload());
            fclose($fsockopen);


        });
        while ($worker->work()) ;
    }


}