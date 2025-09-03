<?php
// src/Service/AsistenciaManager.php

namespace App\Service;

use App\Entity\Asistencia;
use App\Entity\Empleado;
use App\Repository\AsistenciaRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\RequestStack;

class AsistenciaManager
{
    private EntityManagerInterface $em;
    private AsistenciaRepository $asistenciaRepository;
    private RequestStack $requestStack;

    public function __construct(
        EntityManagerInterface $em,
        AsistenciaRepository $asistenciaRepository,
        RequestStack $requestStack
    ) {
        $this->em = $em;
        $this->asistenciaRepository = $asistenciaRepository;
        $this->requestStack = $requestStack;
    }

    private function getSession()
    {
        return $this->requestStack->getSession();
    }

    public function isSessionActive(): bool
    {
        return $this->asistenciaRepository->findCurrent() !== null && $this->getSession()->has('asistencia_id');
    }

    public function startSession(Empleado $empleado): void
    {
        $asistencia = new Asistencia();
        $asistencia->setEmpleado($empleado);
        $asistencia->setFechaInicio(new \DateTimeImmutable());

        $this->em->persist($asistencia);
        $this->em->flush();

        $this->getSession()->set('asistencia_id', $asistencia->getId());
    }

    public function closeSession(): void
    {
        $asistencia = $this->asistenciaRepository->findCurrent();

        if ($asistencia) {
            $asistencia->setFechaFin(new \DateTimeImmutable());
            $this->em->flush();
            $this->getSession()->clear();
        }
    }
}