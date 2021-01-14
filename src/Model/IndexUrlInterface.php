<?php

declare(strict_types=1);

namespace LWC\SitemapBundle\Model;

use DateTimeInterface;

interface IndexUrlInterface
{
    public function getLocation(): string;

    public function setLocation(string $location): void;

    public function getLastModification(): ?DateTimeInterface;

    public function setLastModification(?DateTimeInterface $lastModification);
}
