<?php
// src/Controller/DsbController.php

namespace App\Controller;

use App\Repository\VentaRepository;
use App\Repository\AforoRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class DsbController extends AbstractController
{
    #[Route("/dashboard", name: "app_dashboard")]
    public function index(VentaRepository $ventaRepository, AforoRepository $aforoRepository): Response
    {
        // 1. Obtener las ventas y el aforo del día
        $ventasPorHora = $ventaRepository->findSalesByHour(new \DateTime('today'));
        $aforoPorHora = $aforoRepository->findAforoByHour(new \DateTime('today'));

        // 2. Preparar los datos para la vista
        $horas = [];
        $ventas = [];
        $aforo = [];

        // Asegúrate de que los datos cubren todas las horas del día
        for ($i = 0; $i < 24; $i++) {
            $hora = sprintf('%02d:00', $i);
            $horas[] = $hora;
            $ventas[$hora] = 0;
            $aforo[$hora] = 0;
        }

        foreach ($ventasPorHora as $item) {
            $horas[] = $item['hora'];
            $ventas[$item['hora']] = (float) $item['total'];
        }

        foreach ($aforoPorHora as $item) {
            $horas[] = $item['hora'];
            $aforo[$item['hora']] = (int) $item['total'];
        }
        
        $horas = array_unique($horas);
        sort($horas);
        
        $ventasData = array_values($ventas);
        $aforoData = array_values($aforo);

        // 3. Renderizar la vista
        return $this->render('dsb/index.html.twig', [
            'name' => 'Dashboard',
            'ventasData' => $ventasData,
            'aforoData' => $aforoData,
            'horas' => $horas
        ]);
    }
}