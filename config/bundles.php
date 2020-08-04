<?php

declare(strict_types=1);

return [
    Symfony\Bundle\FrameworkBundle\FrameworkBundle::class            => ['all' => true],
    Doctrine\Bundle\DoctrineBundle\DoctrineBundle::class             => ['all' => true],
    Doctrine\Bundle\MigrationsBundle\DoctrineMigrationsBundle::class => ['all' => true],
    Symfony\Bundle\WebServerBundle\WebServerBundle::class            => ['dev' => true],
    DAMA\DoctrineTestBundle\DAMADoctrineTestBundle::class            => ['test' => true],
    Symfony\Bundle\MonologBundle\MonologBundle::class                => ['all' => true],
];
