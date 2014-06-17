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
    public function listAction(Request $request)
    {
        $form = $this->createFormBuilder()
            ->add('search', 'search')
            ->add('submit', 'submit', array('label' => "Rechercher"))
            ->getForm();

        $form->handleRequest($request);

        $em = $this->getDoctrine()->getEntityManager();
        if($form->isValid()) {
            $companies = $this->getDoctrine()->getRepository('BackupMeMainBundle:Company')->getSearchCompanyResult($form->get('search')->getData());
        } else {
            $companies = $em->getRepository('BackupMeMainBundle:Company')->findAll();
        }

        //var_dump($request->request->get('form[search]'));
        var_dump($form->get('search')->getData());
        return array(
                'companies' => $companies,
                'searchform'   => $form->createView(),
                'searchresult' => $request->request->get('form_search')
            );
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

        if($form->isValid()) {
            $em = $this->getDoctrine()->getEntityManager();
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
        $em = $this->getDoctrine()->getEntityManager();
        //$repository = $em->getRepository('BackupMeMainBundle:Company');
        //$company = $repository->findOneById($id);
        $em->remove($company);
        $em->flush();
        $flash = $this->get('braincrafted_bootstrap.flash')->success('La société '.$company->getLongName().' a était correctement supprimée.');
        return $this->redirect($this->generateUrl('backupme_main_company_list'));
    }

}
