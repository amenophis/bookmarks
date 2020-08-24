<?php

declare(strict_types=1);

return [
    Symfony\Bundle\FrameworkBundle\FrameworkBundle::class                      => ['all' => true],
    Doctrine\Bundle\DoctrineBundle\DoctrineBundle::class                       => ['all' => true],
    Doctrine\Bundle\MigrationsBundle\DoctrineMigrationsBundle::class           => ['all' => true],
    Symfony\Bundle\MonologBundle\MonologBundle::class                          => ['all' => true],
    Symfony\Bundle\WebServerBundle\WebServerBundle::class                      => ['dev' => true],
    Nelmio\ApiDocBundle\NelmioApiDocBundle::class                              => ['dev' => true],
    Nelmio\Alice\Bridge\Symfony\NelmioAliceBundle::class                       => ['dev' => true, 'test' => true],
    Fidry\AliceDataFixtures\Bridge\Symfony\FidryAliceDataFixturesBundle::class => ['dev' => true, 'test' => true],
    Hautelook\AliceBundle\HautelookAliceBundle::class                          => ['dev' => true, 'test' => true],
    Symfony\Bundle\TwigBundle\TwigBundle::class                                => ['dev' => true, 'test' => true],
    Twig\Extra\TwigExtraBundle\TwigExtraBundle::class                          => ['dev' => true, 'test' => true],
];
