<?php

namespace App\Controller;

use App\Entity\Vehicule;
use App\Form\VehiculeFormType;
use App\Repository\VehiculeRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/vehicule')]
class VehiculeController extends AbstractController
{
    private $menu = 'vehicule';

    #[Route('/', name: 'app_vehicule')]
    public function index(VehiculeRepository $vehiculeRepository): Response
    {
        $vehicules = $vehiculeRepository->findAll();

        return $this->render('vehicule/index.html.twig', [
            'menu' => $this->menu,
            'vehicules' => $vehicules, 
        ]);
    }

    #[Route('/add', name: 'app_AddVehicule', methods: ['GET', 'POST'])]
    public function addVehicule(Request $request, EntityManagerInterface $em): Response
    {
        $vehicule = new Vehicule();
        $form = $this->createForm(VehiculeFormType::class, $vehicule);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $em->persist($vehicule);
            $em->flush();

            return $this->redirectToRoute('app_vehicule'); // Redirige vers la liste des clients par exemple
        }

        return $this->render('vehicule/form.html.twig', [
            'form' => $form->createView(),
            'menu' => $this->menu,
        ]);
    }

    #[Route('/edit/{id}', name: 'app_EditVehicule')]
    public function editClient(Request $request, Vehicule $vehicule, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(VehiculeFormType::class, $vehicule);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_vehicule'); // Redirige vers la liste des clients par exemple
        }

        return $this->render('vehicule/form.html.twig', [
            'form' => $form->createView(),
            'vehicule' => $vehicule,
            'menu' => $this->menu,
        ]);
    }

    #[Route('/delete/{id}', name: 'app_DeleteVehicule')]
    public function deleteVehicule(Request $request, Vehicule $vehicule, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$vehicule->getId(), $request->request->get('_token'))) {
            $entityManager->remove($vehicule);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_vehicule');
    }
}
