<?php

namespace App\Repository;

use App\Entity\Expenditure;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method Expenditure|null find($id, $lockMode = null, $lockVersion = null)
 * @method Expenditure|null findOneBy(array $criteria, array $orderBy = null)
 * @method Expenditure[]    findAll()
 * @method Expenditure[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ExpenditureRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Expenditure::class);
    }

    public function findByDate(int $date, int $month)
    {
        $qb = $this->createQueryBuilder('e')
            ->where('e.date BETWEEN :dateA AND :dateB');
        if ($month === 0) {
            $qb->setParameter('dateA', (new \DateTime())->setDate($date, 0, 0))
                ->setParameter('dateB', (new \DateTime())->setDate($date + 1, 0, 0));
        } else {
            $qb->setParameter('dateA', (new \DateTime())->setDate($date, $month, 0))
                ->setParameter('dateB', (new \DateTime())->setDate($date, $month + 1, 0));
        }
        return $qb->getQuery();
    }

    public function findByDateForMonths($year)
    {
        $return = [];
        for ($i = 1; $i <= 12; $i++) {
            if (!empty($this->findByDate($year, $i)->getResult())) {
                $return[] = $i;
            }
        }
        return $return;
    }

    public function autocomplete($type, $value)
    {
        $return = [];
        $qb = $this->createQueryBuilder('e')
            ->where('e.' . $type . ' LIKE \'%' . $value . '%\'')
            ->getQuery()
            ->getArrayResult();

        /** @var $item Expenditure */
        foreach ($qb as $item){
            $return[] = $item[$type];
        }

        return array_values(array_unique($return));
    }
}
