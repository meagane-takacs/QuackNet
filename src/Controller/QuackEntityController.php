<?php

namespace App\Controller;

use App\Entity\QuackEntity;
use App\Entity\User;
use App\Entity\Comment;
use App\Form\ContactType;
use App\Form\QuackEntityType;
use App\Model\Contact;
use App\Repository\QuackEntityRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\Flash\FlashBagInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Routing\RouterInterface;

/**
 * @Route("/Quack")
 */
class QuackEntityController extends AbstractController
{
    /**
     * @Route("/", name="quack_entity_index", methods={"GET"})
     */
    public function index(QuackEntityRepository $quackEntityRepository): Response
    {
        return $this->render('quack_entity/index.html.twig', [
            'quack_entities' => $quackEntityRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="quack_entity_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $quackEntity = new QuackEntity();

        // Force author
        $quackEntity->setAuthor($this->getUser()->getUsername());

        $form = $this->createForm(QuackEntityType::class, $quackEntity);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            // Force date
            $currentDateTime = new \DateTime();
            $quackEntity->setDatetime($currentDateTime);

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($quackEntity);
            $entityManager->flush();

            return $this->redirectToRoute('quack_entity_index');
        }

        return $this->render('quack_entity/new.html.twig', [
            'quack_entity' => $quackEntity,
            'form' => $form->createView(),
        ]);
    }

    /*public function getComments(QuackEntity $quackEntity)
    {
        $repository = $this->getDoctrine()->getRepository(Comment::class);

        $comments = $repository->findBy(
            ['quack_id' => $quackEntity->getId()],
            ['datetime' => "DESC"]
        );

        return $comments;
    }*/

    /**
     * @Route("/{id}", name="quack_entity_show", methods={"GET"})
     */
    public function show(QuackEntity $quackEntity): Response
    {

        //$comments = $this->getComments($quackEntity);
        $comments = $quackEntity->getComments();

        return $this->render('quack_entity/show.html.twig', [
            'quack_entity' => $quackEntity,
            'comments' => $comments,
        ]);

        /*
         * return $this->render('quack_entity/index.html.twig', [
            'quack_entities' => $quackEntityRepository->findAll(),
        ]);
         */
    }

    /**
     * @Route("/{id}/edit", name="quack_entity_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, QuackEntity $quackEntity): Response
    {
        $form = $this->createForm(QuackEntityType::class, $quackEntity);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('quack_entity_index');
        }

        return $this->render('quack_entity/edit.html.twig', [
            'quack_entity' => $quackEntity,
            'form' => $form->createView(),
        ]);
    }


    /**
     * @Route("/{id}", name="quack_entity_delete", methods={"DELETE"})
     */
    public function delete(Request $request, QuackEntity $quackEntity): Response
    {
        if ($this->isCsrfTokenValid('delete'.$quackEntity->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($quackEntity);
            $entityManager->flush();
        }

        return $this->redirectToRoute('quack_entity_index');
    }

    public function admin(Request $request): Response
    {
        $quacks = $this->getDoctrine()->getRepository(QuackEntity::class)->findBy(
            [],
            ['datetime' => 'DESC']
        );

        $users = $this->getDoctrine()->getRepository((User::class))->findAll();

        return $this->render('admin/index.html.twig', [
            'quacks' => $quacks,
            'users' => $users
        ]);

       //return $this->render('admin/test.html.twig', []);
    }



    public function contact(Request $request, FlashBagInterface $flashBag)
    {
        $contact= new Contact();
        $form = $this->createForm(ContactType::class, $contact);

        $form->handleRequest($request);

        if($form->isSubmitted() and $form->isValid())
        {
         $flashBag->add("success", "Votre message a bien été envoyé");

         return $this->redirectToRoute('app_contact');
        }

        return $this->render('quack_entity/contact.html.twig', ['form'=> $form->createview()]);

    }
}
