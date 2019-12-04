<?php

declare(strict_types=1);

namespace Lwc\CmsBundle;

use Lwc\CmsBundle\DependencyInjection\Compiler\ImporterCompilerPass;
use Lwc\CmsBundle\DependencyInjection\Compiler\MediaProviderPass;
//use Sylius\Bundle\CoreBundle\Application\SyliusPluginTrait;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\HttpKernel\Bundle\Bundle;

final class LwcCmsBundle extends Bundle
{
//    use SyliusPluginTrait;

    public function build(ContainerBuilder $container): void
    {
        parent::build($container);

        $container->addCompilerPass(new ImporterCompilerPass());
        $container->addCompilerPass(new MediaProviderPass());
    }
}
