<?php

namespace App\Controller;

use App\Repository\AddRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class HomeController extends AbstractController
{
    #[Route('/', name: 'homepage')]
    public function index(AddRepository $addRepository): Response
    {
        $add = $addRepository->findAll();

        return $this->render('home/index.html.twig', [
            'add' => $add,
            'controller_name' => 'HomeController',
        ]);
    }

}
