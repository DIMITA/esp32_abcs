<?php

namespace App\Command;

use App\Entity\Device;
use App\Entity\ServerSettings;
use App\Entity\TimeSeries;
use App\Entity\UplinkMessages;
use App\Repository\DeviceRepository;
use DateTime;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;
use Symfony\Component\HttpClient\HttpClient;
use Symfony\Contracts\HttpClient\HttpClientInterface;

#[AsCommand(
    name: 'app:req-syncnetwork',
    description: 'Add a short description for your command',
)]
class ReqSyncnetworkCommand extends Command
{
    protected function configure(): void
    {
        $this
            ->addArgument('arg1', InputArgument::OPTIONAL, 'Argument description')
            ->addOption('option1', null, InputOption::VALUE_NONE, 'Option description');
    }

    public $url = "https://eu1.cloud.thethings.network/api/v3/as/applications/soulmbengue-app-lorawansrv-1/packages/storage/uplink_message";
    public $key = "NNSXS.AFXIMSE6QXHFGBFXSYHMQQ6XFXJKDAOKRNFGHHI.N4WWBDZ7B7TNJA4IKJ6DGZAS6PNSRQBXZSWPFZT5ZSON52NGJW2A";
    public $em;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->em = $entityManager;

        parent::__construct();
    }


    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $client = HttpClient::create();

        $serverSettings = $this->em->getRepository(ServerSettings::class)->findAll();
        $serverSetting = null;
        $lastupdate = null;
        $query = null;
        if (!empty($serverSettings)) {
            $serverSetting = $serverSettings[0];
            $lastupdate = $serverSetting->getLastConnection();
        } else {
            $serverSetting = new ServerSettings();
            $serverSetting->setUrl($this->url);
        }

        $url = $query != null ? $this->url . '?after=' .  $lastupdate->format('Timezone') : $this->url;
        dd($url);

        $response = $client->request(
            'GET',
            $url,
            ['auth_bearer' => $this->key]
        );
        $io = new SymfonyStyle($input, $output);


        $contentArray = explode("\n", $response->getContent());

        foreach ($contentArray as $value) {
            $resp = null !== json_decode($value) ? json_decode($value)->{"result"} : null;

            if (isset($resp)) {

                $device = $this->em->getRepository(Device::class)->findByFonctionnalityId($resp->{"end_device_ids"}->{"dev_eui"})[0];
                if (isset($device)) {

                    $uplinkMessage = new UplinkMessages();
                    $uplinkMessage->setDeviceId($device);
                    $uplinkMessage->setRawPayload(json_encode($resp->{"uplink_message"}->{"decoded_payload"}));
                    $uplinkMessage->setReceivedAt(new DateTime($resp->{"uplink_message"}->{"received_at"}));
                    $payloadArray = (array) $resp->{"uplink_message"}->{"decoded_payload"};

                    $this->em->persist($uplinkMessage);
                    $this->em->flush();

                    foreach (array_keys($payloadArray) as $key) {

                        $timeseries = new TimeSeries();
                        $timeseries->setName($key);
                        $timeseries->setValue($payloadArray[$key]);
                        $timeseries->setDateTimeOffset(new DateTime($resp->{"uplink_message"}->{"received_at"}));
                        $timeseries->setDeviceId($device);
                        $timeseries->setUplinkMessageId($uplinkMessage);

                        $this->em->persist($timeseries);
                        $this->em->flush();
                    }
                } else {
                    $io->error("Cette device n'est pas enrégistré", $resp->{"end_device_ids"}->{"device_id"});
                }
            }
        }

        $serverSetting->setLastConnection(new DateTime());
        $this->em->persist($serverSetting);
        $this->em->flush();

        $arg1 = $input->getArgument('arg1');

        if ($arg1) {
            $io->note(sprintf('You passed an argument: %s', $arg1));
        }

        if ($input->getOption('option1')) {
            // ...
        }

        return Command::SUCCESS;
    }
}
