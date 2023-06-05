<?php

namespace App\Controller\Admin;

use App\Entity\Availability;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ChoiceField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateTimeField;
use EasyCorp\Bundle\EasyAdminBundle\Field\Field;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\MoneyField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;

class AvailabilityCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Availability::class;
    }

    public function configureFields(string $pageName): iterable
    {
        yield IdField::new('id')->hideOnForm();
        yield DateTimeField::new('start')->setColumns(4);
        yield ChoiceField::new('duration')
            ->setChoices([
                '30 minutes' => 30,
                '1 hour' => 60,
                '1,5 hours' => 90,
                '2 hours' => 120,
            ])->setColumns(4);
        yield MoneyField::new('price')->setCurrency('EUR')->setColumns(4);
        yield AssociationField::new('teacher');
        yield AssociationField::new('restaurant');
        yield AssociationField::new('language');
        yield AssociationField::new('status');
        yield TextEditorField::new('comment');
        yield Field::new('isEnabled');
        yield AssociationField::new('participations')->hideOnForm();
        yield Field::new('createdAt')->hideOnForm();
        yield Field::new('updatedAt')->hideOnForm();
        yield Field::new('deletedAt')->hideOnForm();
    }
}
