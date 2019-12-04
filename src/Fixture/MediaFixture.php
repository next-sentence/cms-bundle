<?php

declare(strict_types=1);

namespace Lwc\CmsBundle\Fixture;

use Lwc\CmsBundle\Fixture\Factory\FixtureFactoryInterface;
use Sylius\Bundle\FixturesBundle\Fixture\AbstractFixture;
use Symfony\Component\Config\Definition\Builder\ArrayNodeDefinition;

final class MediaFixture extends AbstractFixture
{
    /** @var FixtureFactoryInterface */
    private $mediaFixtureFactory;

    public function __construct(FixtureFactoryInterface $mediaFixtureFactory)
    {
        $this->mediaFixtureFactory = $mediaFixtureFactory;
    }

    public function load(array $options): void
    {
        $this->mediaFixtureFactory->load($options['custom']);
    }

    public function getName(): string
    {
        return 'media';
    }

    protected function configureOptionsNode(ArrayNodeDefinition $optionsNode): void
    {
        $optionsNode
            ->children()
                ->arrayNode('custom')
                    ->prototype('array')
                        ->children()
                            ->booleanNode('remove_existing')->defaultTrue()->end()
                            ->integerNode('number')->defaultNull()->end()
                            ->scalarNode('type')->isRequired()->cannotBeEmpty()->end()
                            ->scalarNode('path')->isRequired()->cannotBeEmpty()->end()
                            ->booleanNode('enabled')->defaultTrue()->end()
                            ->arrayNode('sections')->scalarPrototype()->end()->end()
                            ->arrayNode('translations')
                                ->prototype('array')
                                    ->children()
                                        ->scalarNode('name')->defaultNull()->end()
                                        ->scalarNode('content')->defaultNull()->end()
                                        ->scalarNode('alt')->defaultNull()->end()
                                        ->scalarNode('link')->defaultNull()->end()
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
