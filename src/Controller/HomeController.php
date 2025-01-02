<?php

namespace App\Controller;

use App\Repository\ArticleRepository;
use App\Repository\ClientRepository;
use App\Repository\SAVRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use DateTime;
use IntlDateFormatter;

#[Route('/')]
class HomeController extends AbstractController
{
    #[Route('/', name: 'app_home')]
    public function index(ClientRepository $clientRepository, SAVRepository $savRepository, ArticleRepository $articleRepository): Response
    {
        $date = new DateTime();
        $formatter = new IntlDateFormatter(
            'fr_FR',
            IntlDateFormatter::FULL,
            IntlDateFormatter::NONE,
        );

        $totalClients = count($clientRepository->findAll());
        $lastsCreatedClients = $clientRepository->lastsCreatedClients();
        $lastsEditedClients = $clientRepository->lastsEditedClients();

        $totalSAVs = count($savRepository->findAll());
        $totalArticles = count($articleRepository->findAll());

        return $this->render('home/index.html.twig', [
            'currentDate' => ucfirst($formatter->format($date)),
            'totalClients' => $totalClients,
            'lastsCreatedClients' => $lastsCreatedClients,
            'lastsEditedClients' => $lastsEditedClients,
            'totalSAVs' => $totalSAVs,
            'totalArticles' => $totalArticles,
        ]);
    }
}
