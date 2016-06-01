<?php

namespace AppBundle\Repository;

use AppBundle\Entity\Currency;
use AppBundle\Exception\CurrencyNotFoundException;
use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\NoResultException;

/**
 * Class CurrencyRepository
 * @package AppBundle\Repository
 * @author  Eldar Shikhbadinov <s.eldar@ideas-world.net>
 */
class CurrencyRepository extends EntityRepository
{
    /**
     * Get default currency
     * @return \AppBundle\Entity\Currency
     * @throws \AppBundle\Exception\CurrencyNotFoundException
     * @throws \AppBundle\Exception\NoDefaultCurrencyException
     */
    public function getDefaultCurrency()
    {
        if (0 >= $this->getAllCount()) {
            throw new CurrencyNotFoundException('There is no available currencies');
        }

        try {
            $currency = $this->createQueryBuilder('c')
                ->where('c.default=TRUE')
                ->setMaxResults(1)
                ->getQuery()
                ->getSingleResult();
        } catch (NoResultException $e) {
            $currency = $this->createQueryBuilder('c')
                ->setMaxResults(1)
                ->getQuery()
                ->getSingleResult();

            $currency = $this->setAsDefault($currency);
        }

        return $currency;
    }

    /**
     * Get count of all currencies
     * @return int
     */
    public function getAllCount()
    {
        $qb = $this->createQueryBuilder('c');

        return $qb->select($qb->expr()->countDistinct('c.id'))
            ->getQuery()
            ->getSingleScalarResult();
    }

    /**
     * Set currency as default one
     *
     * @param \AppBundle\Entity\Currency $currency
     *
     * @return \AppBundle\Entity\Currency
     */
    public function setAsDefault(Currency $currency)
    {
        $this->getEntityManager()->beginTransaction();
        $this->createQueryBuilder('c')
            ->update()
            ->set('c.default', '0')
            ->getQuery()
            ->execute();

        $this->createQueryBuilder('c')
            ->update()
            ->set('c.default', '1')
            ->where('c=:currency')
            ->setParameter('currency', $currency)
            ->getQuery()
            ->execute();

        $this->getEntityManager()->commit();

        return $currency;
    }
}
