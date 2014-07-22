<?php

namespace BackupMe\MainBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use BackupMe\MainBundle\Entity\Company;
use BackupMe\MainBundle\Form\CompanyType;
use BackupMe\MainBundle\Form\SearchType;

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
    public function listAction(Request $request)
    {
        $form = $this->createForm(new SearchType);

        $form->handleRequest($request);

        $em = $this->getDoctrine()->getManager();
        if($form->isValid()) {
            $companies = $em->getRepository('BackupMeMainBundle:Company')->getSearchCompanyResult($form->get('search')->getData());
        } else {
            $companies = $em->getRepository('BackupMeMainBundle:Company')->findBy(array(), array('longName'=>'asc'));
        }

        return array(
                'companies' => $companies,
                'searchform'   => $form->createView(),
            );
    }

    /**
     * @Route("/show/{id}", requirements={"id" = "\d+"})
     * @Template()
     */
    public function showAction(Company $company)
    {
        return array(
            'company' => $company,
        );
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

        if ($form->get('cancel')->isClicked()) {
            return $this->redirect($this->generateUrl('backupme_main_company_list'));
        }

        if($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($company);
            $em->flush();
            $flash = $this->get('braincrafted_bootstrap.flash')->success('La société '.$company->getLongName().' a était correctement ajoutée.');
            return $this->redirect($this->generateUrl('backupme_main_company_list'));
        }

        return array(
            'company' => $company,
            'form'   => $form->createView()
        );
    }

    /**
     * @Route("/edit/{id}", requirements={"id" = "\d+"})
     * @Template()
     */
    public function editAction(Request $request, Company $company)
    {
        $form = $this->createForm(new CompanyType, $company);

        $form->handleRequest($request);

        if ($form->get('cancel')->isClicked()) {
            return $this->redirect($this->generateUrl('backupme_main_company_list'));
        }

        if($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($company);
            $em->flush();
            $flash = $this->get('braincrafted_bootstrap.flash')->success('La société '.$company->getLongName().' a était correctement modifiée.');
            return $this->redirect($this->generateUrl('backupme_main_company_list'));
        }

        return array(
            'company' => $company,
            'form'   => $form->createView()
        );
    }

    /**
     * @Route("/delete/{id}", requirements={"id" = "\d+"})
     * @Template()
     */
    public function deleteAction(Company $company)
    {
        $em = $this->getDoctrine()->getManager();
        $em->remove($company);
        $em->flush();
        $flash = $this->get('braincrafted_bootstrap.flash')->success('La société '.$company->getLongName().' a était correctement supprimée.');
        return $this->redirect($this->generateUrl('backupme_main_company_list'));
    }

}
