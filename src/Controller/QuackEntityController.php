<?php

namespace App\Controller;

use App\Entity\QuackEntity;
use App\Form\QuackEntityType;
use App\Repository\QuackEntityRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/quack/entity")
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
        $form = $this->createForm(QuackEntityType::class, $quackEntity);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
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

    /**
     * @Route("/{id}", name="quack_entity_show", methods={"GET"})
     */
    public function show(QuackEntity $quackEntity): Response
    {
        return $this->render('quack_entity/show.html.twig', [
            'quack_entity' => $quackEntity,
        ]);
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
}
