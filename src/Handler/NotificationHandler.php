<?php

namespace App\Handler;

use App\Entity\Notification;
use Doctrine\Common\Collections\ArrayCollection;
use Psr\Log\LoggerInterface;

readonly class NotificationHandler
{
    public function __construct(
        private LoggerInterface $logger,
    ) {
    }

    /**
     * @param ArrayCollection<Notification> $notifications
     */
    public function __invoke(
        ArrayCollection $notifications
    ): void {
        foreach ($notifications as $notification) {
            $this->logger->info('Notification sent', [
                'notification' => $notification,
            ]);
            // todo messenger
            // $this->notificationRepository->save($notification);
        }
    }
}
