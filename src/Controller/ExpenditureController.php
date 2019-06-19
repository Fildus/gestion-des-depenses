<?php

namespace App\Controller;

use App\Entity\Expenditure;
use App\Entity\Uploads;
use App\Form\ExpenditureType;
use App\Form\UploadsType;
use App\Repository\ExpenditureRepository;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/expenditure")
 */
class ExpenditureController extends AbstractController
{
    /**
     * @Route("/", name="expenditure_index", methods={"GET"})
     */
    public function index(ExpenditureRepository $expenditureRepository, PaginatorInterface $paginator, Request $request): Response
    {
        return $this->render('expenditure/index.html.twig', [
            'expenditures' => $paginator->paginate($expenditureRepository->findAll(), $request->get('page') ?? 1)
        ]);
    }

    /**
     * @Route("/new", name="expenditure_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $expenditure = new Expenditure();
        $form = $this->createForm(ExpenditureType::class, $expenditure);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($expenditure);
            $entityManager->flush();

            return $this->redirectToRoute('expenditure_edit', [
                'id' => $expenditure->getId()
            ]);
        }

        return $this->render('expenditure/new.html.twig', [
            'expenditure' => $expenditure,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="expenditure_show", methods={"GET"})
     */
    public function show(Expenditure $expenditure): Response
    {
        return $this->render('expenditure/show.html.twig', [
            'expenditure' => $expenditure,
        ]);
    }

    /**
     * @todo redirect
     * @Route("/{id}/edit", name="expenditure_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Expenditure $expenditure): Response
    {
        $form = $this->createForm(ExpenditureType::class, $expenditure);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();
            return $this->redirectToRoute('expenditure_edit', [
                'id' => $expenditure->getId(),
            ]);
        }

        $upload = new Uploads();
        $formUpload = $this->createForm(UploadsType::class, $upload);
        $formUpload->handleRequest($request);
        if ($formUpload->isSubmitted() && $formUpload->isValid()) {
            $upload->setExpenditure($expenditure);
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($upload);
            $entityManager->flush();

            return $this->redirectToRoute('expenditure_edit', [
                'id' => $expenditure->getId()
            ]);
        }

        return $this->render('expenditure/edit.html.twig', [
            'expenditure' => $expenditure,
            'form' => $form->createView(),
            'upload' => $upload,
            'formUpload' => $formUpload->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="expenditure_delete", methods={"DELETE"})
     */
    public function delete(Request $request, Expenditure $expenditure): Response
    {
        if ($this->isCsrfTokenValid('delete' . $expenditure->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($expenditure);
            $entityManager->flush();
        }

        return $this->redirectToRoute('expenditure_index');
    }

    /**
     * @Route("/{id}", name="expenditure_copy", methods={"POST"})
     */
    public function copy(Request $request, Expenditure $expenditure, ExpenditureRepository $expenditureRepository): Response
    {
        if ($this->isCsrfTokenValid('copy' . $expenditure->getId(), $request->request->get('_token'))) {
            $expenditure = $expenditureRepository->find(key($request->request->get('date')));

            $newExpenditure = $expenditure;

            $newExpenditure->setDate(new \DateTime(array_values($request->request->get('date'))[0]));

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($newExpenditure);
            $entityManager->flush();

            $this->addFlash('notice', 'la copy a bien été effectuée');
        }

        return $this->redirectToRoute('expenditure_index');
    }
}
