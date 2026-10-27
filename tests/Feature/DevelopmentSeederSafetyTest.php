<?php

namespace Tests\Feature;

use Database\Seeders\AdminSeeder;
use Database\Seeders\DatabaseSeeder;
use RuntimeException;
use Tests\TestCase;

class DevelopmentSeederSafetyTest extends TestCase
{
    public function test_development_data_seeder_is_blocked_in_production(): void
    {
        $this->app->detectEnvironment(fn () => 'production');

        try {
            $this->expectException(RuntimeException::class);
            $this->expectExceptionMessage('DatabaseSeeder contains development data');

            (new DatabaseSeeder())->run();
        } finally {
            $this->app->detectEnvironment(fn () => 'testing');
        }
    }

    public function test_default_admin_seeder_is_blocked_in_production(): void
    {
        $this->app->detectEnvironment(fn () => 'production');

        try {
            $this->expectException(RuntimeException::class);
            $this->expectExceptionMessage('AdminSeeder creates default credentials');

            (new AdminSeeder())->run();
        } finally {
            $this->app->detectEnvironment(fn () => 'testing');
        }
    }
}
