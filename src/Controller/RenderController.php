<?php

namespace App\Controller;

use App\Repository\ExpenditureRepository;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

/** @Template() */
class RenderController extends AbstractController
{
    /**
     * @Route("/dropdown", name="render")
     */
    public function dropdown(ExpenditureRepository $expenditureRepository, $month, $year, Request $request)
    {
        $dates = [];

        foreach ($expenditureRepository->findBy([], ['date' => 'ASC']) as $expenditure) {
            if (null !== $expenditure->getDate()) {
                $dates[] = (int)$expenditure->getDate()->format('Y');
            }
        }

        return [
            'dates' => array_unique($dates),
            'month' => (int)$month, 'year' => (int)$year,
            'availablesMonths' => $expenditureRepository->findByDateForMonths((int)$request->attributes->get('year'))
        ];
    }
}
