<?php

namespace Tests\Unit\Http\Controller\Api\Admin;

use App\Data\Requests\IndexRequestDTO;
use App\Http\Controllers\Api\Admin\ProductController;
use App\Models\Admin;
use App\Models\Auth\AuthModel;
use App\Models\Enums\AppGuardType;
use App\Models\Product;
use App\Repositories\Contracts\ProductRepositoryInterface;
use App\Repositories\ProductRepository;
use App\Services\Api\Admin\Contracts\ProductServiceInterface;
use App\Services\Api\Admin\ProductService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Pagination\LengthAwarePaginator;
use Mockery;
use Mockery\MockInterface;
use PHPUnit\Framework\MockObject\Builder\InvocationMocker;
use Tests\TestCase;

class ProductControllerTest extends TestCase
{
    use RefreshDatabase;

    private readonly AuthModel $authModel;

    protected function setUp(): void
    {
        parent::setUp();

        $this->authModel = Admin::factory()->withRole()->create();
        $this->actingAs($this->authModel, AppGuardType::ADMIN->value);
    }

    protected function tearDown(): void
    {
        Mockery::close();
    }

    public function test_get_products_paginate(): void
    {
        $response = $this->getJson(route('admin.products.index'))->assertOk();
        $response->assertJsonStructure();
    }

    public function test_get_products_controller(): void
    {
        // $dataDTO = IndexRequestDTO::make();

        $paginateMock = $this->getMockBuilder(LengthAwarePaginator::class)->disableOriginalConstructor()->getMock();

        $this->mock(ProductRepositoryInterface::class, function (MockInterface $mock) use($paginateMock): void {
            // $mock->shouldReceive('getModel')->once()->withNoArgs()->andReturn(Product::class);
            $mock->shouldReceive('paginate')
                ->once()
                ->withAnyArgs()
                ->andReturn($paginateMock);
        });

        // $this->mock(ProductServiceInterface::class, function (MockInterface $mock) use($paginateMock): void {
        //     $mock->shouldReceive('index')
        //         ->once()
        //         ->withAnyArgs()
        //         ->andReturn($paginateMock);
        // });

        $queries = [
            // 'search' => '4',
        ];

        $response = $this->getJson(route('admin.products.index') . '?' . http_build_query($queries))->assertOk();
        
    }
}
