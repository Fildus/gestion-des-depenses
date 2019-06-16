<?php

namespace App\Controller;

use App\Entity\Expenditure;
use App\Repository\ExpenditureRepository;
use Knp\Component\Pager\PaginatorInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

/** @Template() */
class ShowController extends AbstractController
{
    /**
     * @Route("/show/page-{page}/{year}/{month}", name="show", defaults={"page":1, "month": 0})
     */
    public function index(ExpenditureRepository $expenditureRepository, PaginatorInterface $paginator, int $year, int $month, int $page): array
    {
        $expenditures = $paginator->paginate($expenditureRepository->findByDate($year, $month), $page);

        $amountPage = 0;
        /** @var $item Expenditure */
        foreach ($expenditures as $item){
            $amountPage += $item->getAmount();
        }

        $amountTotal = 0;
        /** @var $item Expenditure */
        foreach ($expenditureRepository->findByDate($year, $month)->getResult() as $item){
            $amountTotal += $item->getAmount();
        }

        return [
            'expenditures' => $expenditures,
            'amountPage' => $amountPage,
            'amountTotal' => $amountTotal,
        ];
    }
}
