<?php

namespace App\Controller\Admin;

use App\Entity\Article;
use App\Entity\Client;
use App\Entity\SAV;
use EasyCorp\Bundle\EasyAdminBundle\Config\Dashboard;
use EasyCorp\Bundle\EasyAdminBundle\Config\MenuItem;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractDashboardController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class DashboardController extends AbstractDashboardController
{
    #[Route('/admin', name: 'admin')]
    public function index(): Response
    {
        return $this->render('admin/index.html.twig');
    }

    public function configureDashboard(): Dashboard
    {
        return Dashboard::new()->setTitle('Neosyst Gestion');
    }

    public function configureMenuItems(): iterable
    {
        yield MenuItem::linkToRoute('Retour au site', 'fas fa-home', 'home');
        yield MenuItem::section('Gestion des données');
        yield MenuItem::linkToCrud('Clients', 'fa fa-user', Client::class);
        yield MenuItem::linkToCrud('SAVs', 'fa fa-user', SAV::class);
        yield MenuItem::linkToCrud('Articles', 'fa fa-user', Article::class);
    }
}
