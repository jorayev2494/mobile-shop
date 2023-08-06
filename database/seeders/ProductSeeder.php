<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Currency;
use App\Models\File;
use App\Models\Product;
use Illuminate\Database\Seeder;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Collection;
use Project\Domains\Admin\Product\Domain\Product as DomainProduct;
use Project\Shared\Domain\FilesystemInterface;

class ProductSeeder extends Seeder
{
    private readonly Collection $currencies;
    private readonly Collection $categories;

    public function __construct(
        private readonly FilesystemInterface $filesystem,
    )
    {
        $this->currencies = Currency::all();
        $this->categories = Category::all();
    }

    public function run(): void
    {        
        for ($i = 0; $i < 25; $i++) {
            $fakeProduct = Product::factory()->create([
                'category_uuid' => $this->categories->random(1)->first()->uuid,
                'currency_uuid' => $this->currencies->random(1)->first()->uuid,
            ]);

            $this->uploadMedias($fakeProduct);
        }
    }

    private function uploadMedias(Product $product, int $mediaCount = 5): void
    {
        $uploadedMedias = [];

        for ($i = 0; $i < $mediaCount; $i++) { 
            $fp = fake()->image(width: 400, height: 500);
            $fakeUploadedFile = new UploadedFile($fp, 'test.png', 'image/png');
            $uploadedMedias[] = $this->filesystem->uploadFile(DomainProduct::MEDIA_PATH, $fakeUploadedFile);
        }

        $product->medias()->createMany(
            array_map(
                static fn (File $file): array => $file->setHidden([])->attributesToArray(),
                iterator_to_array($uploadedMedias)
            )
        );
    }
}
