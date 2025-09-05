<?php
// src/Controller/SecurityController.php

namespace App\Controller;

use App\Entity\Asistencia;
use App\Repository\EmpleadoRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;
use DateTime;
use DateTimeImmutable; // He añadido esta línea para usar DateTimeImmutable

class SecurityController extends AbstractController
{
    #[Route('/login', name: 'app_login')]
    public function login(AuthenticationUtils $authenticationUtils, EmpleadoRepository $empleadoRepository, Request $request, EntityManagerInterface $entityManager): Response
    {
        $empleadoId = $request->query->get('id_empleado');
        if ($empleadoId) {
            $empleado = $empleadoRepository->find($empleadoId);
            if ($empleado) {
                // Lógica de inicio de sesión manual para el sistema de asistencia
                $asistencia = new Asistencia();
                $asistencia->setEmpleado($empleado);
                $asistencia->setFechaInicio(new DateTimeImmutable()); // He cambiado 'DateTime()' por 'new DateTimeImmutable()'
                $entityManager->persist($asistencia);
                $entityManager->flush();
                
                $this->addFlash('success', 'Sesión iniciada con éxito para ' . $empleado->getNombre() . '.');
                return $this->redirectToRoute('app_dashboard');
            }
        }

        // Obtener todos los empleados para mostrarlos
        $empleados = $empleadoRepository->findAll();

        return $this->render('security/login.html.twig', [
            'empleados' => $empleados,
            'last_username' => null, // No se usa un formulario de usuario/contraseña
            'error' => null,
        ]);
    }

    #[Route('/logout', name: 'app_logout')]
    public function logout(EntityManagerInterface $entityManager): Response
    {
        $asistencia = $entityManager->getRepository(Asistencia::class)->findOneBy(['fechaFin' => null]);
        if ($asistencia) {
            $asistencia->setFechaFin(new DateTimeImmutable()); // He cambiado 'DateTime()' por 'new DateTimeImmutable()'
            $entityManager->flush();
        }

        throw new \LogicException('This method can be blank - it will be intercepted by the logout key on your firewall.');
    }
}
