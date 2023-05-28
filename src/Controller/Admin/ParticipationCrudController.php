<?php

namespace App\Controller\Admin;

use App\Entity\Participation;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\Field;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\MoneyField;

class ParticipationCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Participation::class;
    }

    public function configureFields(string $pageName): iterable
    {
        yield IdField::new('id')->hideOnForm();
        yield AssociationField::new('availability');
        yield AssociationField::new('user');
        yield MoneyField::new('amount')->setCurrency('EUR');
        yield AssociationField::new('payments');
        yield Field::new('createdAt')->hideOnForm();
        yield Field::new('updatedAt')->hideOnForm();
        yield Field::new('deletedAt')->hideOnForm();
    }
}
