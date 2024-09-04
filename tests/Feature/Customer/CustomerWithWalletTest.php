<?php

namespace Tests\Feature\Customer;

use App\Models\Customer;
use Database\Seeders\CustomerSeeder;
use Database\Seeders\WalletSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Log;
use Tests\TestCase;

class CustomerWithWalletTest extends TestCase
{
    /**
     * A basic feature test example.
     */
    public function testQueryOneToOne(): void
    {
        $this->seed(CustomerSeeder::class);
        $this->seed(WalletSeeder::class);

        $customer = Customer::query()->find("SAMPLE");
        self::assertNotNull($customer);
        Log::info(json_encode($customer));

        $wallet = $customer->wallet;
        self::assertNotNull($wallet);
        Log::info(json_encode($customer));

        self::assertEquals(1000000, $wallet->amount);
    }
}
