<?php

namespace Tests\Feature\Employee;

use App\Models\Employee;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class EmployeeTest extends TestCase
{
    public function testFactory(): void
    {
        $employee1 = Employee::factory()->juniorProgrammer()->create([
            'id' => '1',
            "name" => "Employee 1",
        ]);
        self::assertNotNull($employee1);

        $employee2 = Employee::factory()->seniorProgrammer()->create([
            'id' => '2',
            "name" => "Employee 2",
        ]);
        self::assertNotNull($employee2);

        $employee3 = Employee::factory()->juniorProgrammer()->make();
        $employee3->id = '3';
        $employee3->name = 'Employee 3';
        $employee3->save();

        self::assertNotNull(Employee::where('id', '3')->first());

        // dd($employee3);
    }
}
