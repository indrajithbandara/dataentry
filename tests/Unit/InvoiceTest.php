<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class InvoiceTest extends TestCase
{
    /**
     * A basic test example.
     *
     * @return void
     */
    public function dataReport()
    {
        $response = $this->get('api/invoices/report');
        $response->assertStatus(200);
    }
}
