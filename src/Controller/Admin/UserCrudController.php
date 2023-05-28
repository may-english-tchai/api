<?php

namespace App\Controller\Admin;

use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\ArrayField;
use EasyCorp\Bundle\EasyAdminBundle\Field\CollectionField;
use EasyCorp\Bundle\EasyAdminBundle\Field\Field;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;

class UserCrudController extends AbstractCrudController
{
    public function __construct(
        public readonly UserPasswordHasherInterface $userPasswordHasher
    ) {
    }

    public static function getEntityFqcn(): string
    {
        return User::class;
    }

    public function configureFields(string $pageName): iterable
    {
        yield IdField::new('id')->hideOnForm();
        yield TextField::new('name');
        yield TextField::new('surname');
        yield TextField::new('email');
        yield TextField::new('password')->onlyOnForms();
        yield ArrayField::new('roles');
        yield CollectionField::new('participations');
        yield Field::new('isEnabled');
        yield Field::new('createdAt')->hideOnForm();
        yield Field::new('updatedAt')->hideOnForm();
    }

    /**
     * @phpstan-param PasswordAuthenticatedUserInterface&User $entityInstance
     */
    // @phpstan-ignore-next-line
    public function persistEntity(EntityManagerInterface $entityManager, $entityInstance): void
    {
        $hash = $this->userPasswordHasher->hashPassword($entityInstance, (string) $entityInstance->getPassword());
        $entityInstance->setPassword($hash);
        parent::persistEntity($entityManager, $entityInstance);
    }
}
