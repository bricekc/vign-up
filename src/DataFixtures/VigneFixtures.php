<?php

namespace App\DataFixtures;

use App\Factory\VigneFactory;
use App\Factory\ViticulteurFactory;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;

class VigneFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager): void
    {
        VigneFactory::createSequence([
            ['superficie' => 600, 'latitude' => 49.238211, 'longitude' => 4.054935, 'viticulteur' => ViticulteurFactory::find(6)->object()],
            ['superficie' => 200, 'latitude' => 49.013651, 'longitude' => 3.962083, 'viticulteur' => ViticulteurFactory::find(5)->object()],
            ['superficie' => 1000, 'latitude' => 49.072203, 'longitude' => 3.920620, 'viticulteur' => ViticulteurFactory::find(4)->object()],
            ['superficie' => 600, 'latitude' => 49.081151 , 'longitude' => 4.154674, 'viticulteur' => ViticulteurFactory::find(2)->object()],
            ['superficie' => 200, 'latitude' => 49.048925 , 'longitude' => 4.115991, 'viticulteur' => ViticulteurFactory::find(2)->object()],
            ['superficie' => 300, 'latitude' => 49.086633 , 'longitude' => 3.719765, 'viticulteur' => ViticulteurFactory::find(5)->object()],
            ['superficie' => 100, 'latitude' => 49.189272 , 'longitude' => 3.765278, 'viticulteur' => ViticulteurFactory::find(7)->object()]]);

    }

    public function getDependencies(): array
    {
        return [
            ViticulteurFixtures::class,
            ];
    }
}
