<?php

namespace BackupMe\MainBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use BackupMe\MainBundle\Entity\Contract;
use BackupMe\MainBundle\Form\ContractType;
use BackupMe\MainBundle\Form\SearchType;

/**
 * @Route("/contract")
 */
class ContractController extends Controller
{
    /**
     * @Route("/")
     * @Template()
     */
    public function indexAction()
    {
        return $this->redirect($this->generateUrl('backupme_main_contract_list'), 301);
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
            $contracts = $em->getRepository('BackupMeMainBundle:Contract')->getSearchContractResult($form->get('search')->getData());
        } else {
            $contracts = $em->getRepository('BackupMeMainBundle:Contract')->findAll();
        }

        return array(
                'contracts' => $contracts,
                'searchform'   => $form->createView(),
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
        $contract = new Contract();
        $form = $this->createForm(new ContractType, $contract);

        $form->handleRequest($request);

        if ($form->get('cancel')->isClicked()) {
            return $this->redirect($this->generateUrl('backupme_main_contract_list'));
        }

        if($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($contract);
            $em->flush();
            $flash = $this->get('braincrafted_bootstrap.flash')->success('Le contrat '.$contract->getName().' a était correctement ajoutée.');
            return $this->redirect($this->generateUrl('backupme_main_contract_list'));
        }

        return array(
            'contract' => $contract,
            'form'   => $form->createView()
        );
    }

    /**
     * @Route("/edit/{id}", requirements={"id" = "\d+"})
     * @Template()
     */
    public function editAction(Request $request, Contract $contract)
    {
        $form = $this->createForm(new ContractType, $contract);

        $form->handleRequest($request);

        if ($form->get('cancel')->isClicked()) {
            return $this->redirect($this->generateUrl('backupme_main_contract_list'));
        }

        if($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($contract);
            $em->flush();
            $flash = $this->get('braincrafted_bootstrap.flash')->success('Le contrat '.$contract->getName().' a était correctement modifiée.');
            return $this->redirect($this->generateUrl('backupme_main_contract_list'));
        }

        return array(
            'contract' => $contract,
            'form'   => $form->createView()
        );
    }

    /**
     * @Route("/delete/{id}", requirements={"id" = "\d+"})
     * @Template()
     */
    public function deleteAction(Contract $contract)
    {
        $em = $this->getDoctrine()->getManager();
        $em->remove($contract);
        $em->flush();
        $flash = $this->get('braincrafted_bootstrap.flash')->success('Le contrat '.$contract->getName().' a était correctement supprimée.');
        return $this->redirect($this->generateUrl('backupme_main_contract_list'));
    }

}
