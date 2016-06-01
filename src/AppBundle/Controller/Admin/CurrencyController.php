<?php
/**
 * Date: 01.06.16
 * Time: 16:43
 */

namespace AppBundle\Controller\Admin;


use AppBundle\Entity\Currency;
use AppBundle\Exception\CurrencyImportResponseException;
use AppBundle\Form\CurrencyType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

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
        $importForm = $this->createImportForm();

        return $this->render(
            'admin/currency/index.html.twig',
            array(
                'currencies'  => $currencies,
                'import_form' => $importForm->createView()
            )
        );
    }

    /**
     * Creates a form to import currencies from external service.
     * @return \Symfony\Component\Form\Form The form
     */
    private function createImportForm()
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('admin_currency_import'))
            ->setMethod('POST')
            ->getForm();
    }

    /**
     * Creates a new Currency entity.
     * @Route("/new", name="admin_currency_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $currency = new Currency();

        $form = $this->createForm(CurrencyType::class, $currency)
            ->add('saveAndCreateNew', 'Symfony\Component\Form\Extension\Core\Type\SubmitType');
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($currency);
            $entityManager->flush();

            $this->addFlash('success', 'currency.created_successfully');

            if ($form->get('saveAndCreateNew')->isClicked()) {
                return $this->redirectToRoute('admin_currency_new');
            }

            return $this->redirectToRoute('admin_currency_index');
        }

        return $this->render(
            'admin/currency/new.html.twig',
            array(
                'currency' => $currency,
                'form'     => $form->createView(),
            )
        );
    }

    /**
     * Finds and displays a Currency entity.
     * @Route("/{id}", requirements={"id": "\d+"}, name="admin_currency_show")
     * @Method("GET")
     */
    public function showAction(Currency $currency)
    {
        $deleteForm = $this->createDeleteForm($currency);

        return $this->render(
            'admin/currency/show.html.twig',
            array(
                'currency'    => $currency,
                'delete_form' => $deleteForm->createView(),
            )
        );
    }

    /**
     * Creates a form to delete a Currency entity by id.
     *
     * @param Currency $currency The currency object
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Currency $currency)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('admin_currency_delete', array('id' => $currency->getId())))
            ->setMethod('DELETE')
            ->getForm();
    }

    /**
     * Deletes a Currency entity.
     * @Route("/{id}", name="admin_currency_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, Currency $currency)
    {
        $form = $this->createDeleteForm($currency);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();

            $entityManager->remove($currency);
            $entityManager->flush();

            $this->addFlash('success', 'currency.deleted_successfully');
        }

        return $this->redirectToRoute('admin_currency_index');
    }

    /**
     * Displays a form to edit an existing Currency entity.
     * @Route("/{id}/edit", requirements={"id": "\d+"}, name="admin_currency_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Currency $currency, Request $request)
    {
        $entityManager = $this->getDoctrine()->getManager();

        $editForm = $this->createForm(CurrencyType::class, $currency);
        $deleteForm = $this->createDeleteForm($currency);

        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $entityManager->flush();

            $this->addFlash('success', 'currency.updated_successfully');

            return $this->redirectToRoute('admin_currency_edit', array('id' => $currency->getId()));
        }

        return $this->render(
            'admin/currency/edit.html.twig',
            array(
                'currency'    => $currency,
                'edit_form'   => $editForm->createView(),
                'delete_form' => $deleteForm->createView(),
            )
        );
    }

    /**
     * Import currencies from The Central Bank of the Russian Federation API.
     * @Route("/import", name="admin_currency_import")
     * @Method("POST")
     */
    public function importAction()
    {
        $currencyManager = $this->get('app.utils.currency_manager');
        try {
            $currencyManager->import();
        } catch (CurrencyImportResponseException $e) {
            $this->addFlash('error', 'currency.import_failed');
        }
        return $this->redirectToRoute('admin_currency_index');
    }
}