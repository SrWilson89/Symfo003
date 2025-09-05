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
            $arqueo->setVentasEfectivo($ventasEfectivo);
            $arqueo->setVentasTotal($ventasTotal);
            $arqueo->setCto1($request->request->get('cto1'));
            $arqueo->setCto2($request->request->get('cto2'));
            $arqueo->setCto5($request->request->get('cto5'));
            $arqueo->setCto10($request->request->get('cto10'));
            $arqueo->setCto20($request->request->get('cto20'));
            $arqueo->setCto50($request->request->get('cto50'));
            $arqueo->setEuro1($request->request->get('euro1'));
            $arqueo->setEuro2($request->request->get('euro2'));
            $arqueo->setEuro5($request->request->get('euro5'));
            $arqueo->setEuro10($request->request->get('euro10'));
            $arqueo->setEuro20($request->request->get('euro20'));
            $arqueo->setEuro50($request->request->get('euro50'));
            $arqueo->setEuro100($request->request->get('euro100'));
            $arqueo->setEuro200($request->request->get('euro200'));
            $arqueo->setEuro500($request->request->get('euro500'));

            $ventasUser = 0;
            $ventasUser += $arqueo->getCto1() * 0.01;
            $ventasUser += $arqueo->getCto2() * 0.02;
            $ventasUser += $arqueo->getCto5() * 0.05;
            $ventasUser += $arqueo->getCto10() * 0.10;
            $ventasUser += $arqueo->getCto20() * 0.20;
            $ventasUser += $arqueo->getCto50() * 0.50;
            $ventasUser += $arqueo->getEuro1();
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
        
        return $this->render('arqueo/index.html.twig', [
            'arqueo' => $arqueo,
            'ventasTotal' => $ventasTotal,
            'ventasEfectivo' => $ventasEfectivo,
            'descuadre' => $descuadre,
            'btnSaveDisplay' => $btnSaveDisplay,
            'btnConfirmDisplay' => $btnConfirmDisplay,
            'btnSave' => $btnSave
        ]);
    }
}