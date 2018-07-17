<?php

declare(strict_types=1);

namespace Enqueue\SimpleBus\Tests\Bridge\Symfony\Bundle\DependencyInjection;

use Enqueue\SimpleBus\Bridge\Symfony\Bundle\DependencyInjection\Configuration;
use Matthias\SymfonyConfigTest\PhpUnit\ConfigurationTestCaseTrait;
use PHPUnit\Framework\TestCase;
use Symfony\Component\Config\Definition\ConfigurationInterface;

class ConfigurationTest extends TestCase
{
    use ConfigurationTestCaseTrait;

    /**
     * @test
     */
    public function it_processes_empty_config()
    {
        $config = [];

        $this->assertProcessedConfigurationEquals([$config], [
            'events' => [
                'enabled' => false,
                'transport_name' => 'default',
                'default_queue' => 'asynchronous_events',
                'queue_map' => [],
            ],
        ]);
    }

    /**
     * @test
     */
    public function it_processes_simplified_events_config()
    {
        $config = [
            'events' => 'domain_events',
        ];

        $this->assertProcessedConfigurationEquals([$config], [
            'events' => [
                'enabled' => true,
                'transport_name' => 'default',
                'default_queue' => 'domain_events',
                'queue_map' => [],
            ],
        ], 'events');
    }

    /**
     * @test
     */
    public function it_configures_events_map()
    {
        $config = [
            'events' => [
                'queue_map' => [
                    'FooClass' => 'foo',
                    'BooClass' => 'boo',
                ],
            ],
        ];

        $this->assertProcessedConfigurationEquals([$config], [
            'events' => [
                'enabled' => true,
                'transport_name' => 'default',
                'default_queue' => 'asynchronous_events',
                'queue_map' => [
                    'FooClass' => 'foo',
                    'BooClass' => 'boo',
                ],
            ],
        ], 'events');
    }

    /**
     * @test
     */
    public function it_configures_events_transport_name()
    {
        $config = [
            'events' => [
                'transport_name' => 'redis',
            ],
        ];

        $this->assertProcessedConfigurationEquals([$config], [
            'events' => [
                'enabled' => true,
                'transport_name' => 'redis',
                'default_queue' => 'asynchronous_events',
                'queue_map' => [],
            ],
        ], 'events');
    }

    protected function getConfiguration(): ConfigurationInterface
    {
        return new Configuration();
    }
}
