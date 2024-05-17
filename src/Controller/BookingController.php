<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class BookingController extends AbstractController
{
    #[Route('/tarif', name: 'booking_page')]
    public function index(): Response
    {
        return $this->render('booking/tarif.html.twig', [
            'controller_name' => 'BookingController',
        ]);
    }
}
