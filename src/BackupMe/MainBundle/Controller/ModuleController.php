<?php

namespace BackupMe\MainBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use BackupMe\MainBundle\Entity\Module;
use BackupMe\MainBundle\Form\ModuleType;
use BackupMe\MainBundle\Form\SearchType;

/**
 * @Route("/module")
 */
class ModuleController extends Controller
{
    /**
     * @Route("/")
     * @Template()
     */
    public function indexAction()
    {
        return $this->redirect($this->generateUrl('backupme_main_module_list'), 301);
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
            $modules = $em->getRepository('BackupMeMainBundle:Module')->getSearchModuleResult($form->get('search')->getData());
        } else {
            $modules = $em->getRepository('BackupMeMainBundle:Module')->findBy(array(), array('name'=>'asc'));
        }

        return array(
                'modules' => $modules,
                'searchform'   => $form->createView(),
            );
    }

    /**
     * @Route("/show/{id}", requirements={"id" = "\d+"})
     * @Template()
     */
    public function showAction(Module $module)
    {
        return array(
            'module' => $module,
        );
    }

    /**
     * @Route("/add")
     * @Template()
     */
    public function addAction(Request $request)
    {
        $module = new Module();
        $form = $this->createForm(new ModuleType, $module);

        $form->handleRequest($request);

        if ($form->get('cancel')->isClicked()) {
            return $this->redirect($this->generateUrl('backupme_main_module_list'));
        }

        if($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($module);
            $em->flush();
            $flash = $this->get('braincrafted_bootstrap.flash')->success('Le module '.$module->getName().' a était correctement ajoutée.');
            return $this->redirect($this->generateUrl('backupme_main_module_list'));
        }

        return array(
            'module' => $module,
            'form'   => $form->createView()
        );
    }

    /**
     * @Route("/edit/{id}", requirements={"id" = "\d+"})
     * @Template()
     */
    public function editAction(Request $request, Module $module)
    {
        $form = $this->createForm(new ModuleType, $module);

        $form->handleRequest($request);

        if ($form->get('cancel')->isClicked()) {
            return $this->redirect($this->generateUrl('backupme_main_module_list'));
        }

        if($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($module);
            $em->flush();
            $flash = $this->get('braincrafted_bootstrap.flash')->success('Le module '.$module->getName().' a était correctement modifiée.');
            return $this->redirect($this->generateUrl('backupme_main_module_list'));
        }

        return array(
            'module' => $module,
            'form'   => $form->createView()
        );
    }

    /**
     * @Route("/delete/{id}", requirements={"id" = "\d+"})
     * @Template()
     */
    public function deleteAction(Module $module)
    {
        $em = $this->getDoctrine()->getManager();
        $em->remove($module);
        $em->flush();
        $flash = $this->get('braincrafted_bootstrap.flash')->success('Le module '.$module->getName().' a était correctement supprimée.');
        return $this->redirect($this->generateUrl('backupme_main_module_list'));
    }

}
