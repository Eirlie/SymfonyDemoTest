<?php
/**
 * Date: 01.06.16
 * Time: 15:10
 */

namespace AppBundle\Twig;

use AppBundle\Entity\Currency;

/**
 * Class PriceConverterExtension
 * @package AppBundle\Twig
 * @author  Eldar Shikhbadinov <s.eldar@ideas-world.net>
 */
class PriceConverterExtension extends \Twig_Extension
{
    /**
     * @inheritdoc
     */
    public function getFilters()
    {
        return array(
            new \Twig_SimpleFilter('price', array($this, 'convertPrice')),
        );
    }

    /**
     * @param float                      $price
     * @param \AppBundle\Entity\Currency $sourceCurrency
     * @param \AppBundle\Entity\Currency $destinationCurrency
     *
     * @return float
     */
    public function convertPrice($price, Currency $sourceCurrency, Currency $destinationCurrency)
    {
        if ($sourceCurrency !== $destinationCurrency) {
            $price *= $sourceCurrency->getRateToRuble() / $destinationCurrency->getRateToRuble();
            $price = round($price, 4);
        }

        return $price;
    }


    /**
     * @inheritdoc
     */
    public function getName()
    {
        return 'app.extension.price_converter';
    }
}