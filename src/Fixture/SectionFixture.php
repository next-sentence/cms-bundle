<?php

declare(strict_types=1);

namespace Lwc\CmsBundle\Fixture;

use Lwc\CmsBundle\Fixture\Factory\FixtureFactoryInterface;
use Sylius\Bundle\FixturesBundle\Fixture\AbstractFixture;
use Symfony\Component\Config\Definition\Builder\ArrayNodeDefinition;

final class SectionFixture extends AbstractFixture
{
    /** @var FixtureFactoryInterface */
    private $sectionFixtureFactory;

    public function __construct(FixtureFactoryInterface $sectionFixtureFactory)
    {
        $this->sectionFixtureFactory = $sectionFixtureFactory;
    }

    public function load(array $options): void
    {
        $this->sectionFixtureFactory->load($options['custom']);
    }

    public function getName(): string
    {
        return 'section';
    }

    protected function configureOptionsNode(ArrayNodeDefinition $optionsNode): void
    {
        $optionsNode
            ->children()
                ->arrayNode('custom')
                    ->prototype('array')
                        ->children()
                            ->booleanNode('remove_existing')->defaultTrue()->end()
                            ->arrayNode('translations')
                                ->prototype('array')
                                    ->children()
                                        ->scalarNode('name')->defaultNull()->end()
                                    ->end()
                                ->end()
                            ->end()
                        ->end()
                    ->end()
                ->end()
            ->end()
        ;
    }
}
