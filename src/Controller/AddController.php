<?php

namespace App\Controller;

use App\Entity\Add;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/hebergement', name: 'add_')]
class AddController extends AbstractController
{
    #[Route('/', name: 'index')]
    public function index(): Response
    {
        return $this->render('add/index.html.twig');
    }

    #[Route('/{slug}', name: 'details')]
    public function details(Add $add): Response
    {
        return $this->render('add/details.html.twig', compact('add'));
    }
}
