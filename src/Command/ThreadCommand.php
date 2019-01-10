<?php

namespace App\Command;

use App\Model\Autoloader;
use App\Model\Task;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

class ThreadCommand extends Command
{
    protected static $defaultName = 'app:pthread';

    protected function configure()
    {
        $this
            ->setDescription('Add a short description for your command')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $s = microtime(true);

//        Как должно быть
//        $thread = new class extends Thread {
//            public function run() {
//                echo "Hello World\n";
//            }
//        };
//
//        $thread->start() && $thread->join();

        $pool = new \Pool(4, Autoloader::class, ["vendor/autoload.php"]);
        /* submit a task to the pool */
        $pool->submit(new Task("Hello World!"));
        $pool->submit(new Task("Hello World!"));
        $pool->submit(new Task("Hello World!"));
        /* in the real world, do some ::collect somewhere */
        /* shutdown, because explicit is good */
        $pool->shutdown();

        dump('use ' . (microtime(true) - $s) . ' s');
    }
}
