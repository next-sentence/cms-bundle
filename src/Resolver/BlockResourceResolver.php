<?php

declare(strict_types=1);

namespace Lwc\CmsBundle\Resolver;

use Lwc\CmsBundle\Entity\BlockInterface;
use Lwc\CmsBundle\Repository\BlockRepositoryInterface;
use Psr\Log\LoggerInterface;

final class BlockResourceResolver implements BlockResourceResolverInterface
{
    /** @var BlockRepositoryInterface */
    private $blockRepository;

    /** @var LoggerInterface */
    private $logger;

    public function __construct(
        BlockRepositoryInterface $blockRepository,
        LoggerInterface $logger
    ) {
        $this->blockRepository = $blockRepository;
        $this->logger = $logger;
    }

    public function findOrLog(string $code): ?BlockInterface
    {
        $block = $this->blockRepository->findEnabledByCode($code);

        if (false === $block instanceof BlockInterface) {
            $this->logger->warning(sprintf(
                'Block with "%s" code was not found in the database.',
                $code
            ));

            return null;
        }

        return $block;
    }
}
