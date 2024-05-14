<?php

namespace App\Controller\Admin;

use App\Entity\Add;
use App\Entity\User;
use App\Entity\Image;
use App\Entity\Review;
use App\Entity\Booking;
use App\Entity\Equipment;
use App\Controller\Admin\AddCrudController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use EasyCorp\Bundle\EasyAdminBundle\Config\MenuItem;
use EasyCorp\Bundle\EasyAdminBundle\Config\Dashboard;
use EasyCorp\Bundle\EasyAdminBundle\Router\AdminUrlGenerator;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractDashboardController;

class DashboardController extends AbstractDashboardController
{
    #[Route('/admin', name: 'admin')]
    public function index(): Response
    {
        // return parent::index();

        // Option 1. You can make your dashboard redirect to some common page of your backend
        //
        $adminUrlGenerator = $this->container->get(AdminUrlGenerator::class);
        return $this->redirect($adminUrlGenerator->setController(BookingCrudController::class)->generateUrl());
    }

    public function configureDashboard(): Dashboard
    {
        return Dashboard::new()
            ->setTitle('Appartement Noa');
    }

    public function configureMenuItems(): iterable
    {
        yield MenuItem::linkToDashboard('Dashboard', 'fa fa-home');
        yield MenuItem::linkToCrud('Annonces', 'fa-solid fa-bed', Add::class);
        yield MenuItem::linkToCrud('Réservations', 'fas fa-calendar', Booking::class);
        yield MenuItem::linkToCrud('Equipements', 'fas fa-tools', Equipment::class);
        yield MenuItem::linkToCrud('Images', 'fas fa-image', Image::class);
        yield MenuItem::linkToCrud('Avis', 'fa-solid fa-star', Review::class);
        yield MenuItem::linkToCrud('Utilisateur', 'fa-solid fa-user', User::class);
        yield MenuItem::linkToRoute('Retour au site', 'fas fa-home', 'homepage');
    }
}