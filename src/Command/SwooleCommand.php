<?php

namespace App\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class SwooleCommand extends Command
{
    protected static $defaultName = 'app:swoole';

    protected function configure()
    {
        $this
            ->setDescription('Add a short description for your command');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        \Swoole\Runtime::enableCoroutine();

        $s = microtime(true);
//        $this->simpleTest();
//        $this->demoChan();
        $this->testChan();

        dump('use '.(microtime(true) - $s).' s');
    }

    protected function simpleTest()
    {
        for ($c = 10; $c--;) {
            go(function () {
//                \Co::sleep(2);
                sleep(2);
                var_dump('thread');
//                sleep(2);
            });
        }

        dump('Waiting fo threads');
        \Swoole\Event::wait();

        dump('Done');
    }

    protected function demoChan()
    {
        $chan = new \Swoole\Channel(1024 * 256);
        $n = 10;
        $bytes = 0;
        if (pcntl_fork() > 0) {
            echo "Parent process\n";
            for ($i = 0; $i < $n; $i++) {
                $data = str_repeat('A', rand(100, 200));
                if ($chan->push($data) === false) {
                    echo "The channel is full\n";
                    usleep(1000);
                    $i--;
                    continue;
                }
                $bytes += strlen($data);
            }
            echo "Total pushed data size: $bytes bytes\n";
            var_dump($chan->stats());
        } else {
            echo "Child process\n";
            for ($i = 0; $i < $n; $i++) {
                $data = $chan->pop();
                if ($data === false) {
                    echo "The channel is empty\n";
                    usleep(1000);
                    $i--;
                    continue;
                }
                $bytes += strlen($data);
            }
            echo "Total popped data size: $bytes bytes\n";
            var_dump($chan->stats());
        }
    }

    protected function testChan()
    {
        go(function () {
            // User: I need you to bring me some information back.
            // Channel: OK! I will be responsible for scheduling.
            $channel = new \Swoole\Coroutine\Channel;

            go(function () use ($channel) {
                // Coroutine A: Ok! I will show you the github addr info
                $addrInfo = \Co::getaddrinfo('github.com');
                sleep(1);
                $channel->push(['A', json_encode($addrInfo, JSON_PRETTY_PRINT)]);
            });

            go(function () use ($channel) {
                // Coroutine C: Ok! I will show you the date
                sleep(1);
                $channel->push(['C', date(DATE_W3C)]);
            });

            for ($i = 2; $i--;) {
                list($id, $data) = $channel->pop();
                echo "From {$id}:\n {$data}\n";
            }
            // User: Amazing, I got every information at earliest time!
        });

        \Swoole\Event::wait();
    }
}
