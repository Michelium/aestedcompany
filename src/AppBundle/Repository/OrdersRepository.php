<?php

namespace AppBundle\Repository;

use AppBundle\Entity\Orders;
use Doctrine\ORM\EntityRepository;

class OrdersRepository extends EntityRepository {

  /**
   * @return Orders[]
   */
  public function findOrdersTotalByMonthAndYearEverything() {
    return $this->createQueryBuilder('orders')
        ->select('SUM(orders.verkoopprijs) AS Totaal, MONTH(orders.verkoopDatum) AS Maand, YEAR(orders.verkoopDatum) AS Jaar')
        ->groupBy('Maand')
        ->addGroupBy('Jaar')
        ->orderBy('orders.verkoopDatum', 'DESC')
        ->getQuery()
        ->execute();
  }

  /**
   * @return Orders[]
   */
  public function findOrdersTotalByMonthAndYear() {
    return $this->createQueryBuilder('orders')
        ->select('SUM(orders.verkoopprijs) AS Totaal, MONTH(orders.verkoopDatum) AS Maand, YEAR(orders.verkoopDatum) AS Jaar')
        ->where('orders.shishapen = false')
        ->groupBy('Maand')
        ->addGroupBy('Jaar')
        ->orderBy('orders.verkoopDatum', 'DESC')
        ->getQuery()
        ->execute();
  }

  /**
   * @return Orders[]
   */
  public function findShishaOrdersTotalByMonthAndYear() {
    return $this->createQueryBuilder('orders')
        ->select('SUM(orders.verkoopprijs) AS Totaal, MONTH(orders.verkoopDatum) AS Maand, YEAR(orders.verkoopDatum) AS Jaar')
        ->where('orders.shishapen = true')
        ->groupBy('Maand')
        ->addGroupBy('Jaar')
        ->orderBy('orders.verkoopDatum', 'DESC')
        ->getQuery()
        ->execute();
  }

  /**
   * @return Orders[]
   */
  public function findOrdersByMonthAndYear($month, $year) {
    return $this->createQueryBuilder('orders')
//        ->select('orders.id, MONTH(orders.verkoopDatum) AS Maand, YEAR(orders.verkoopDatum) AS Jaar')
        ->where('MONTH(orders.verkoopDatum) = ' . $month . ' AND YEAR(orders.verkoopDatum) = ' . $year . '')
//        ->groupBy('Maand')
//        ->addGroupBy('Jaar')
        ->orderBy('orders.verkoopDatum', 'DESC')
        ->getQuery()
        ->execute();
  }

  /**
   * @return Orders[]
   */
  public function findMonthAndYear() {
    return $this->createQueryBuilder('orders')
        ->select('MONTH(orders.verkoopDatum) AS Maand, YEAR(orders.verkoopDatum) AS Jaar')
//        ->where('MONTH(orders.verkoopDatum) = '.$month.' AND YEAR(orders.verkoopDatum) = '.$year.'')
        ->groupBy('Maand')
        ->addGroupBy('Jaar')
        ->orderBy('orders.verkoopDatum', 'DESC')
        ->getQuery()
        ->execute();
  }

  public function findByDate($year = null, $month = null) {
    if ($month === null) {
      $month = (int)date('m');
    }

    if ($year === null) {
      $year = (int)date('Y');
    }

    $startDate = new \DateTimeImmutable("$year-$month-01T00:00:00");
    $endDate = $startDate->modify('last day of this month')->setTime(23, 59, 59);

    return $this->createQueryBuilder('orders')
        ->where('orders.verkoopDatum BETWEEN :start AND :end')
        ->setParameter('start', $startDate->format('Y-m-d H:i:s'))
        ->setParameter('end', $endDate->format('Y-m-d H:i:s'))
        ->getQuery()
        ->execute();

  }

  /**
   * @return Orders[]
   */
  public function findVerzendkostenTotalByMonthAndYear() {
    return $this->createQueryBuilder('orders')
        ->select('SUM(orders.verzendkosten) AS Totaal, MONTH(orders.verkoopDatum) AS Maand, YEAR(orders.verkoopDatum) AS Jaar')
        ->groupBy('Maand')
        ->addGroupBy('Jaar')
        ->getQuery()
        ->execute();
  }
}