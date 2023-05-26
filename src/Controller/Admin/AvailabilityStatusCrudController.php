<?php

namespace App\Controller\Admin;

use App\Entity\AvailabilityStatus;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;

class AvailabilityStatusCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return AvailabilityStatus::class;
    }

    /*
    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id'),
            TextField::new('title'),
            TextEditorField::new('description'),
        ];
    }
    */
}
