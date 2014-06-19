<?php

namespace BackupMe\MainBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class CompanyType extends AbstractType
{
        /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('longName', null, array('label' => "Nom complet", 'trim' => true, 'required' => true))
            ->add('shortName', null,array('label' => "Trigramme", 'trim' => true, 'max_length' => '6', 'required' => true))
            ->add('isActive', null, array('label' => "Actif", 'trim' => true, 'required' => false))
        ;
    }

    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'BackupMe\MainBundle\Entity\Company'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'backupme_mainbundle_company';
    }
}
