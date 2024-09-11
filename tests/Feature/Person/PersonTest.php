<?php

namespace Tests\Feature\Person;

use App\Models\Address;
use App\Models\Person;
use Carbon\Carbon;
use Database\Seeders\PersonSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Log;
use Tests\TestCase;

class PersonTest extends TestCase
{
    public function testPersonObject(): void
    {
        // self::markTestIncomplete("incomplete unit test");

        self::seed([PersonSeeder::class]);

        $person = Person::find("1");
        self::assertNotNull($person);
        self::assertEquals("Arief Hermawan", $person->full_name);
        Log::info(json_encode($person));

        $person2 = Person::find("2");
        self::assertNotNull($person2);
        self::assertEquals("Hilmi", $person2->first_name);
        self::assertEquals("Muharrom", $person2->last_name);
        Log::info(json_encode($person2));
    }

    public function testPersonToUpper(): void
    {
        self::seed([PersonSeeder::class]);

        $person = Person::find("3");
        self::assertNotNull($person);
        self::assertEquals("ARIEF Hermawan", $person->full_name);
        Log::info(json_encode($person));

        $person2 = Person::find("4");
        self::assertNotNull($person2);
        self::assertEquals("HILMI", $person2->first_name);
        self::assertEquals("Muharrom", $person2->last_name);
        Log::info(json_encode($person2));

        $person = Person::find("5");
        self::assertNotNull($person);
        self::assertEquals("ARIEF HERMAWAN", $person->full_name);
        Log::info(json_encode($person));

        $person2 = Person::find("6");
        self::assertNotNull($person2);
        self::assertEquals("HILMI", $person2->first_name);
        self::assertEquals("MUHARROM", $person2->last_name);
        Log::info(json_encode($person2));
    }

    public function testAttributeCasting(): void
    {
        self::seed([PersonSeeder::class]);

        $person = Person::find("1");

        self::assertNotNull($person->created_at);
        self::assertNotNull($person->updated_at);
        self::assertInstanceOf(Carbon::class, $person->created_at);
        self::assertInstanceOf(Carbon::class, $person->updated_at);
    }

    public function testCustomCasting(): void
    {
        self::seed([PersonSeeder::class]);

        $person = Person::query()->find("1");
        $person = Person::find("1");

        self::assertNotNull($person);
        Log::info(json_encode($person));

        self::assertNotNull($person->created_at);
        self::assertNotNull($person->updated_at);
        self::assertInstanceOf(Carbon::class, $person->created_at);
        self::assertInstanceOf(Carbon::class, $person->updated_at);

        self::assertNotNull($person->address);
        self::assertInstanceOf(Address::class, $person->address);
        Log::info(json_encode($person->address));
        Log::info($person->address);

        self::assertEquals("Jalan belum jadi", $person->address->getStreet());
        Log::info(json_encode($person->address->getStreet()));

        self::assertEquals("Kabupaten Bandung", $person->address->getCity());
        Log::info(json_encode($person->address->getCity()));

        self::assertEquals("Indonesia", $person->address->getCountry());
        Log::info(json_encode($person->address->getCountry()));

        self::assertEquals("40394", $person->address->getPostalCode());
        Log::info(json_encode($person->address->getPostalCode()));
    }
}
