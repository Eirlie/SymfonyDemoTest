<?php
/**
 * Date: 01.06.16
 * Time: 18:20
 */

namespace AppBundle\Service;

use AppBundle\Entity\Currency;
use AppBundle\Exception\CurrencyImportResponseException;
use AppBundle\Model\CurrencyList;
use Doctrine\Common\Persistence\ObjectManager;
use GuzzleHttp\ClientInterface;
use GuzzleHttp\RequestOptions;
use JMS\Serializer\SerializerInterface;

/**
 * Class CurrencyManager
 * @package AppBundle\Service
 * @author  Eldar Shikhbadinov <s.eldar@ideas-world.net>
 */
class CurrencyManager
{
    const IMPORT_URI = '/scripts/XML_daily.asp';

    /**
     * @var \GuzzleHttp\ClientInterface
     */
    private $httpClient;
    /**
     * @var \JMS\Serializer\SerializerInterface
     */
    private $serializer;
    /**
     * @var \Doctrine\Common\Persistence\ObjectManager
     */
    private $objectManager;

    /**
     * CurrencyManager constructor.
     *
     * @param \GuzzleHttp\ClientInterface                $httpClient
     * @param \JMS\Serializer\SerializerInterface        $serializer
     * @param \Doctrine\Common\Persistence\ObjectManager $objectManager
     */
    public function __construct(
        ClientInterface $httpClient,
        SerializerInterface $serializer,
        ObjectManager $objectManager
    ) {
        $this->httpClient = $httpClient;
        $this->serializer = $serializer;
        $this->objectManager = $objectManager;
    }

    /**
     * Import currencies information from external service
     * @return bool
     * @throws \AppBundle\Exception\CurrencyImportResponseException
     */
    public function import()
    {
        $currencyRepo = $this->objectManager->getRepository(Currency::class);

        $response = $this->httpClient->request('GET', self::IMPORT_URI, [RequestOptions::HTTP_ERRORS => false]);
        if (200 !== $response->getStatusCode()) {
            throw new CurrencyImportResponseException();
        }

        $response->getBody()->rewind();
        $contents = $response->getBody()->getContents();
        $currenciesList = $this->serializer->deserialize($contents, CurrencyList::class, 'xml');
        foreach ($currenciesList->getCurrencies() as $currency) {
            $currencyRepo->saveCurrency($currency);
        }

        return true;
    }
}