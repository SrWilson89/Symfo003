<?php

namespace App\Controller;

use App\Entity\Arqueo;
use App\Entity\Asistencia;
use App\Entity\Producto;
use App\Entity\Venta;
use App\Entity\VentaDetalle;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use DateTime;
use App\Controller\MainController;

class TpvController extends AbstractController
{
    #[Route('/tpv', name: 'app_tpv')]
    public function index(Request $request, EntityManagerInterface $entityManager): Response
    {
        // 1. Comprobar que existe un empleado logueado (asistencia)
        $asistencia = $entityManager->getRepository(Asistencia::class)->findOneBy(['fechaFin' => null]);
        if (!$asistencia) {
            return $this->redirectToRoute('app_index');
        }

        // 2. Abrir arqueo
        if ($request->isMethod('POST') && $request->request->has('fondo')) {
            $fondo = $request->request->get('fondo');
            $arqueo = new Arqueo();
            $arqueo->setEmpleado($asistencia->getEmpleado());
            $arqueo->setFondo($fondo);
            $arqueo->setFechaInicio(new DateTime());

            $entityManager->persist($arqueo);
            $entityManager->flush();
        }

        // 3. Comprobar si hay un arqueo abierto
        $arqueoAbierto = $entityManager->getRepository(Arqueo::class)->findOneBy(['fechaFin' => null]);
        if (!$arqueoAbierto) {
            return $this->render('tpv/arqueo.html.twig', [
                'name' => 'Apertura de Arqueo',
            ]);
        }

        // 4. Obtener productos
        $productos = $entityManager->getRepository(Producto::class)->findToday();

        // 5. Renderizar la vista principal del TPV
        return $this->render('tpv/index.html.twig', [
            'productos' => $productos,
            'name' => 'TPV',
        ]);
    }
}