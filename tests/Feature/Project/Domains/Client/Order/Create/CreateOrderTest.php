<?php

declare(strict_types=1);

namespace Tests\Feature\Project\Domains\Client\Order\Create;

use App\Models\Client;
use Tests\TestCase;

/**
 * @group i-create-order
 */
class CreateOrderTest extends TestCase
{

    private Client $client;

    protected function setUp(): void
    {
        parent::setUp();

        $this->client = Client::factory()->create();
    }

    public function testCreate(): void
    {
        $this->assertTrue(!true);
    }
}
