<?php

namespace App\Repository;

use App\Entity\User;
use App\Entity\Booking;
use Doctrine\Persistence\ManagerRegistry;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;

/**
 * @extends ServiceEntityRepository<Booking>
 */
class BookingRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Booking::class);
    }

    // Je récupère les réservations payées dont la date de départ est postérieure à aujourd'hui
    public function findFutureBookings(User $user): array
    {
        return $this->createQueryBuilder('b')
            ->where('b.traveler = :user')
            ->andWhere('b.status = :status')
            ->andWhere('b.checkOut > :now')
            ->setParameter('user', $user)
            ->setParameter('status', 'PAID')
            ->setParameter('now', new \DateTime())
            ->getQuery()
            ->getResult();
    }

    // Je récupère les réservations payées dont la date de fin est antérieure à aujourd'hui
    public function findPastBookings(User $user): array
    {
        return $this->createQueryBuilder('b')
            ->where('b.traveler = :user')
            ->andWhere('b.status = :status')
            ->andWhere('b.checkOut < :now')
            ->setParameter('user', $user)
            ->setParameter('status', 'PAID')
            ->setParameter('now', new \DateTime())
            ->getQuery()
            ->getResult();
    }

}
