<?php

namespace BackupMe\MainBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use BackupMe\MainBundle\Entity\Location;
use BackupMe\MainBundle\Form\LocationType;
use BackupMe\MainBundle\Form\SearchType;

/**
 * @Route("/location")
 */
class LocationController extends Controller
{
    /**
     * @Route("/")
     * @Template()
     */
    public function indexAction()
    {
        return $this->redirect($this->generateUrl('backupme_main_location_list'), 301);
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
            $locations = $em->getRepository('BackupMeMainBundle:Location')->getSearchLocationResult($form->get('search')->getData());
        } else {
            $locations = $em->getRepository('BackupMeMainBundle:Location')->findBy(array(), array('name'=>'asc'));
        }

        return array(
                'locations' => $locations,
                'searchform'   => $form->createView(),
            );
    }

    /**
     * @Route("/show/{id}", requirements={"id" = "\d+"})
     * @Template()
     */
    public function showAction(Location $location)
    {
        return array(
            'location' => $location,
        );
    }

    /**
     * @Route("/add")
     * @Template()
     */
    public function addAction(Request $request)
    {
        $location = new Location();
        $form = $this->createForm(new LocationType, $location);

        $form->handleRequest($request);

        if ($form->get('cancel')->isClicked()) {
            return $this->redirect($this->generateUrl('backupme_main_location_list'));
        }

        if($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($location);
            $em->flush();
            $flash = $this->get('braincrafted_bootstrap.flash')->success('Le site '.$location->getName().' a était correctement ajoutée.');
            return $this->redirect($this->generateUrl('backupme_main_location_list'));
        }

        return array(
            'location' => $location,
            'form'   => $form->createView()
        );
    }

    /**
     * @Route("/edit/{id}", requirements={"id" = "\d+"})
     * @Template()
     */
    public function editAction(Request $request, Location $location)
    {
        $form = $this->createForm(new LocationType, $location);

        $form->handleRequest($request);

        if ($form->get('cancel')->isClicked()) {
            return $this->redirect($this->generateUrl('backupme_main_location_list'));
        }

        if($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($location);
            $em->flush();
            $flash = $this->get('braincrafted_bootstrap.flash')->success('Le site '.$location->getName().' a était correctement modifiée.');
            return $this->redirect($this->generateUrl('backupme_main_location_list'));
        }

        return array(
            'location' => $location,
            'form'   => $form->createView()
        );
    }

    /**
     * @Route("/delete/{id}", requirements={"id" = "\d+"})
     * @Template()
     */
    public function deleteAction(Location $location)
    {
        $em = $this->getDoctrine()->getManager();
        $em->remove($location);
        $em->flush();
        $flash = $this->get('braincrafted_bootstrap.flash')->success('Le site '.$location->getName().' a était correctement supprimée.');
        return $this->redirect($this->generateUrl('backupme_main_location_list'));
    }

}
