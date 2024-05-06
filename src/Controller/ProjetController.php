<?php

namespace App\Controller;

use App\Entity\Projet;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;

use Symfony\Component\Routing\Annotation\Route;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

use App\Repository\ProjetRepository;


class ProjetController extends AbstractController
{
    #[Route('/projet', name: 'projet')]
    public function index(ProjetRepository $repo): Response
    {

        $projects = $repo->findAll();

        return $this->render('projet/index.html.twig', [
             'projects'=>$projects
        ]);
    }

    #[Route('/ens/add-projet', name: 'add_projet')]
    public function add(Request $request, ProjetRepository $repo , EntityManagerInterface $entityManager): Response
    {

        $project = new Projet();

        $form = $this->createFormBuilder($project)
        ->add('nom', TextType::class)
        ->add('duree',TextType::class)
        ->add('pre_requis', TextType::class)
        ->add('contenu', TextType::class)
        ->add('save', SubmitType::class, ['label' => 'Create Project'])
        ->getForm();

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $project = $form->getData();
            $entityManager->persist($project);
            $entityManager->flush();
            return $this->redirectToRoute('projet');
        }


    

        return $this->render('projet/add.html.twig', [
             'form'=>$form->createView(),
        ]);
    }

    #[Route('/ens/delete/{id}', name: 'delete_projet')]
    public function delete(ProjetRepository $repo,$id,Request $request,  EntityManagerInterface $entityManager): Response
    {

        $projet = $repo->find($id);

        if (!$projet) {
            throw $this->createNotFoundException('Projet not found');
        }
    
        $entityManager->remove($projet);
        $entityManager->flush();

        return $this->redirectToRoute('projet');
    }

    #[Route('/ens/edit/{id}', name: 'edit_projet')]
    public function edit(ProjetRepository $repo,$id,Request $request,  EntityManagerInterface $entityManager): Response
    {

        $project = $repo->find($id);

        $form = $this->createFormBuilder($project)
        ->add('nom', TextType::class)
        ->add('duree',TextType::class)
        ->add('pre_requis', TextType::class)
        ->add('contenu', TextType::class)
        ->add('save', SubmitType::class, ['label' => 'Edit Project'])
        ->getForm();

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $project = $form->getData();
            $entityManager->flush();
            return $this->redirectToRoute('projet');
        }

       
        return $this->render('projet/edit.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    #[Route('/etud/join/{id}', name: 'join_project')]
    public function join(ProjetRepository $repo,$id,Request $request,  EntityManagerInterface $entityManager): Response
    {

        $project = $repo->find($id);

      

        if (!$project) {
            throw $this->createNotFoundException('Project not found');
        }
        $project->validateBy = $this->getUser()->getEmail();
        $project->isValid = true;
        $entityManager->flush();

        return $this->redirectToRoute('projet');
    }
}
