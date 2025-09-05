<?php

namespace App\Controller;

use App\Entity\Asociado;
use App\Entity\Cliente;
use App\Form\AsociadoType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AsociadoController extends AbstractController
{
    #[Route('/asociado/nuevo/{id_cliente}', name: 'app_asociado_nuevo')]
    #[Route('/asociado/editar/{id}', name: 'app_asociado_editar')]
    public function form(Request $request, EntityManagerInterface $entityManager, ?int $id = null, ?int $id_cliente = null): Response
    {
        if ($id) {
            $asociado = $entityManager->getRepository(Asociado::class)->find($id);
            if (!$asociado) {
                throw $this->createNotFoundException('No se encontró el asociado.');
            }
        } else {
            $asociado = new Asociado();
            $cliente = $entityManager->getRepository(Cliente::class)->find($id_cliente);
            if (!$cliente) {
                throw $this->createNotFoundException('No se encontró el cliente.');
            }
            $asociado->setCliente($cliente);
        }

        $form = $this->createForm(AsociadoType::class, $asociado);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // Lógica para manejar el titular
            if ($asociado->esTitular()) {
                $cliente = $asociado->getCliente();
                $cliente->setAsociado($asociado);
            }
            
            $entityManager->persist($asociado);
            $entityManager->flush();
            $this->addFlash('success', 'El asociado se ha guardado correctamente.');
            return $this->redirectToRoute('app_cliente_ver', ['id' => $asociado->getCliente()->getId()]);
        }

        return $this->render('asociado/form.html.twig', [
            'asociadoForm' => $form,
        ]);
    }

    #[Route('/asociado/eliminar/{id}', name: 'app_asociado_eliminar')]
    public function eliminar(Asociado $asociado, EntityManagerInterface $entityManager): Response
    {
        $clienteId = $asociado->getCliente()->getId();
        $entityManager->remove($asociado);
        $entityManager->flush();
        $this->addFlash('success', 'El asociado se ha eliminado correctamente.');
        return $this->redirectToRoute('app_cliente_ver', ['id' => $clienteId]);
    }
}