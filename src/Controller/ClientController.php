<?php

namespace App\Controller;

use App\Entity\Client;
use App\Form\ClientType;
use App\Repository\ClientRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class ClientController extends AbstractController
{
    #[Route('/client', name: 'app_client')]
    public function index(): Response
    {
        return $this->render('client/index.html.twig', [
            'controller_name' => 'ClientController',
        ]);
    }
    /**
     * @Route("liste_client", name="liste_client")
     */
    public function listeClientt(ClientRepository $clientRepository){
       $client = $clientRepository->findAll();
        return $this->render("liste_client.html.twig", ['clients'=>$client]);

    }
    /**
     * @Route("update_client/{id}", name="update_client")
     */
    public function updateClient(
     $id,
     EntityManagerInterface $entityManagerInterface,
     Request $request,
     ClientRepository $clientRepository
    ){
        $client = $clientRepository->find($id);
        $clientForm = $this->createForm(ClientType::class, $client);
        $clientForm->handleRequest($request);
        if($clientForm->isSubmitted() && $clientForm->isValid()){
            $entityManagerInterface->persist($client);
            $entityManagerInterface->flush();
            return $this->redirectToRoute('liste_client');
        }
        return $this->render("clientForm.html.twig", ['clientForm'=>$clientForm->createView()]);
    }
    /**
     * @Route("delete_client/{id}", name="delete_client")
     */
    public function deleteClient(
        $id,
        ClientRepository $clientRepository,
        EntityManagerInterface $entityManagerInterface,
        )
        {
            $client = $clientRepository->find($id);
            $entityManagerInterface->remove($client);
            $entityManagerInterface->flush();
            return $this->redirectToRoute('liste_client');


        }
        /**
     * @Route("create_client", name="create_client")
     */
    public function createClient(
        EntityManagerInterface $entityManagerInterface,
        Request $request
    ){
        $clients = new Client();
        $clientForm = $this->createForm(ClientType::class, $clients);
        $clientForm->handleRequest($request);
        if($clientForm->isSubmitted() && $clientForm->isValid()){
            $entityManagerInterface->persist($clients);
            $entityManagerInterface->flush();
            return $this->redirectToRoute('liste_client');
        }
        return $this->render("clientForm.html.twig",['clientForm'=>$clientForm->createView()]);


        

    }
}
