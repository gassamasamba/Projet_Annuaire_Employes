<?php

namespace App\Controller;

use App\Entity\Service;
use App\Form\ServiceType;
use App\Repository\ServiceRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class ServiceController extends AbstractController
{
    #[Route('/service', name: 'app_service')]
    public function index(): Response
    {
        return $this->render('service/index.html.twig', [
            'controller_name' => 'ServiceController',
        ]);
    }
    /**
     * @Route("liste_service", name="liste_service")
     */
    public function listeService(ServiceRepository $serviceRepository)
    {
        $services = $serviceRepository->findAll();
        return $this->render("liste_service.html.twig", ['services' => $services]);
    }
    /**
     * @Route("update_service/{id}", name="update_service")
     */
    public function updateService(
        $id,
        EntityManagerInterface $entityManagerInterface,
        Request $request,
        ServiceRepository $serviceRepository
    ) {
        $services = $serviceRepository->find($id);
        $serviceForm = $this->createForm(ServiceType::class, $services);
        $serviceForm->handleRequest($request);
        if ($serviceForm->isSubmitted() && $serviceForm->isValid()) {
            $entityManagerInterface->persist($services);
            $entityManagerInterface->flush();
            return $this->redirectToRoute('liste_service');
        }
        return $this->render("serviceForm.html.twig", ['services' => $serviceForm->createView()]);
    }
    /**
     * @Route("delete_service/{id}", name="delete_service")
     */
    public function deletService(
        $id,
        ServiceRepository $serviceRepository,
        EntityManagerInterface $entityManagerInterface,
    ) {
        $service = $serviceRepository->find($id);
        $entityManagerInterface->remove($service);
        $entityManagerInterface->flush();
        return $this->redirectToRoute('liste_service');
    }
    /**
     * @Route("create_service", name="create_service")
     */
    public function createService(
        EntityManagerInterface $entityManagerInterface,
        Request $request
    ) 
    {
        $services = new Service();
        $serviceForm = $this->createForm(ServiceType::class, $services);
        $serviceForm->handleRequest($request);
        if ($serviceForm->isSubmitted() && $serviceForm->isValid()) {
            $entityManagerInterface->persist($services);
            $entityManagerInterface->flush();
            return $this->redirectToRoute('liste_service');
        }
        return $this->render("serviceForm.html.twig", ['services' => $serviceForm->createView()]);
    }
}

