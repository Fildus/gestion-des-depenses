<?php

namespace App\Controller;

use App\Entity\SourceAccount;
use App\Form\SourceAccountType;
use App\Repository\SourceAccountRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/account")
 */
class SourceAccountController extends AbstractController
{
    /**
     * @Route("/index", name="source_account_index", methods={"GET"})
     */
    public function index(SourceAccountRepository $sourceAccountRepository): Response
    {
        return $this->render('source_account/index.html.twig', [
            'source_accounts' => $sourceAccountRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="source_account_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $sourceAccount = new SourceAccount();
        $form = $this->createForm(SourceAccountType::class, $sourceAccount);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($sourceAccount);
            $entityManager->flush();

            return $this->redirectToRoute('source_account_index');
        }

        return $this->render('source_account/new.html.twig', [
            'source_account' => $sourceAccount,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="source_account_show", methods={"GET"})
     */
    public function show(SourceAccount $sourceAccount): Response
    {
        return $this->render('source_account/show.html.twig', [
            'source_account' => $sourceAccount,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="source_account_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, SourceAccount $sourceAccount): Response
    {
        $form = $this->createForm(SourceAccountType::class, $sourceAccount);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('source_account_index', [
                'id' => $sourceAccount->getId(),
            ]);
        }

        return $this->render('source_account/edit.html.twig', [
            'source_account' => $sourceAccount,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="source_account_delete", methods={"DELETE"})
     */
    public function delete(Request $request, SourceAccount $sourceAccount): Response
    {
        if ($this->isCsrfTokenValid('delete'.$sourceAccount->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($sourceAccount);
            $entityManager->flush();
        }

        return $this->redirectToRoute('source_account_index');
    }
}
