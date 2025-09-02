<?php
// src/Service/AsistenciaManager.php

namespace App\Service;

use App\Entity\Asistencia;
use App\Entity\Empleado; // Importamos la entidad Empleado
use App\Repository\AsistenciaRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\RequestStack;

class AsistenciaManager
{
    private $entityManager;
    private $asistenciaRepository;
    private $requestStack;

    public function __construct(
        EntityManagerInterface $entityManager,
        AsistenciaRepository $asistenciaRepository,
        RequestStack $requestStack
    ) {
        $this->entityManager = $entityManager;
        $this->asistenciaRepository = $asistenciaRepository;
        $this->requestStack = $requestStack;
    }

    private function getSession()
    {
        return $this->requestStack->getSession();
    }

    public function isSessionActive(): bool
    {
        // Comprueba si hay una asistencia activa en la base de datos
        // y si el id de asistencia está en la sesión
        return $this->asistenciaRepository->findCurrent() !== null && $this->getSession()->has('asistencia_id');
    }

    // Aceptamos la entidad Empleado como argumento
    public function startSession(Empleado $empleado): void
    {
        // Crea una nueva entidad Asistencia
        $asistencia = new Asistencia();
        // Seteamos la entidad Empleado directamente
        $asistencia->setEmpleado($empleado);

        $this->entityManager->persist($asistencia);
        $this->entityManager->flush();

        // Guarda el ID de la asistencia en la sesión para futura referencia
        $this->getSession()->set('asistencia_id', $asistencia->getId());
    }

    public function closeSession(): void
    {
        // Obtiene la asistencia actual de la base de datos
        $asistencia = $this->asistenciaRepository->findCurrent();
        
        if ($asistencia) {
            // Establece la fecha de fin y guarda los cambios
            $asistencia->setFechaFin(new \DateTime());
            $this->entityManager->flush();

            // Cierra la sesión del navegador
            $this->getSession()->clear();
        }
    }
}