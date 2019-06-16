<?php

namespace App\Controller;

use App\Entity\Uploads;
use App\Form\UploadsType;
use App\Repository\UploadsRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/uploads")
 */
class UploadsController extends AbstractController
{
    /**
     * @Route("/", name="uploads_index", methods={"GET"})
     */
    public function index(UploadsRepository $uploadsRepository): Response
    {
        return $this->render('uploads/index.html.twig', [
            'uploads' => $uploadsRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="uploads_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $upload = new Uploads();
        $form = $this->createForm(UploadsType::class, $upload);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($upload);
            $entityManager->flush();

            return $this->redirectToRoute('uploads_index');
        }

        return $this->render('uploads/new.html.twig', [
            'upload' => $upload,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="uploads_show", methods={"GET"})
     */
    public function show(Uploads $upload): Response
    {
        return $this->render('uploads/show.html.twig', [
            'upload' => $upload,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="uploads_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Uploads $upload): Response
    {
        $form = $this->createForm(UploadsType::class, $upload);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('uploads_index', [
                'id' => $upload->getId(),
            ]);
        }

        return $this->render('uploads/edit.html.twig', [
            'upload' => $upload,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="uploads_delete", methods={"DELETE"})
     */
    public function delete(Request $request, Uploads $upload): Response
    {
        if ($this->isCsrfTokenValid('delete' . $upload->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($upload);
            $entityManager->flush();
        }

        return $this->redirectToRoute('expenditure_edit', [
            'id' => $upload->getExpenditure()->getId()
        ]);
    }
}
