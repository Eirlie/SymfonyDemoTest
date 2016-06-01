<?php
/**
 * Date: 01.06.16
 * Time: 15:59
 */

namespace AppBundle\Controller;


use AppBundle\Form\UserType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

/**
 * Controller used to manage current user profile
 * @Route("/profile")
 * @Security("has_role('ROLE_USER')")
 * @author  Eldar Shikhbadinov <s.eldar@ideas-world.net>
 */
class ProfileController extends Controller
{
    /**
     * @Route("/", name="profile_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        return $this->render('profile/index.html.twig', array('user' => $this->getUser()));
    }

    /**
     * Displays a form to edit the current user profile.
     *
     * @Route("/edit", name="profile_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request)
    {
        $entityManager = $this->getDoctrine()->getManager();

        $editForm = $this->createForm(UserType::class, $this->getUser());

        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $entityManager->flush();

            $this->addFlash('success', 'profile.updated_successfully');

            return $this->redirectToRoute('profile_index');
        }

        return $this->render('profile/edit.html.twig', array(
            'edit_form'   => $editForm->createView()
        ));
    }
}