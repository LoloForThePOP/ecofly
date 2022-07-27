<?php

namespace App\Controller\Admin;

use App\Entity\Technic;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Field\Field;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateTimeField;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;

class TechnicCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Technic::class;
    }

    
    public function configureCrud(Crud $crud): Crud
    {
        return $crud
            ->setDefaultSort(['id' => 'DESC'])

        ;
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            Field::new('id')->hideOnForm(),
            DateTimeField::new('createdAt'),
            TextField::new('name'),
            Field::new('isAdminValidated'),
            AssociationField::new('creator'),
        ];
    }
    
}
