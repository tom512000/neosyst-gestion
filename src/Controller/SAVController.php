<?php

namespace App\Controller;

use App\Entity\SAV;
use App\Form\SAVType;
use App\Repository\SAVRepository;
use Doctrine\ORM\EntityManagerInterface;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/sav')]
final class SAVController extends AbstractController
{
    #[Route(name: 'app_sav_index', methods: ['GET'])]
    public function index(SAVRepository $savRepository, PaginatorInterface $paginator, Request $request): Response
    {
        $query = $request->query->get('search-sav');
        $currentPage = $request->query->getInt('page', 1);
        $itemsPerPage = 10;

        $pagination = $paginator->paginate(
            $savRepository->findBySearchQuery($query),
            $currentPage,
            $itemsPerPage
        );

        $totalDisplayed = min($currentPage * $itemsPerPage, count($savRepository->findAll()));

        return $this->render('sav/index.html.twig', [
            'pagination' => $pagination,
            'totalDisplayed' => $totalDisplayed,
            'totalSAV' => count($savRepository->findAll()),
        ]);
    }

    #[Route('/new', name: 'app_sav_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $sav = new SAV();
        $form = $this->createForm(SAVType::class, $sav);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($sav);
            $entityManager->flush();

            return $this->redirectToRoute('app_sav_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('sav/new.html.twig', [
            'sav' => $sav,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_sav_show', methods: ['GET'])]
    public function show(SAV $sav): Response
    {
        return $this->render('sav/show.html.twig', [
            'sav' => $sav,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_sav_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, SAV $sav, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(SAVType::class, $sav);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_sav_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('sav/edit.html.twig', [
            'sav' => $sav,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_sav_delete', methods: ['POST'])]
    public function delete(Request $request, SAV $sav, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$sav->getId(), $request->getPayload()->getString('_token'))) {
            $entityManager->remove($sav);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_sav_index', [], Response::HTTP_SEE_OTHER);
    }
}
