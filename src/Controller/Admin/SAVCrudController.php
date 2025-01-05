<?php

namespace App\Controller\Admin;

use App\Entity\SAV;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class SAVCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return SAV::class;
    }

    public function configureCrud(Crud $crud): Crud
    {
        return $crud
            ->setPageTitle(Crud::PAGE_INDEX, 'Gestion des savs')
            ->setPageTitle(Crud::PAGE_DETAIL, 'Détails du sav')
            ->setPageTitle(Crud::PAGE_EDIT, 'Modifier un sav')
            ->setPageTitle(Crud::PAGE_NEW, 'Créer un sav');
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id', 'ID'),
            TextField::new('code', 'Code'),
            TextField::new('representative', 'Représentant'),
            TextField::new('breakdown', 'Panne'),
            TextField::new('endDate', 'Date prévu'),
            TextField::new('repairedBy', 'Réparateur'),
            TextField::new('repairs', 'Réparations'),
            TextField::new('comments', 'Observations'),
            TextField::new('charge', 'Coût'),
            TextField::new('spreadsheetName', 'Fichier Excel'),
            TextField::new('createdDate', 'Date de création'),
            TextField::new('editedDate', 'Date de modification'),
            AssociationField::new('client', 'Client'),
        ];
    }
}
