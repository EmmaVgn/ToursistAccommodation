<?php

namespace App\Controller;

use App\Entity\Add;
use App\Entity\Booking;
use App\Form\BookingFormType;
use App\Repository\AddRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

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
        $booking = new Booking;
        
        $ad = $addRepository->findOneBy([
            'slug' => $slug
        ]);

        if (!$ad) {
            throw $this->createNotFoundException("L'annonce demandée n'existe pas");
        }

        $notAvailableDays = $ad->getNotAvailableDays();

        $form = $this->createForm(BookingFormType::class, $booking);

        return $this->render('add/show.html.twig', [
            'add' => $add,
            'form' => $form->createView(),
            'notAvailableDays' => $notAvailableDays,
        ]);
    }
}
