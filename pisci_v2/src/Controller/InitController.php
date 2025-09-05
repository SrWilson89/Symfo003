<?php
// src/Controller/InitController.php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\classes\bd;

class InitController extends AbstractController
{
    #[Route('/init', name: 'app_init')]
    public function init(): Response
    {
        try {
            bd::init();
            $message = "¡Base de datos y tablas creadas con éxito!";
            $type = "success";
        } catch (\Exception $e) {
            $message = "Error al crear la base de datos y tablas: " . $e->getMessage();
            $type = "danger";
        }

        return new Response('
            <!DOCTYPE html>
            <html lang="es">
            <head>
                <meta charset="UTF-8">
                <meta name="viewport" content="width=device-width, initial-scale=1">
                <title>Inicialización</title>
                <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
            </head>
            <body>
                <div class="container mt-5">
                    <div class="alert alert-'.$type.'" role="alert">
                        '.$message.'
                    </div>
                </div>
            </body>
            </html>
        ');
    }
}