<?php

namespace BackupMe\MainBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

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
        ;
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
