<?php

namespace App\EntityListener;

use App\Entity\Notification;
use App\Entity\Payment;
use App\Entity\Testimony;
use App\Handler\NotificationHandler;
use App\Interface\EntityInterface;
use App\Repository\UserRepository;
use Doctrine\Bundle\DoctrineBundle\Attribute\AsDoctrineListener;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Event\OnFlushEventArgs;
use Doctrine\ORM\Events;
use Psr\Log\LoggerInterface;

#[AsDoctrineListener(event: Events::onFlush, priority: 1000)]
final readonly class EntityNotificationListener
{
    public function __construct(
        private NotificationHandler $notificationHandler,
        private UserRepository $userRepository,
        private LoggerInterface $logger
    ) {
    }

    public function __invoke(OnFlushEventArgs $eventArgs): void
    {
        /** @var array<int, object> $entities */
        $entities = $eventArgs->getObjectManager()->getUnitOfWork()->getScheduledEntityInsertions();
        $notifications = new ArrayCollection();

        foreach ($entities as $entity) {
            if (!$entity instanceof EntityInterface) {
                continue;
            }

            $this->handle($entity, $notifications);
        }

        ($this->notificationHandler)($notifications);
    }

    public function handle(EntityInterface $entity, ArrayCollection $notifications): void
    {
        $template = match ($entity::class) {
            Payment::class => $this->handlePayment($entity),
            Testimony::class => $this->handleTestimony($entity),
            default => new ArrayCollection(),
        };

        if (!$template instanceof Notification) {
            return;
        }

        $users = $this->userRepository->findUserByRoles(['ROLE_ADMIN', 'ROLE_SUPER_ADMIN']);
        if ([] === $users) {
            $this->logger->error('No user found for notification');

            return;
        }

        foreach ($users as $user) {
            $notification = clone $template;
            $notification->setToUser($user);
            $notifications->add($notification);
        }
    }

    private function handleTestimony(Testimony $entity): Notification
    {
        return (new Notification())
            ->setEvent('testimony_created')
            ->setSubject('New testimony has been created by '.$entity->getName())
            ->setContent(sprintf('Content of testimony : %s', $entity->getContent()))
        ;
    }

    private function handlePayment(Payment $entity): Notification
    {
        return (new Notification())
            ->setEvent('payment_created')
            ->setSubject('New payment has been created by '.$entity->getParticipation()?->getUser())
            ->setContent(sprintf('Amount of payment : %s', $entity->getAmount()))
        ;
    }
}
