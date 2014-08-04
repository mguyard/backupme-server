<?php

namespace BackupMe\MainBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use BackupMe\MainBundle\Entity\Contact;
use BackupMe\MainBundle\Form\ContactType;
use BackupMe\MainBundle\Form\SearchType;

/**
 * @Route("/contact")
 */
class ContactController extends Controller
{
    /**
     * @Route("/")
     * @Template()
     */
    public function indexAction()
    {
        return $this->redirect($this->generateUrl('backupme_main_contact_list'), 301);
    }

    /**
     * @Route("/list")
     * @Template()
     */
    public function listAction(Request $request)
    {
        $form = $this->createForm(new SearchType);

        $form->handleRequest($request);

        $em = $this->getDoctrine()->getManager();
        if($form->isValid()) {
            $contacts = $em->getRepository('BackupMeMainBundle:Contact')->getSearchContactResult($form->get('search')->getData());
        } else {
            $contacts = $em->getRepository('BackupMeMainBundle:Contact')->findBy(array(), array('name'=>'asc'));
        }

        return array(
                'contacts' => $contacts,
                'searchform'   => $form->createView(),
            );
    }

    /**
     * @Route("/show/{id}", requirements={"id" = "\d+"})
     * @Template()
     */
    public function showAction(Contact $contact)
    {
        return array(
            'contact' => $contact,
        );
    }

    /**
     * @Route("/add")
     * @Template()
     */
    public function addAction(Request $request)
    {
        $contact = new Contact();
        $form = $this->createForm(new ContactType, $contact);

        $form->handleRequest($request);

        if ($form->get('cancel')->isClicked()) {
            return $this->redirect($this->generateUrl('backupme_main_contact_list'));
        }

        if($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($contact);
            $em->flush();
            $flash = $this->get('braincrafted_bootstrap.flash')->success('Le contact '.$contact->getName().' a était correctement ajoutée.');
            return $this->redirect($this->generateUrl('backupme_main_contact_list'));
        }

        return array(
            'contact' => $contact,
            'form'   => $form->createView()
        );
    }

    /**
     * @Route("/edit/{id}", requirements={"id" = "\d+"})
     * @Template()
     */
    public function editAction(Request $request, Contact $contact)
    {
        $form = $this->createForm(new ContactType, $contact);

        $form->handleRequest($request);

        if ($form->get('cancel')->isClicked()) {
            return $this->redirect($this->generateUrl('backupme_main_contact_list'));
        }

        if($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($contact);
            $em->flush();
            $flash = $this->get('braincrafted_bootstrap.flash')->success('Le contact '.$contact->getName().' a était correctement modifiée.');
            return $this->redirect($this->generateUrl('backupme_main_contact_list'));
        }

        return array(
            'contact' => $contact,
            'form'   => $form->createView()
        );
    }

    /**
     * @Route("/delete/{id}", requirements={"id" = "\d+"})
     * @Template()
     */
    public function deleteAction(Contact $contact)
    {
        $em = $this->getDoctrine()->getManager();
        $em->remove($contact);
        $em->flush();
        $flash = $this->get('braincrafted_bootstrap.flash')->success('Le contact '.$contact->getName().' a était correctement supprimée.');
        return $this->redirect($this->generateUrl('backupme_main_contact_list'));
    }

}
