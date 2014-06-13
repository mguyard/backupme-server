<?php

namespace BackupMe\MainBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use BackupMe\MainBundle\Entity\Company;
use BackupMe\MainBundle\Form\CompanyType;

/**
 * @Route("/company")
 */
class CompanyController extends Controller
{
    /**
     * @Route("/")
     * @Template()
     */
    public function indexAction()
    {
        return $this->redirect($this->generateUrl('backupme_main_company_list'), 301);
    }

    /**
     * @Route("/list")
     * @Template()
     */
    public function listAction()
    {
    }

    /**
     * @Route("/show")
     * @Template()
     */
    public function showAction()
    {
    }

    /**
     * @Route("/add")
     * @Template()
     */
    public function addAction(Request $request)
    {
        $company = new Company();
        $form = $this->createForm(new CompanyType, $company);

        $form->handleRequest($request);

        if($form->isValid()) {
            $em = $this->getDoctrine()->getEntityManager();
            $em->persist($company);
            $em->flush();
        }

        return $this->render('BackupMeMainBundle:Company:add.html.twig', array(
            'company' => $company,
            'form'   => $form->createView()
        ));
    }

    /**
     * @Route("/edit")
     * @Template()
     */
    public function editAction()
    {
    }

    /**
     * @Route("/delete")
     * @Template()
     */
    public function deleteAction()
    {
    }

}
