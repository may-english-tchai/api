<?php

namespace App\Handler;

use App\Entity\Config;
use App\Enum\ConfigEnum;
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
    public function __invoke(ConfigEnum $name): string
    {
        $config = $this->configRepository->findOneBy(['name' => $name]);
        if (!$config instanceof Config) {
            throw new UnexpectedResultException(sprintf('Config with name %s not found', $name->value));
        }

        if (null === $config->getValue()) {
            throw new UnexpectedResultException(sprintf('Config with name %s has no value', $name->value));
        }

        return $config->getValue();
    }
}
