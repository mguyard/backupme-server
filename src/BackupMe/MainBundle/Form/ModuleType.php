<?php

namespace BackupMe\MainBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;

use Doctrine\ORM\EntityRepository;

class ModuleType extends AbstractType
{
        /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name', null, array('label' => "Nom du module", 'trim' => true, 'required' => true))
            ->add('description', null, array('label' => "Description du module", 'trim' => true, 'required' => true))
            ->add('moduletype', 'entity', array(
                'label' => "Type du module",
                'class' => 'BackupMeMainBundle:ModuleType',
                'property' => 'name',
                'query_builder' => function(EntityRepository $er) {
                    return $er->createQueryBuilder('mt')
                        ->where('mt.isActive = true')
                        ->orderBy('mt.name', 'ASC');
                },
                'empty_value' => 'Choisissez un type de module...',
                'required' => true,
                'attr' => array(
                    'class' => "chosen-select",
                ),
            ))
            ->add('isBeta', null, array('label' => "Beta Test", 'trim' => true, 'required' => false))
            ->add('isActive', null, array('label' => "Actif", 'trim' => true, 'required' => false))
            ->addEventListener(FormEvents::PRE_SET_DATA, array($this, 'onPreSetData'))
            ->add('cancel', 'submit', array('label' => "Annuler",'attr' => array('class' => "btn btn-danger",'formnovalidate' => 'formnovalidate')))
        ;
    }

    public function onPreSetData(FormEvent $event)
    {
        $module = $event->getData();
        $form = $event->getForm();
        // vérifie si l'objet Company est "nouveau"
        // Si aucune donnée n'est passée au formulaire, la donnée est "null".
        // Ce doit être considéré comme un nouveau "Product"
        if (!$module || null === $module->getId()) {
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
            'data_class' => 'BackupMe\MainBundle\Entity\Module'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'backupme_mainbundle_module';
    }
}
