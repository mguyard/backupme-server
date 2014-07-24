<?php
namespace BackupMe\MainBundle\Menu;

use Knp\Menu\FactoryInterface;
use Symfony\Component\DependencyInjection\ContainerAware;

class Builder extends ContainerAware
{
    public function mainMenu(FactoryInterface $factory, array $options)
    {
        $menu = $factory->createItem('root');
        $menu->setCurrentUri($this->container->get('request')->getRequestUri());

        $menu->addChild('Clients', array('uri' => '#'));
            $menu['Clients']->addChild('Liste des sociétés', array('route' => 'backupme_main_company_list'));
            $menu['Clients']->addChild('Ajouter une société', array('route' => 'backupme_main_company_add'));
        $menu->addChild('Contrats', array('uri' => '#'));
            $menu['Contrats']->addChild('Liste des contrats', array('route' => 'backupme_main_contract_list'));
            $menu['Contrats']->addChild('Ajouter un contrat', array('route' => 'backupme_main_contract_add'));
        $menu->addChild('BackupMe Agent', array('uri' => '#'));
            $menu['BackupMe Agent']->addChild('Liste des Agents', array('route' => 'backupme_main_apiclientinternal_list'));
            $menu['BackupMe Agent']->addChild('Ajouter un Agent', array('route' => 'backupme_main_apiclientinternal_add'));
        $menu->addChild('Modules', array('uri' => '#'));
            $menu['Modules']->addChild('Liste des types de module', array('route' => 'backupme_main_moduletype_list'));
            $menu['Modules']->addChild('Ajouter un type de module', array('route' => 'backupme_main_moduletype_add'));
            $menu['Modules']->addChild('Liste des module', array('route' => 'backupme_main_module_list'));
            $menu['Modules']->addChild('Ajouter un module', array('route' => 'backupme_main_module_add'));
        //$menu->addChild('Company', array(
            //'route' => 'backupme_main_company_list',
            //'routeParameters' => array('id' => 42)
        //));
        // ... add more children

        return $menu;
    }
}