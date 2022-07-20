<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class TechnicController extends AbstractController
{
    /**
     * @Route("/technic", name="app_technic")
     */
    public function index(): Response
    {
        return $this->render('technic/index.html.twig', [
            'controller_name' => 'TechnicController',
        ]);
    }
}
