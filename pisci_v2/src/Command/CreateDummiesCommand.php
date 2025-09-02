<?php

namespace App\Command;

use App\Entity\Empleado;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

#[AsCommand(
    name: 'app:create-dummies',
    description: 'Adds some dummy employees to the database.',
)]
class CreateDummiesCommand extends Command
{
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        parent::__construct();
        $this->entityManager = $entityManager;
    }

    protected function configure(): void
    {
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);

        // Crear 5 empleados de prueba
        for ($i = 0; $i < 5; $i++) {
            $empleado = new Empleado();
            $empleado->setNombre("Nombre Emp " . $i);
            $empleado->setApellidos("Apellidos Emp " . $i);
            $empleado->setTelefono("6" . str_pad((string) $i, 8, "0", STR_PAD_LEFT));
            $empleado->setDni(str_pad((string) $i, 9, "0", STR_PAD_LEFT) . "A");
            
            $this->entityManager->persist($empleado);
        }

        $this->entityManager->flush();

        $io->success('5 empleados de prueba han sido creados correctamente.');

        return Command::SUCCESS;
    }
}