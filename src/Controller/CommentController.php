<?php

namespace App\Controller;

use App\Entity\Comment;
use App\Entity\QuackEntity;
use App\Form\CommentType;
use App\Repository\CommentRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/comment")
 */
class CommentController extends AbstractController
{
    /**
     * @Route("/", name="comment_index", methods={"GET"})
     */
    public function index(CommentRepository $commentRepository): Response
    {
        return $this->render('comment/index.html.twig', [
            'comments' => $commentRepository->findAll(),
        ]);
    }

    /**
     * @Route("/{quack_id}/new", name="comment_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {

        $comment = new Comment();

        // Ce nouveau commentaire appartient a ce quack
        //$quack_id = $request->attributes->get('quack_id');
        //$comment->setQuackId($quack_id);
        $quack_id = $request->attributes->get('quack_id');

        $repository = $this->getDoctrine()->getRepository(QuackEntity::class);

        $quackEntity = $repository->findOneBy(
            ['id' => $quack_id]
        );

        $comment->setQuack( $quackEntity ) ;

        // Auteur du commentaire
        $comment->setAuthor($this->getUser()->getUsername());

        $form = $this->createForm(CommentType::class, $comment);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            // Force date
            $currentDateTime = new \DateTime();
            $comment->setDatetime($currentDateTime);

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($comment);
            $entityManager->flush();

            return $this->redirectToRoute('quack_entity_show', [ 'id' => $quack_id]);
        }

        return $this->render('comment/new.html.twig', [
            'comment' => $comment,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="comment_show", methods={"GET"})
     */
    public function show(Comment $comment): Response
    {
        return $this->render('comment/show.html.twig', [
            'comment' => $comment,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="comment_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Comment $comment): Response
    {
        $form = $this->createForm(CommentType::class, $comment);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            $quack_id = $comment->getIdPost();
            return $this->redirectToRoute('quack_entity_show', [ 'id' => $quack_id]);
        }

        return $this->render('comment/edit.html.twig', [
            'comment' => $comment,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="comment_delete", methods={"DELETE"})
     */
    public function delete(Request $request, Comment $comment): Response
    {
        if ($this->isCsrfTokenValid('delete'.$comment->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($comment);
            $entityManager->flush();
        }

        return $this->redirectToRoute('comment_index');
    }
}
