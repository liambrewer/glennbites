<?php

namespace Database\Seeders;

use App\Models\Employee;
use App\Models\Order;
use App\Models\Product;
use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Services\OrderService;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function __construct(protected OrderService $orderService)
    {
    }

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        $user = User::factory()->create([
            'name' => 'Test User',
            'email' => 'test@example.com',
        ]);

        Employee::create([
            'name' => 'Test Employee',
            'employee_number' => 'gb0001',
            'pin' => '111111',
        ]);

        Product::factory()->create([
            'name' => 'Chocolate Chip Cookie',
            'description' => 'A delicious chocolate chip cookie.',
            'price' => 0.50,
            'stock_on_hand' => 100,
            'max_per_order' => 5,
            'image_url' => '/assets/images/cookie.jpg',
        ]);

        Product::factory()->create([
            'name' => 'White Monster Energy Drink',
            'description' => 'A refreshing energy drink with a smooth flavor.',
            'price' => 2.50,
            'stock_on_hand' => 50,
            'max_per_order' => 2,
            'image_url' => '/assets/images/monster.png',
        ]);

        $this->orderService->createOrder($user, [
            [
                'product_id' => 1,
                'quantity' => 5,
            ],
            [
                'product_id' => 2,
                'quantity' => 2,
            ]
        ]);
    }
}
