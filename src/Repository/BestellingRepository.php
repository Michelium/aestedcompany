<?php

namespace App\Repository;

use App\Entity\Bestelling;
use Doctrine\ORM\EntityRepository;

class BestellingRepository extends EntityRepository {

  /**
   * @return Bestelling[]
   */
  public function findAllTotalBestellingenByMonthEverything() {
    return $this->createQueryBuilder('bestelling')
        ->select('SUM(bestelling.inkoopprijs) AS Totaal, MONTH(bestelling.besteldatum) AS Maand, YEAR(bestelling.besteldatum) AS Jaar')
        ->groupBy('Maand')
        ->addGroupBy('Jaar')
        ->orderBy('bestelling.besteldatum', 'DESC')
        ->getQuery()
        ->execute();
  }

  /**
   * @return Bestelling[]
   */
  public function findAllTotalBestellingenByMonth() {
    return $this->createQueryBuilder('bestelling')
        ->select('SUM(bestelling.inkoopprijs) AS Totaal, MONTH(bestelling.besteldatum) AS Maand, YEAR(bestelling.besteldatum) AS Jaar')
        ->where('bestelling.shishapen = false')
        ->groupBy('Maand')
        ->addGroupBy('Jaar')
        ->orderBy('bestelling.besteldatum', 'DESC')
        ->getQuery()
        ->execute();
  }

  /**
   * @return Bestelling[]
   */
  public function findAllTotalShishaBestellingenByMonth() {
    return $this->createQueryBuilder('bestelling')
        ->select('SUM(bestelling.inkoopprijs) AS Totaal, MONTH(bestelling.besteldatum) AS Maand, YEAR(bestelling.besteldatum) AS Jaar')
        ->where('bestelling.shishapen = true')
        ->groupBy('Maand')
        ->addGroupBy('Jaar')
        ->orderBy('bestelling.besteldatum', 'DESC')
        ->getQuery()
        ->execute();
  }

}