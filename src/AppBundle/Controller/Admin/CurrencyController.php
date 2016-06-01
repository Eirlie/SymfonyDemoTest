<?php
/**
 * Date: 01.06.16
 * Time: 16:43
 */

namespace AppBundle\Controller\Admin;


use AppBundle\Entity\Currency;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

/**
 * Controller manages currencies available in the service
 * @Route("/admin/currency")
 * @Security("has_role('ROLE_ADMIN')")
 * @author  Eldar Shikhbadinov <s.eldar@ideas-world.net>
 */
class CurrencyController extends Controller
{
    /**
     * Lists all Currency entities.
     * @Route("/", name="admin_currency_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $entityManager = $this->getDoctrine()->getManager();
        $currencies = $entityManager->getRepository(Currency::class)->findAll();

        return $this->render('admin/currency/index.html.twig', array('currencies' => $currencies));
    }
}