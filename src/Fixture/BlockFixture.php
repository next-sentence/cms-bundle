<?php

declare(strict_types=1);

namespace Lwc\CmsBundle\Fixture;

use Lwc\CmsBundle\Fixture\Factory\FixtureFactoryInterface;
use Sylius\Bundle\FixturesBundle\Fixture\AbstractFixture;
use Symfony\Component\Config\Definition\Builder\ArrayNodeDefinition;

final class BlockFixture extends AbstractFixture
{
    /** @var FixtureFactoryInterface */
    private $blockFixtureFactory;

    public function __construct(FixtureFactoryInterface $blockFixtureFactory)
    {
        $this->blockFixtureFactory = $blockFixtureFactory;
    }

    public function load(array $options): void
    {
        $this->blockFixtureFactory->load($options['custom']);
    }

    public function getName(): string
    {
        return 'block';
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
                            ->booleanNode('enabled')->defaultTrue()->end()
                            ->arrayNode('sections')->scalarPrototype()->end()->end()
                            ->arrayNode('translations')
                                ->prototype('array')
                                    ->children()
                                        ->scalarNode('name')->defaultNull()->end()
                                        ->scalarNode('content')->defaultNull()->end()
                                        ->scalarNode('link')->defaultNull()->end()
                                        ->scalarNode('image_path')->defaultNull()->end()
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
