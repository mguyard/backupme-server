<?php

namespace BackupMe\MainBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;

use Doctrine\ORM\EntityRepository;

class ApiClientInternalType extends AbstractType
{
        /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('type', 'hidden', array('label' => "Type de client", 'required' => true, 'data' => 'internal'))
            ->add('name', null, array('label' => 'Nom FQDN', 'trim' => true, 'required' => true))
            ->add('iPAddress', null, array('label' => 'Adresse IP', 'trim' => true, 'required' => true, 'max_length' => '15'))
            ->add('isActive', null, array('label' => "Actif", 'trim' => true, 'required' => false))
            ->add('contacts', 'entity', array(
                'label' => "Contacts",
                'class' => 'BackupMeMainBundle:Contact',
                'multiple' => true,
                'query_builder' => function(EntityRepository $er) {
                    return $er->createQueryBuilder('cc')
                        ->where('cc.isActive = true')
                        ->orderBy('cc.name', 'ASC');
                },
                'required' => false,
                'attr' => array(
                    'class' => "chosen-select",
                    'data-placeholder' => 'Choisissez les contacts',
                ),
            ))
            ->addEventListener(FormEvents::PRE_SET_DATA, array($this, 'onPreSetData'))
            ->add('cancel', 'submit', array('label' => "Annuler",'attr' => array('class' => "btn btn-danger",'formnovalidate' => 'formnovalidate')))
        ;
    }

    public function onPreSetData(FormEvent $event)
    {
        $apiclient_internal = $event->getData();
        $form = $event->getForm();
        // vérifie si l'objet apiclient_internal est "nouveau"
        // Si aucune donnée n'est passée au formulaire, la donnée est "null".
        // Ce doit être considéré comme un nouveau "apiclient_internal"
        if (!$apiclient_internal || null === $apiclient_internal->getId()) {
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
            'data_class' => 'BackupMe\MainBundle\Entity\ApiClient'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'backupme_mainbundle_apiclientinternal';
    }
}
