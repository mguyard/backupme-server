<?php

namespace BackupMe\MainBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class SearchType extends AbstractType
{
        /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('search', 'search', array(
                'label' => false,
                'required' => false,
                'attr' => array(
                    'placeholder' => 'Recherche',
                    'result' => '5',
                    'autosave' => 'some_unique_value',
                    'input_group' => array(
                        'append' => '.icon-search',
                    ),
                    'style' => 'text-align:center',
                )
            ))
        ;
    }

    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array());
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'backupme_mainbundle_search';
    }
}
