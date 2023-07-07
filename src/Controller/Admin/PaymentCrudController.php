<?php

namespace App\Controller\Admin;

use App\Entity\Payment;
use App\Enum\PaymentStatusEnum;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ChoiceField;
use EasyCorp\Bundle\EasyAdminBundle\Field\CodeEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\Field;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\MoneyField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use Symfony\Component\Form\Extension\Core\Type\EnumType;

class PaymentCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Payment::class;
    }

    public function configureFields(string $pageName): iterable
    {
        yield IdField::new('id')->hideOnForm();
        yield AssociationField::new('participation')
            ->setRequired(true)
            ->setDisabled();
        yield MoneyField::new('amountMoney')
            ->setCurrency('EUR')
            ->setStoredAsCents()
            ->setDisabled()
        ;
        yield Field::new('reference')->setDisabled();
        yield TextField::new('statusLabel')->hideOnForm();
        yield ChoiceField::new('status')
            ->setFormType(EnumType::class)
            ->setFormTypeOption('class', PaymentStatusEnum::class)
            ->setChoices(['Payments' => PaymentStatusEnum::cases()])
            ->onlyOnForms()
        ;
        yield CodeEditorField::new('dataToJson')->onlyOnDetail();
        yield TextEditorField::new('comment')->onlyOnDetail();
        yield Field::new('createdAt')->hideOnForm();
        yield Field::new('updatedAt')->hideOnForm();
        yield Field::new('deletedAt')->hideOnForm();
    }
}
