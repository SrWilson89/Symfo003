<?php
// src/Controller/DsbController.php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Service\VentasService; // Importa el servicio creado

class DsbController extends AbstractController
{
    #[Route('/dashboard', name: 'app_dashboard')]
    public function index(VentasService $ventasService): Response
    {
        $totalVentas = $ventasService->getTotalVentas();

        return $this->render('dsb/index.html.twig', [
            'totalVentas' => $totalVentas,
        ]);
    }
}