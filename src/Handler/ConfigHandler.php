<?php

namespace App\Handler;

use App\Entity\Config;
use App\Exception\UnexpectedResultException;
use App\Repository\ConfigRepository;

final readonly class ConfigHandler
{
    public function __construct(
        private ConfigRepository $configRepository,
    ) {
    }

    /**
     * @throws UnexpectedResultException
     */
    public function __invoke(string $name): ?string
    {
        $config = $this->configRepository->findOneBy(['name' => $name]);
        if (!$config instanceof Config) {
            throw new UnexpectedResultException(sprintf('Config with name %s not found', $name));
        }

        return $config->getValue();
    }
}
