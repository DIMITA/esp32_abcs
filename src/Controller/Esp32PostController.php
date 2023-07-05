<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use App\Entity\TimeSeries;
use DateTime;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpKernel\Attribute\AsController;


#[AsController]
class Esp32PostController extends AbstractController
{

    public $em;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->em = $entityManager;
    }
    public function __invoke(TimeSeries $timeSeries): TimeSeries
    {
        $timeSeries->setDateTimeOffset(new DateTime());
        $this->em->persist($timeSeries);
        $this->em->flush();
        return $timeSeries;
    }
}
