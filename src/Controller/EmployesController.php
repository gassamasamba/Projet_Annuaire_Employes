<?php

namespace App\Controller;

use App\Entity\Client;
use App\Entity\Employes;
use App\Form\EmployesType;
use App\Repository\EmployesRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class EmployesController extends AbstractController
{
    #[Route('/employes', name: 'app_employes')]
    public function index(): Response
    {
        return $this->render('employes/index.html.twig', [
            'controller_name' => 'EmployesController',
        ]);
    }
    /**
     * @Route("liste_employes", name="liste_employes")
     */
    public function listeEmployes(EmployesRepository $employesRepository){
        $employes = $employesRepository->findAll();
        return $this->render("employes_list.html.twig", ['employes'=>$employes]);

    }
     /**
     * @Route("show_employe/{id}", name="show_employe")
     */
    public function show_employe(
        $id,
        EntityManagerInterface $entityManagerInterface,
        Request $request,
        EmployesRepository $employesRepository
    ){
        $employes = $employesRepository->find($id);
        $employeForm = $this->createForm(EmployesType::class, $employes);
        $employeForm->handleRequest($request);
        if($employeForm->isSubmitted() && $employeForm->isValid()){
            $entityManagerInterface->persist($employes);
            $entityManagerInterface->flush();
            return $this->redirectToRoute('liste_employes');
        }
        return $this->render("show_employes.html.twig", ['employeForm'=>$employeForm->createView()]);

    }
     /**
     * @Route("delete_employe/{id}", name="delete_employe")
     */
    public function delete_employe($id, EmployesRepository $employesRepository, EntityManagerInterface $entityManagerInterface){
        $employe= $employesRepository->find($id);
        $entityManagerInterface->remove($employe);
        $entityManagerInterface->flush();
        return $this->redirectToRoute('liste_employes');
        

    }
     /**
     * @Route("create_employe", name="create_employe")
     */
    public function create_employe(
        EntityManagerInterface $entityManagerInterface,
        Request $request
    ){
        $employe = new Employes();
        $employeForm = $this->createForm(EmployesType::class, $employe);
        $employeForm ->handleRequest($request);
        if($employeForm->isSubmitted() && $employeForm->isValid()){
            $entityManagerInterface->persist($employe);
            $entityManagerInterface->flush();
            return $this->redirectToRoute('liste_employes');
        }
        return $this->render('show_employes.html.twig', ['employeForm'=>$employeForm->createView()]);


    }
}
