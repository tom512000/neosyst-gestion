<?php

namespace App\Controller\Admin;

use App\Entity\Client;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class ClientCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Client::class;
    }

    public function configureCrud(Crud $crud): Crud
    {
        return $crud
            ->setPageTitle(Crud::PAGE_INDEX, 'Gestion des clients')
            ->setPageTitle(Crud::PAGE_DETAIL, 'Détails du client')
            ->setPageTitle(Crud::PAGE_EDIT, 'Modifier un client')
            ->setPageTitle(Crud::PAGE_NEW, 'Créer un client');
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id', 'ID'),
            TextField::new('code', 'Code'),
            TextField::new('name', 'Name'),
            TextField::new('phoneNumber', 'Numéro de téléphone'),
            TextField::new('mobileNumber', 'Numéro de mobile'),
            TextField::new('faxNumber', 'Numéro de fax'),
            TextField::new('spreadsheetName', 'Fichier Excel'),
            DateField::new('createdDate', 'Date de création'),
            DateField::new('editedDate', 'Date de modification'),
        ];
    }
}
