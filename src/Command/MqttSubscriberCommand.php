<?php

namespace App\Command;

use PhpMqtt\Client\MqttClient;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

#[AsCommand(
    name: 'app:mqtt-subscriber',
    description: 'Add a short description for your command',
)]
class MqttSubscriberCommand extends Command
{
    protected function configure(): void
    {
        $this
            ->addArgument('arg1', InputArgument::OPTIONAL, 'Argument description')
            ->addOption('option1', null, InputOption::VALUE_NONE, 'Option description');
    }

    private $server   = 'broker.hivemq.com';
    private $port     = 1883;
    private $clientId = 'Symfony-Client-ynov-lyon-2023esp32-teddy';
    private $topic = '/ynov-lyon-2023/esp32-teddy/in';

    protected function execute(InputInterface $input, OutputInterface $output): int
    {

        $mqtt = new MqttClient($this->server, $this->port, $this->clientId);
        $io = new SymfonyStyle($input, $output);
        if (!$mqtt->isConnected()) {
            var_dump('il est pas connecté');
            $mqtt->connect();
            $mqtt->subscribe($this->topic, function ($topic, $message, $retained, $matchedWildcards) {
            }, 0);

            $mqtt->loop(true);

            $io->success('You have a new command! Now make it your own! Pass --help to see your options.');
        }


        return Command::SUCCESS;
    }
}
