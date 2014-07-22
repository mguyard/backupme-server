<?php

namespace BackupMe\MainBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;

use Doctrine\ORM\EntityRepository;

class ContractType extends AbstractType
{
        /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('company', 'entity', array(
                'label' => "Nom de la société",
                'class' => 'BackupMeMainBundle:Company',
                'property' => 'longName',
                'query_builder' => function(EntityRepository $er) {
                    return $er->createQueryBuilder('c')
                        ->orderBy('c.longName', 'ASC');
                },
            ))
            ->add('name', null, array('label' => "Nom du contrat", 'trim' => true, 'required' => true))
            ->add('isActive', null, array('label' => "Actif", 'trim' => true, 'required' => false))
            ->addEventListener(FormEvents::PRE_SET_DATA, array($this, 'onPreSetData'))
            ->add('cancel', 'submit', array('label' => "Annuler",'attr' => array('class' => "btn btn-danger",'formnovalidate' => 'formnovalidate')))
        ;
    }

    public function onPreSetData(FormEvent $event)
    {
        $contract = $event->getData();
        $form = $event->getForm();
        // vérifie si l'objet Company est "nouveau"
        // Si aucune donnée n'est passée au formulaire, la donnée est "null".
        // Ce doit être considéré comme un nouveau "Product"
        if (!$contract || null === $contract->getId()) {
            $submit_label = "Enregistrer";
        } else {
            $submit_label = "Modifier";
        }
        $form->add('submit', 'submit', array('label' => $submit_label,'attr' => array('class' => "btn btn-success",'formnovalidate' => 'formnovalidate', 'style' => 'margin:20px')));
    }

    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'BackupMe\MainBundle\Entity\Contract'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'backupme_mainbundle_contract';
    }
}
