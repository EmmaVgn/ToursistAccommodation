<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class HomeController extends AbstractController
{
    #[Route('/', name: 'homepage')]
    public function index(): Response
    {
        return $this->render('home/index.html.twig', [
            'controller_name' => 'HomeController',
        ]);
    }

        // Test route for designing the confirmation email
        #[Route('/email', name: 'email')]
        public function email(): Response
        {
            return $this->render('registration/confirmation_email.html.twig', [
                "signedUrl" => "https://example.com/signed-url",
            ]);
        }
}
