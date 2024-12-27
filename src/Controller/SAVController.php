<?php

namespace App\Controller;

use App\Entity\SAV;
use App\Form\SAVType;
use App\Repository\SAVRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/s/a/v')]
final class SAVController extends AbstractController
{
    #[Route(name: 'app_s_a_v_index', methods: ['GET'])]
    public function index(SAVRepository $sAVRepository): Response
    {
        return $this->render('sav/index.html.twig', [
            's_a_vs' => $sAVRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_s_a_v_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $sAV = new SAV();
        $form = $this->createForm(SAVType::class, $sAV);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($sAV);
            $entityManager->flush();

            return $this->redirectToRoute('app_s_a_v_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('sav/new.html.twig', [
            's_a_v' => $sAV,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_s_a_v_show', methods: ['GET'])]
    public function show(SAV $sAV): Response
    {
        return $this->render('sav/show.html.twig', [
            's_a_v' => $sAV,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_s_a_v_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, SAV $sAV, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(SAVType::class, $sAV);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_s_a_v_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('sav/edit.html.twig', [
            's_a_v' => $sAV,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_s_a_v_delete', methods: ['POST'])]
    public function delete(Request $request, SAV $sAV, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$sAV->getId(), $request->getPayload()->getString('_token'))) {
            $entityManager->remove($sAV);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_s_a_v_index', [], Response::HTTP_SEE_OTHER);
    }
}
