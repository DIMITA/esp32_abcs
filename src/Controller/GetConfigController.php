<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class GetConfigController extends AbstractController
{
    #[Route('/get/config', name: 'app_get_config')]
    public function index(): Response
    {
        return $this->render('get_config/index.html.twig', [
            'controller_name' => 'GetConfigController',
        ]);
    }
}
