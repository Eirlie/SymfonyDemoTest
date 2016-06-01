<?php
/**
 * Date: 01.06.16
 * Time: 18:52
 */

namespace AppBundle\Model;

use AppBundle\Entity\Currency;
use Doctrine\Common\Collections\ArrayCollection;
use JMS\Serializer\Annotation as Serializer;

/**
 * Class CurrencyList
 * @package AppBundle\Model
 * @Serializer\ExclusionPolicy("all")
 * @Serializer\XmlRoot("ValCurs")
 * @author  Eldar Shikhbadinov <s.eldar@ideas-world.net>
 */
class CurrencyList
{
    /**
     * @var ArrayCollection<Currency>
     * @Serializer\Expose()
     * @Serializer\XmlList(entry="Valute")
     * @Serializer\Type("array<AppBundle\Entity\Currency>")
     */
    private $currencies = [];

    /**
     * @return \Doctrine\Common\Collections\ArrayCollection
     */
    public function getCurrencies()
    {
        return $this->currencies;
    }

    /**
     * @param \Doctrine\Common\Collections\ArrayCollection $currencies
     *
     * @return CurrencyList
     */
    public function setCurrencies($currencies)
    {
        $this->currencies = $currencies;

        return $this;
    }
}