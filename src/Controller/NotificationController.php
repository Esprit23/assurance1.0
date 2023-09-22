<?php

namespace App\Controller;

use App\Entity\Client; 
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\ORM\EntityManagerInterface;

#[Route('/notification')]
class NotificationController extends AbstractController
{
    private $menu = 'notification';

    #[Route('/', name: 'app_notification')]
    public function index(EntityManagerInterface $entityManager): Response
    {
        $aujourdHui = new \DateTime();
        
        $clients = $entityManager->getRepository(Client::class)->findAll();

        $clientsAssuranceInvalide = [];

        foreach ($clients as $client) {
            $assurances = $client->getAssurances();

            // Si le client n'a pas d'assurance du tout, on l'ajoute dans la liste
            if (count($assurances) === 0) {
                $clientsAssuranceInvalide[] = $client;
                continue;
            }
            
            // Trouver l'assurance la plus récente du client
            $assurancePlusRecente = null;

            foreach ($assurances as $assurance) {
                if (!$assurancePlusRecente || $assurance->getDateEffet() > $assurancePlusRecente->getDateEffet()) {
                    $assurancePlusRecente = $assurance;
                }
            }

            if (!$assurancePlusRecente) {
                $clientsAssuranceInvalide[] = $client;
            } else {
                $dateEffet = $assurancePlusRecente->getDateEffet();
                $mois = $assurancePlusRecente->getMois();
                
                $dateFinAssurance = clone $dateEffet;
                $dateFinAssurance->modify("+$mois months");
                
                if ($dateFinAssurance < $aujourdHui) {
                    $clientsAssuranceInvalide[] = $client;
                }
            }
        }

        return $this->render('notification/index.html.twig', [
            'menu' => $this->menu,
            'clientsInvalide' => $clientsAssuranceInvalide,
        ]);
    }
}
