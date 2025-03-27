<?php

declare(strict_types=1);

namespace Database\Seeders;

use Database\Factories\UserFactory;
use Illuminate\Database\Seeder;

final class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // UserFactory::new()->times(10)->create();

        UserFactory::new()->create([
            'name' => 'Test User',
            'email' => 'test@example.com',
        ]);
    }
}
