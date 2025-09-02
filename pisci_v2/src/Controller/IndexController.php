<?php
// src/Controller/IndexController.php

namespace App\Controller;

use App\Repository\EmpleadoRepository;
use App\Service\AsistenciaManager;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class IndexController extends AbstractController
{
    #[Route("/", name: "app_index")]
    public function index(
        AsistenciaManager $asistenciaManager,
        EmpleadoRepository $empleadoRepository
    ): Response {
        // Si ya hay una sesión de asistencia activa, redirigir al dashboard
        if ($asistenciaManager->isSessionActive()) {
            return $this->redirectToRoute('app_dashboard');
        }

        // Obtener todos los empleados para mostrarlos en los botones
        $empleados = $empleadoRepository->findAll();

        return $this->render('index/index.html.twig', [
            'name' => 'Inicio',
            'empresa' => 'Mi Piscina',
            'empleados' => $empleados
        ]);
    }

    #[Route("/login", name: "app_login", methods: ["GET"])]
    public function login(
        Request $request,
        AsistenciaManager $asistenciaManager,
        // Inyectamos EmpleadoRepository para obtener la entidad completa
        EmpleadoRepository $empleadoRepository
    ): Response {
        $empleadoId = $request->query->getInt('id_empleado');

        if ($empleadoId) {
            // Obtenemos la entidad Empleado
            $empleado = $empleadoRepository->find($empleadoId);
            
            // Si el empleado existe, iniciamos la sesión
            if ($empleado) {
                $asistenciaManager->startSession($empleado);
            }
        }

        return $this->redirectToRoute('app_dashboard');
    }

    #[Route("/logout", name: "app_logout")]
    public function logout(AsistenciaManager $asistenciaManager): Response
    {
        $asistenciaManager->closeSession();

        // Redirige al index para volver a la pantalla de inicio de sesión
        return $this->redirectToRoute('app_index');
    }
}