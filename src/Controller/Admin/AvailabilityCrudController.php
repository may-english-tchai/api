<?php

namespace App\Controller\Admin;

use App\Entity\Availability;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateTimeField;
use EasyCorp\Bundle\EasyAdminBundle\Field\Field;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\MoneyField;

class AvailabilityCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Availability::class;
    }

    public function configureFields(string $pageName): iterable
    {
        yield IdField::new('id')->hideOnForm();
        yield DateTimeField::new('start');
        yield DateTimeField::new('end');
        yield AssociationField::new('teacher');
        yield AssociationField::new('restaurant');
        yield AssociationField::new('language');
        yield AssociationField::new('status');
        yield MoneyField::new('price')->setCurrency('EUR');
        yield Field::new('comment');
        yield Field::new('isEnabled');
        yield AssociationField::new('participations');
        yield Field::new('createdAt')->hideOnForm();
        yield Field::new('updatedAt')->hideOnForm();
        yield Field::new('deletedAt')->hideOnForm();
    }
}
