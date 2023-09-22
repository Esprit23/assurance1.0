<?php

namespace App\Controller;

use App\Entity\Assurance;
use App\Form\AssuranceFormType;
use App\Repository\AssuranceRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

#[Route('/assurance')]
class AssuranceController extends AbstractController
{
    private $menu = 'assurance';

    #[Route('/', name: 'app_assurance')]
    public function index(AssuranceRepository $assuranceRepository): Response
    {
        $assurances = $assuranceRepository->findAll();

        return $this->render('assurance/index.html.twig', [
            'controller_name' => 'AssuranceController',
            'assurances' => $assurances,
            'menu' => $this->menu,
        ]);
    }

    #[Route('/add', name: 'app_AddAssurance', methods: ['GET', 'POST'])]
    public function addClient(Request $request, EntityManagerInterface $em): Response
    {
        $assurance = new Assurance();
        $form = $this->createForm(AssuranceFormType::class, $assurance);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $em->persist($assurance);
            $em->flush();

            return $this->redirectToRoute('app_assurance'); // Redirige vers la liste des clients par exemple
        }

        return $this->render('assurance/form.html.twig', [
            'form' => $form->createView(),
            'menu' => $this->menu,
        ]);
    }

    #[Route('/edit/{id}', name: 'app_EditAssurance')]
    public function editAssurance(Request $request, Assurance $assurance, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(AssuranceFormType::class, $assurance);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_assurance'); // Redirige vers la liste des clients par exemple
        }

        return $this->render('assurance/form.html.twig', [
            'form' => $form->createView(),
            'assurance' => $assurance,
            'menu' => $this->menu,
        ]);
    }

    #[Route('/delete/{id}', name: 'app_DeleteAssurance')]
    public function deleteAssurance(Request $request, Assurance $assurance, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$assurance->getId(), $request->request->get('_token'))) {
            $entityManager->remove($assurance);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_assurance');
    }
}
