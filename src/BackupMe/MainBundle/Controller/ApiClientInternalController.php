<?php

namespace BackupMe\MainBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use BackupMe\MainBundle\Entity\ApiClient;
use BackupMe\MainBundle\Form\ApiClientInternalType;
use BackupMe\MainBundle\Form\SearchType;

/**
 * @Route("/backupme-agent")
 */
class ApiClientInternalController extends Controller
{
    /**
     * @Route("/")
     * @Template()
     */
    public function indexAction()
    {
        return $this->redirect($this->generateUrl('backupme_main_apiclientinternal_list'), 301);
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
            $apiclients = $em->getRepository('BackupMeMainBundle:ApiClient')->getSearchApiClientResult($form->get('search')->getData(),'internal');
        } else {
            $apiclients = $em->getRepository('BackupMeMainBundle:ApiClient')->findAllByType('internal');
        }

        return array(
                'apiclients' => $apiclients,
                'searchform'   => $form->createView(),
            );
    }

    /**
     * @Route("/show/{id}", requirements={"id" = "\d+"})
     * @Template()
     */
    public function showAction(ApiClient $apiclient)
    {
        return array(
            'apiclient' => $apiclient,
        );
    }

    /**
     * @Route("/add")
     * @Template()
     */
    public function addAction(Request $request)
    {
        $apiclient = new ApiClient();
        $form = $this->createForm(new ApiClientInternalType, $apiclient);

        $form->handleRequest($request);

        if ($form->get('cancel')->isClicked()) {
            return $this->redirect($this->generateUrl('backupme_main_apiclientinternal_list'));
        }

        if($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($apiclient);
            $em->flush();
            $flash = $this->get('braincrafted_bootstrap.flash')->success('Le BackupMe Agent '.$apiclient->getName().' a était correctement ajoutée.');
            return $this->redirect($this->generateUrl('backupme_main_apiclientinternal_list'));
        }

        return array(
            'apiclient' => $apiclient,
            'form'   => $form->createView()
        );
    }

    /**
     * @Route("/edit/{id}", requirements={"id" = "\d+"})
     * @Template()
     */
    public function editAction(Request $request, ApiClient $apiclient)
    {
        $form = $this->createForm(new ApiClientInternalType, $apiclient);

        $form->handleRequest($request);

        if ($form->get('cancel')->isClicked()) {
            return $this->redirect($this->generateUrl('backupme_main_apiclientinternal_list'));
        }

        if($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($apiclient);
            $em->flush();
            $flash = $this->get('braincrafted_bootstrap.flash')->success('Le BackupMe Agent '.$apiclient->getName().' a était correctement modifiée.');
            return $this->redirect($this->generateUrl('backupme_main_apiclientinternal_list'));
        }

        return array(
            'apiclient' => $apiclient,
            'form'   => $form->createView()
        );
    }

    /**
     * @Route("/delete/{id}", requirements={"id" = "\d+"})
     * @Template()
     */
    public function deleteAction(ApiClient $apiclient)
    {
        $em = $this->getDoctrine()->getManager();
        $em->remove($apiclient);
        $em->flush();
        $flash = $this->get('braincrafted_bootstrap.flash')->success('Le BackupMe Agent '.$apiclient->getName().' a était correctement supprimée.');
        return $this->redirect($this->generateUrl('backupme_main_apiclientinternal_list'));
    }

}
