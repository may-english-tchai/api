<?php

namespace App\Controller\Admin;

use App\Entity\Config;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\ChoiceField;
use EasyCorp\Bundle\EasyAdminBundle\Field\Field;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class ConfigCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Config::class;
    }

    public function configureFields(string $pageName): iterable
    {
        yield ChoiceField::new('name')
            ->formatValue(static fn (string $value, Config $entity) => $entity->getName()?->value)
        ;
        yield TextField::new('value');
        yield ChoiceField::new('type')
            ->formatValue(static fn (string $value, Config $entity) => $entity->getType()?->value)
        ;

        yield Field::new('isEnabled');
        yield Field::new('createdAt')->hideOnForm();
        yield Field::new('updatedAt')->hideOnForm();
        yield Field::new('deletedAt')->hideOnForm();
    }
}
