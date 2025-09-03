<?php

namespace App\Controller;

use App\Entity\Venta;
use App\Form\VentaType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class VentaController extends AbstractController
{
    #[Route('/venta/nueva', name: 'app_venta_nueva')]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $venta = new Venta();
        $form = $this->createForm(VentaType::class, $venta);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($venta);
            $entityManager->flush();

            // Puedes redirigir a donde necesites, por ejemplo al dashboard
            return $this->redirectToRoute('app_dashboard');
        }

        return $this->render('venta/new.html.twig', [
            'ventaForm' => $form->createView(),
        ]);
    }
}