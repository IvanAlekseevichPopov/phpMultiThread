<?php

namespace App\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

class SwooleCommand extends Command
{
    protected static $defaultName = 'app:swoole';

    protected function configure()
    {
        $this
            ->setDescription('Add a short description for your command')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
//        \Swoole\Runtime::enableCoroutine();

        $s = microtime(true);
        for ($c = 10; $c--;) {
            go(function () {
                \Co::sleep(2);
//                sleep(2);
            });
        }

        \Swoole\Event::wait();

        dump('use ' . (microtime(true) - $s) . ' s');
    }
}
