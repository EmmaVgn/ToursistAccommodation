<?php

namespace App\Controller\Booking;

use App\Entity\Booking;
use App\Form\BookingFormType;
use App\Repository\AddRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class BookingConfirmationController extends AbstractController
{
    protected $em;

    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
    }

    #[Route('/booking/confirm/{slug}', name: 'booking_confirm')]
    #[IsGranted('ROLE_USER', message: 'Vous devez être connecté pour confirmer une réservation')]
    public function confirm($slug, AddRepository $addRepository, Request $request): Response
    {
        $add = $addRepository->findOneBy([
            'slug' => $slug
        ]);

        if (!$add) {
            throw $this->createNotFoundException("L'annonce demandée n'existe pas");
        }

        // 1. Nous voulons lire les données du formulaire - Request
        $form = $this->createForm(BookingFormType::class);
        $form->handleRequest($request);

        // 2. Nous allons créer une réservation
        /** @var Booking */
        $booking = $form->getData();
        if ($form->isSubmitted() && $form->isValid()) {
            $user = $this->getUser();
            $booking->setTraveler($user)
                    ->setAdds($add);

            // Si les dates ne sont pas disponibles, message d'erreur
            if (!$booking->isBookableDates()) {
                $this->addFlash('warning', "Les dates que vous avez choisies ne peuvent être réservées : elles sont déjà prises.");
            } else {
                $this->em->persist($booking);
                $this->em->flush();

                return $this->redirectToRoute('booking_payment_form', [
                    'id' => $booking->getId()
                ]);
            }

        }

        return $this->render('add/show.html.twig', [
            'add' => $add,
            'form' => $form->createView()
        ]);
    }
}
