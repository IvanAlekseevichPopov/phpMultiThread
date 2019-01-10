<?php

namespace App\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

class ForkCommand extends Command
{
    protected static $defaultName = 'app:fork';

    protected function configure()
    {
        $this
            ->setDescription('Add a short description for your command')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $s = microtime(true);

        $pid = pcntl_fork();
        if ($pid == -1) {
            die("could not fork");
        } else if ($pid) {
            //parent
            sleep(1);
        } else {
            //child
            sleep(2);
        }

        dump('use ' . (microtime(true) - $s) . ' s');
    }
}
