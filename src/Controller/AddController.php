<?php

namespace App\Controller;

use App\Entity\Add;
use App\Repository\AddRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/hebergement', name: 'add_')]
class AddController extends AbstractController
{
    #[Route('/', name: 'index')]
    public function index(AddRepository $addRepository): Response
    {
        $adds = $addRepository->findAll();
        return $this->render('add/index.html.twig', [
            'adds' => $adds
        ]);
    }

    #[Route('/{slug}', name: 'details', priority:-1)]
    public function details(
    Add $add,
    AddRepository $addRepository,
    $slug ): Response
    {
        $ad = $addRepository->findOneBy([
            'slug' => $slug
        ]);

        if (!$ad) {
            throw $this->createNotFoundException("L'annonce demandée n'existe pas");
        }

        return $this->render('add/show.html.twig', [
            'add' => $add
        ]);
    }
}
