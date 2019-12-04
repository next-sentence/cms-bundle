<?php

declare(strict_types=1);

namespace Lwc\CmsBundle\Fixture;

use Lwc\CmsBundle\Fixture\Factory\FixtureFactoryInterface;
use Sylius\Bundle\FixturesBundle\Fixture\AbstractFixture;
use Symfony\Component\Config\Definition\Builder\ArrayNodeDefinition;

final class PageFixture extends AbstractFixture
{
    /** @var FixtureFactoryInterface */
    private $pageFixtureFactory;

    public function __construct(FixtureFactoryInterface $pageFixtureFactory)
    {
        $this->pageFixtureFactory = $pageFixtureFactory;
    }

    public function load(array $options): void
    {
        $this->pageFixtureFactory->load($options['custom']);
    }

    public function getName(): string
    {
        return 'page';
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
                                        ->scalarNode('slug')->defaultNull()->end()
                                        ->scalarNode('name')->defaultNull()->end()
                                        ->scalarNode('image_path')->defaultNull()->end()
                                        ->scalarNode('meta_keywords')->defaultNull()->end()
                                        ->scalarNode('meta_description')->defaultNull()->end()
                                        ->scalarNode('content')->defaultNull()->end()
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
