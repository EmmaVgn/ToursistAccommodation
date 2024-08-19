<?php

namespace App\Controller;

use App\Entity\Add;
use App\Entity\Booking;
use App\Form\BookingFormType;
use App\Repository\AddRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;


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

    #[Route('/api/ads/{slug}/not-available-days', name: 'ads_not_available_days', methods: ['GET'])]
    public function getNotAvailableDays($slug, AddRepository $adRepository): JsonResponse
    {
        $ad = $adRepository->findOneBy(['slug' => $slug]);

        if (!$ad) {
            return $this->json(['error' => 'Ad not found'], 404);
        }

        $notAvailableDays = $ad->getNotAvailableDays();
        $formattedDays = array_map(function ($day) {
            return $day->format('d.m.Y');
        }, $notAvailableDays);

        return $this->json($formattedDays);
    }
}
