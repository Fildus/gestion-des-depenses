<?php

namespace App\Repository;

use App\Entity\SourceAccount;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method SourceAccount|null find($id, $lockMode = null, $lockVersion = null)
 * @method SourceAccount|null findOneBy(array $criteria, array $orderBy = null)
 * @method SourceAccount[]    findAll()
 * @method SourceAccount[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class SourceAccountRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, SourceAccount::class);
    }

    public function findAllByArray()
    {
        $return = [];
        foreach ($this->findAll() as $item) {
            $return[$item->getName()] = $item;
        }
        return $return;
    }
}
