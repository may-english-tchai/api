<?php

namespace App\Controller\Admin;

use App\Entity\Availability;
use App\Entity\AvailabilityStatus;
use App\Entity\Language;
use App\Entity\Message;
use App\Entity\Participation;
use App\Entity\Payment;
use App\Entity\Restaurant;
use App\Entity\Teacher;
use App\Entity\User;
use EasyCorp\Bundle\EasyAdminBundle\Config\Action;
use EasyCorp\Bundle\EasyAdminBundle\Config\Actions;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Config\Dashboard;
use EasyCorp\Bundle\EasyAdminBundle\Config\MenuItem;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractDashboardController;
use EasyCorp\Bundle\EasyAdminBundle\Router\AdminUrlGenerator;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

final class DashboardController extends AbstractDashboardController
{
    public function __construct(
        private readonly AdminUrlGenerator $adminUrlGenerator,
    ) {
    }

    #[Route('/admin', name: 'admin')]
    public function index(): Response
    {
        $url = $this->adminUrlGenerator->setController(AvailabilityCrudController::class)->generateUrl();

        return $this->redirect($url);
    }

    public function configureActions(): Actions
    {
        return parent::configureActions()
            ->add(Crud::PAGE_INDEX, Action::DETAIL)
            ->add(Crud::PAGE_EDIT, Action::SAVE_AND_ADD_ANOTHER)
        ;
    }

    public function configureDashboard(): Dashboard
    {
        return Dashboard::new()
            ->setTitle('My English Tchaï API');
    }

    public function configureMenuItems(): iterable
    {
        yield MenuItem::linkToDashboard('Dashboard', 'fa fa-home');
        yield MenuItem::linkToCrud('Users', 'fas fa-list', User::class);
        yield MenuItem::linkToCrud('Availabilities', 'fas fa-list', Availability::class);
        yield MenuItem::linkToCrud('Participations', 'fas fa-list', Participation::class);
        yield MenuItem::linkToCrud('Payments', 'fas fa-list', Payment::class);

        yield MenuItem::section('Configuration');
        yield MenuItem::linkToCrud('Availability statues', 'fas fa-list', AvailabilityStatus::class);
        yield MenuItem::linkToCrud('Languages', 'fas fa-list', Language::class);
        yield MenuItem::linkToCrud('Teachers', 'fas fa-list', Teacher::class);
        yield MenuItem::linkToCrud('Restaurants', 'fas fa-list', Restaurant::class);

        yield MenuItem::section('Messages');
        yield MenuItem::linkToCrud('Message', 'fas fa-list', Message::class);
    }
}
