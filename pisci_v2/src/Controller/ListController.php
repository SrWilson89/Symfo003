<?php

namespace App\Controller;

use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ListController extends AbstractController
{
    #[Route('/list/{entityName}', name: 'app_list')]
    public function index(string $entityName, EntityManagerInterface $entityManager): Response
    {
        // Mapea el nombre de la ruta a la clase de entidad
        $entities = [
            'clientes' => 'App\\Entity\\Cliente',
            'empleados' => 'App\\Entity\\Empleado',
            'productos' => 'App\\Entity\\Producto',
            'ventas' => 'App\\Entity\\Venta',
            'asociados' => 'App\\Entity\\Asociado',
            // Agrega más entidades si es necesario
        ];

        // Verifica si el nombre de la entidad es válido
        if (!isset($entities[$entityName])) {
            throw $this->createNotFoundException('La tabla solicitada no existe.');
        }

        $className = $entities[$entityName];
        $repository = $entityManager->getRepository($className);
        $items = $repository->findAll();

        return $this->render('list/index.html.twig', [
            'entityName' => $entityName,
            'items' => $items,
        ]);
    }
}