<?php

declare(strict_types=1);

namespace Tests\BitBag\SyliusCmsPlugin\Behat\Behaviour;

interface ContainsErrorInterface
{
    public function containsErrorWithMessage(string $message, bool $strict = true): bool;
}
