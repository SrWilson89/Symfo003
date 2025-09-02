<?php
// src/Controller/TpvController.php

namespace App\Controller;

use App\Repository\ProductoRepository;
use App\Service\AsistenciaManager;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class TpvController extends AbstractController
{
    #[Route("/tpv", name: "app_tpv")]
    public function index(AsistenciaManager $asistenciaManager, ProductoRepository $productoRepository): Response
    {
        // Comprobamos si hay un empleado logeado
        if (!$asistenciaManager->isSessionActive()) {
            return $this->redirectToRoute('app_index');
        }

        // Obtenemos los productos activos para el día de hoy
        $productos = $productoRepository->findTodayProducts();

        return $this->render('tpv/index.html.twig', [
            'name' => 'TPV',
            'productos' => $productos,
        ]);
    }
}