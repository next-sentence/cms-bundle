<?php

declare(strict_types=1);

namespace Lwc\CmsBundle\Fixture\Factory;

interface FixtureFactoryInterface
{
    public function load(array $data): void;
}
