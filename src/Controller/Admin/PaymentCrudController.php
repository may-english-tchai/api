<?php

namespace App\Controller\Admin;

use App\Entity\Payment;
use EasyCorp\Bundle\EasyAdminBundle\Config\Actions;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ChoiceField;
use EasyCorp\Bundle\EasyAdminBundle\Field\CodeEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\Field;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\MoneyField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;

class PaymentCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Payment::class;
    }

    public function configureActions(Actions $actions): Actions
    {
        $actions->disable('new');
        $actions->disable('delete');
        $actions->disable('edit')
        ;

        return parent::configureActions($actions);
    }

    public function configureFields(string $pageName): iterable
    {
        yield IdField::new('id')->hideOnForm();

        yield AssociationField::new('participation');

        yield MoneyField::new('amount')
            ->setCurrency('EUR')
            ->setStoredAsCents(false)
        ;
        yield Field::new('reference');

        yield ChoiceField::new('status')
            ->formatValue(static fn (string $value, Payment $entity) => $entity->getStatus()?->value)
        ;
        yield CodeEditorField::new('dataToJson')->onlyOnDetail();
        yield TextEditorField::new('comment')->onlyOnDetail();
        yield Field::new('createdAt')->hideOnForm();
        yield Field::new('updatedAt')->hideOnForm();
        yield Field::new('deletedAt')->hideOnForm();
    }
}
