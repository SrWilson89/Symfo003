<?php

namespace App\Controller;

use App\Entity\Cliente;
use App\Form\ClienteType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ClienteController extends AbstractController
{
    #[Route('/cliente/{id}', name: 'app_cliente_ver')]
    public function ver(Cliente $cliente): Response
    {
        return $this->render('cliente/ver.html.twig', [
            'cliente' => $cliente,
        ]);
    }
}