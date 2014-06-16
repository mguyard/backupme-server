<?php
namespace BackupMe\MainBundle\Menu;

use Knp\Menu\FactoryInterface;
use Symfony\Component\DependencyInjection\ContainerAware;

class Builder extends ContainerAware
{
    public function mainMenu(FactoryInterface $factory, array $options)
    {
        $menu = $factory->createItem('root');

        $menu->addChild('Clients', array('route' => 'backupme_main_company_list'));
        $menu['Clients']->addChild('Liste des sociétés', array('route' => 'backupme_main_company_list'));
        $menu['Clients']->addChild('Ajouter une société', array('route' => 'backupme_main_company_add'));
        //$menu->addChild('Company', array(
            //'route' => 'backupme_main_company_list',
            //'routeParameters' => array('id' => 42)
        //));
        // ... add more children

        return $menu;
    }
}