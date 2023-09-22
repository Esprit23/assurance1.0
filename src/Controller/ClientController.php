<?php

namespace App\Controller;

use App\Entity\Client;
use App\Form\ClientFormType;
use App\Repository\ClientRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

#[Route('/client')]
class ClientController extends AbstractController
{
    private $menu = 'client';

    #[Route('/', name: 'app_client')]
    public function index(ClientRepository $clientRepository): Response
    {
        $clients = $clientRepository->findAll();

        return $this->render('client/index.html.twig', [
            'menu' => $this->menu,
            'clients' => $clients,
        ]);
    }

    #[Route('/add', name: 'app_AddClient', methods: ['GET', 'POST'])]
    public function addClient(Request $request, EntityManagerInterface $em): Response
    {
        $client = new Client();
        $form = $this->createForm(ClientFormType::class, $client);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $em->persist($client);
            $em->flush();

            return $this->redirectToRoute('app_client'); // Redirige vers la liste des clients par exemple
        }

        return $this->render('client/form.html.twig', [
            'form' => $form->createView(),
            'menu' => $this->menu,
        ]);
    }

    #[Route('/edit/{id}', name: 'app_EditClient')]
    public function editClient(Request $request, Client $client, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(ClientFormType::class, $client);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_client'); // Redirige vers la liste des clients par exemple
        }

        return $this->render('client/form.html.twig', [
            'form' => $form->createView(),
            'client' => $client,
            'menu' => $this->menu,
        ]);
    }

    #[Route('/delete/{id}', name: 'app_DeleteClient')]
    public function deleteAssurance(Request $request, Client $client, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$client->getId(), $request->request->get('_token'))) {
            $entityManager->remove($client);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_client');
    }
}
