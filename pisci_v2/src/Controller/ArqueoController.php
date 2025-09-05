<?php

namespace App\Controller;

use App\Entity\Arqueo;
use App\Repository\ArqueoRepository;
use App\Repository\VentaRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use DateTime;

class ArqueoController extends AbstractController
{
    #[Route('/arqueo', name: 'app_arqueo')]
    public function index(Request $request, ArqueoRepository $arqueoRepository, VentaRepository $ventaRepository, EntityManagerInterface $entityManager): Response
    {
        // Obtener el arqueo actual
        $arqueo = $arqueoRepository->findOneBy(['fechaFin' => null]);

        if (!$arqueo) {
            $this->addFlash('danger', 'No hay ningún arqueo de caja abierto.');
            return $this->redirectToRoute('app_tpv');
        }

        $now = new DateTime();
        $arqueo->setFechaFin($now);
        $ventasTotal = $ventaRepository->getTotalVentas($arqueo->getFechaInicio(), $arqueo->getFechaFin());
        $ventasEfectivo = $ventaRepository->getTotalVentas($arqueo->getFechaInicio(), $arqueo->getFechaFin(), true);
        
        $descuadre = 0;
        $btnSaveDisplay = '';
        $btnConfirmDisplay = 'style="display:none;"';
        $btnSave = '';

        if ($request->isMethod('POST')) {
            $arqueo->setCto1($request->request->get('1cto', 0));
            $arqueo->setCto2($request->request->get('2cto', 0));
            $arqueo->setCto5($request->request->get('5cto', 0));
            $arqueo->setCto10($request->request->get('10cto', 0));
            $arqueo->setCto20($request->request->get('20cto', 0));
            $arqueo->setCto50($request->request->get('50cto', 0));
            $arqueo->setEuro1($request->request->get('1euro', 0));
            $arqueo->setEuro2($request->request->get('2euro', 0));
            $arqueo->setEuro5($request->request->get('5euro', 0));
            $arqueo->setEuro10($request->request->get('10euro', 0));
            $arqueo->setEuro20($request->request->get('20euro', 0));
            $arqueo->setEuro50($request->request->get('50euro', 0));
            $arqueo->setEuro100($request->request->get('100euro', 0)); // Agregado si lo necesitas
            $arqueo->setEuro200($request->request->get('200euro', 0)); // Agregado si lo necesitas
            $arqueo->setEuro500($request->request->get('500euro', 0)); // Agregado si lo necesitas

            // Calcular el total introducido por el usuario
            $ventasUser = 0;
            $ventasUser += $arqueo->getCto1() * 0.01;
            $ventasUser += $arqueo->getCto2() * 0.02;
            $ventasUser += $arqueo->getCto5() * 0.05;
            $ventasUser += $arqueo->getCto10() * 0.1;
            $ventasUser += $arqueo->getCto20() * 0.2;
            $ventasUser += $arqueo->getCto50() * 0.5;
            $ventasUser += $arqueo->getEuro1() * 1;
            $ventasUser += $arqueo->getEuro2() * 2;
            $ventasUser += $arqueo->getEuro5() * 5;
            $ventasUser += $arqueo->getEuro10() * 10;
            $ventasUser += $arqueo->getEuro20() * 20;
            $ventasUser += $arqueo->getEuro50() * 50;
            $ventasUser += $arqueo->getEuro100() * 100;
            $ventasUser += $arqueo->getEuro200() * 200;
            $ventasUser += $arqueo->getEuro500() * 500;

            $descuadre = $ventasEfectivo + $arqueo->getFondo() - $ventasUser;
            $arqueo->setDescuadre($descuadre);

            if ($request->request->has('guardar')) {
                if (abs($descuadre) > 0.001) { // Usa un margen para evitar problemas de precisión
                    $this->addFlash('danger', 'Descuadre de ' . number_format(abs($descuadre), 2) . ' €.');
                    $btnSaveDisplay = 'style="display:none;"';
                    $btnConfirmDisplay = '';
                } else {
                    $this->addFlash('success', 'Arqueo correcto.');
                    $entityManager->flush();
                    $btnSave = 'disabled';
                }
            }

            if ($request->request->has('confirmar')) {
                $entityManager->flush();
                $this->addFlash('success', 'Arqueo confirmado.');
                $btnSaveDisplay = '';
                $btnConfirmDisplay = 'style="display:none;"';
                $btnSave = 'disabled';
            }
        }
        
        $arqueo->setVentasTotal($ventasTotal);
        $arqueo->setVentasEfectivo($ventasEfectivo);

        return $this->render('arqueo/index.html.twig', [
            'arqueo' => $arqueo,
            'descuadre' => $descuadre,
            'btnSave' => $btnSave,
            'btnSaveDisplay' => $btnSaveDisplay,
            'btnConfirmDisplay' => $btnConfirmDisplay,
        ]);
    }
}