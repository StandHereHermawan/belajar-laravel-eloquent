<?php

namespace Tests\Feature\Uuid;

use App\Models\Voucher;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\DB;
use Tests\TestCase;

class UuidTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();
        DB::delete("DELETE FROM vouchers");
    }

    /**
     * A basic feature test example.
     */
    public function testCreateVoucher(): void
    {
        $voucher = new Voucher();
        $voucher->name = "Sample Voucher";
        $voucher->voucher_code = uniqid("voucher");
        $voucher->save();

        self::assertNotNull($voucher->id);

        $voucherQuery = Voucher::find($voucher->id);

        self::assertEquals($voucher->id, $voucherQuery->id);
    }

    public function testUUIDVoucherCode(): void
    {
        $voucher = new Voucher();
        $voucher->name = "Sample Voucher";
        $voucher->save();

        self::assertNotNull($voucher->id);
        self::assertNotNull($voucher->voucher_code);

        $voucherQuery = Voucher::find($voucher->id);

        self::assertEquals($voucher->id, $voucherQuery->id);
        self::assertEquals($voucher->voucher_code, $voucherQuery->voucher_code);
    }
}
