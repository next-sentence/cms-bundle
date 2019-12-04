<?php

declare(strict_types=1);

namespace Lwc\CmsBundle\Resolver;

use Lwc\CmsBundle\Entity\PageInterface;
use Lwc\CmsBundle\Repository\PageRepositoryInterface;
use Psr\Log\LoggerInterface;
use Sylius\Component\Locale\Context\LocaleContextInterface;

final class PageResourceResolver implements PageResourceResolverInterface
{
    /** @var PageRepositoryInterface */
    private $pageRepository;

    /** @var LocaleContextInterface */
    private $localeContext;

    /** @var LoggerInterface */
    private $logger;

    public function __construct(
        PageRepositoryInterface $pageRepository,
        LocaleContextInterface $localeContext,
        LoggerInterface $logger
    ) {
        $this->pageRepository = $pageRepository;
        $this->localeContext = $localeContext;
        $this->logger = $logger;
    }

    public function findOrLog(string $code): ?PageInterface
    {
        $page = $this->pageRepository->findOneEnabledByCode($code, $this->localeContext->getLocaleCode());

        if (false === $page instanceof PageInterface) {
            $this->logger->warning(sprintf(
                'Page with "%s" code was not found in the database.',
                $code
            ));

            return null;
        }

        return $page;
    }
}
