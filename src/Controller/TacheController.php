<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Doctrine\Persistence\ManagerRegistry;
use App\Entity\Task;
use App\Form\TaskFormType;
use Doctrine\ORM\EntityManagerInterface;
class TacheController extends AbstractController


{
    private $em;
    public function __construct(EntityManagerInterface $em){
        $this->em = $em;
    }
    #[Route('/add', name: 'app_add')]
    public function index(Request $request)
    {
        
        $tache = new task();

        $form = $this->createForm(TaskFormType::class,$tache)->add('save', SubmitType::class, ['label' => 'Create Task']);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {

            $this->em->persist($tache);
            $this->em->flush();
        }
        return $this->render('tache/index.html.twig', [
        'controller_name' => 'TacheController',
        'form'=>$form->createView()
        ]);
    }


    #[Route('/edit/{id}', name: 'app_edit')]
    public function edit(Request $request)
    {
        
        $tache = new task();
        $form = $this->createForm(TaskFormType::class,$tache)->add('save', SubmitType::class, ['label' => 'Update']);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {

            $em = $this->getDoctrine()->getEntityManager();
            $this->em->flush();
        }
        return $this->render('tache/index.html.twig', [
        'controller_name' => 'TacheController',
        'form'=>$form->createView()
        ]);
    }


    #[Route('/delete/{id}', name: 'app_delete')]
    public function delete(Task $tache)
    {
        $this->em->remove($tache);
        $this->em->flush();
        return $this->redirectToRoute('app_home');

    }
}
