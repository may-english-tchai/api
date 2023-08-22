<?php

namespace App\Controller\User;

use App\Dto\PasswordUserDto;
use App\Entity\User;
use App\Exception\EntityValidationException;
use App\Exception\UnexpectedTypeException;
use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Validator\Validator\ValidatorInterface;

use function count;

class UpdatePasswordController extends AbstractController
{
    public function __construct(
        private readonly UserPasswordHasherInterface $passwordHasher,
        private readonly ValidatorInterface $validator,
        private readonly UserRepository $userRepository,
    ) {
    }

    #[Route('/user/update-password', name: 'user_update_password', methods: ['PUT'])]
    public function updatePassword(Request $request): JsonResponse
    {
        // Récupérer l'utilisateur connecté
        $user = $this->getUser();
        if (!$user instanceof User) {
            throw new UnexpectedTypeException($user, User::class);
        }

        // Récupérer les données du formulaire de mise à jour du mot de passe
        $dto = new PasswordUserDto(
            currentPassword: (string) $request->request->get('currentPassword'),
            newPassword: (string) $request->request->get('newPassword')
        );

        $violations = $this->validator->validate($dto);

        if (count($violations) > 0) {
            throw new EntityValidationException('Erreur de validation');
        }

        // Vérifier que le mot de passe actuel est correct (vérification supplémentaire pour des raisons de sécurité)
        if (!$this->passwordHasher->isPasswordValid($user, $dto->currentPassword)) {
            throw new EntityValidationException('Le mot de passe actuel est incorrect.');
        }

        $this->userRepository->upgradePassword($user, $dto->newPassword);

        // Retourner une réponse JSON pour indiquer le succès de la mise à jour
        return new JsonResponse(['message' => 'Mot de passe mis à jour avec succès.']);
    }
}
