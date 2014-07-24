<?php

namespace BackupMe\MainBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use BackupMe\MainBundle\Entity\ModuleType;
use BackupMe\MainBundle\Form\ModuleTypeType;
use BackupMe\MainBundle\Form\SearchType;

/**
 * @Route("/module-type")
 */
class ModuleTypeController extends Controller
{
    /**
     * @Route("/")
     * @Template()
     */
    public function indexAction()
    {
        return $this->redirect($this->generateUrl('backupme_main_moduletype_list'), 301);
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
            $moduletypes = $em->getRepository('BackupMeMainBundle:ModuleType')->getSearchCompanyResult($form->get('search')->getData());
        } else {
            $moduletypes = $em->getRepository('BackupMeMainBundle:ModuleType')->findBy(array(), array('name'=>'asc'));
        }

        return array(
                'moduletypes' => $moduletypes,
                'searchform'   => $form->createView(),
            );
    }

    /**
     * @Route("/show/{id}", requirements={"id" = "\d+"})
     * @Template()
     */
    public function showAction(ModuleType $moduletype)
    {
        return array(
            'moduletype' => $moduletype,
        );
    }

    /**
     * @Route("/add")
     * @Template()
     */
    public function addAction(Request $request)
    {
        $moduletype = new ModuleType();
        $form = $this->createForm(new ModuleTypeType, $moduletype);

        $form->handleRequest($request);

        if ($form->get('cancel')->isClicked()) {
            return $this->redirect($this->generateUrl('backupme_main_moduletype_list'));
        }

        if($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($moduletype);
            $em->flush();
            $flash = $this->get('braincrafted_bootstrap.flash')->success('Le type de module '.$moduletype->getName().' a était correctement ajoutée.');
            return $this->redirect($this->generateUrl('backupme_main_moduletype_list'));
        }

        return array(
            'moduletype' => $moduletype,
            'form'   => $form->createView()
        );
    }

    /**
     * @Route("/edit/{id}", requirements={"id" = "\d+"})
     * @Template()
     */
    public function editAction(Request $request, ModuleType $moduletype)
    {
        $form = $this->createForm(new ModuleTypeType, $moduletype);

        $form->handleRequest($request);

        if ($form->get('cancel')->isClicked()) {
            return $this->redirect($this->generateUrl('backupme_main_moduletype_list'));
        }

        if($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($moduletype);
            $em->flush();
            $flash = $this->get('braincrafted_bootstrap.flash')->success('La société '.$moduletype->getName().' a était correctement modifiée.');
            return $this->redirect($this->generateUrl('backupme_main_moduletype_list'));
        }

        return array(
            'moduletype' => $moduletype,
            'form'   => $form->createView()
        );
    }

    /**
     * @Route("/delete/{id}", requirements={"id" = "\d+"})
     * @Template()
     */
    public function deleteAction(ModuleType $moduletype)
    {
        $em = $this->getDoctrine()->getManager();
        $em->remove($moduletype);
        $em->flush();
        $flash = $this->get('braincrafted_bootstrap.flash')->success('La société '.$moduletype->getName().' a était correctement supprimée.');
        return $this->redirect($this->generateUrl('backupme_main_moduletype_list'));
    }

}
