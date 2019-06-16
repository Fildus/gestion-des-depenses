<?php

namespace App\Controller;

use App\Repository\ExpenditureRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

class AutocompleteController extends AbstractController
{
    /**
     * @Route("/autocomplete/{type}/{value}", name="autocomplete", methods={"POST|GET"})
     */
    public function autocomplete(string $type, string $value, ExpenditureRepository $er)
    {
        return new JsonResponse($er->autocomplete($type, $value));
    }
}
