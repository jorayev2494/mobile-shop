<?php

namespace Database\Seeders;

use App\Models\File;
use Faker\Generator;
use Illuminate\Console\OutputStyle;
use Illuminate\Database\Seeder;
use Illuminate\Http\UploadedFile;
use Project\Domains\Admin\Category\Domain\Category\CategoryRepositoryInterface;
use Project\Domains\Admin\Currency\Domain\Currency\CurrencyRepositoryInterface;
use Project\Domains\Admin\Product\Application\Commands\Create\Command;
use Project\Domains\Admin\Product\Domain\Product;
use Project\Shared\Domain\Bus\Command\CommandBusInterface;
use Project\Shared\Domain\FilesystemInterface;
use Project\Shared\Domain\UuidGeneratorInterface;

class ProductSeeder extends Seeder
{
    private readonly array $categories;

    /**
     * @var array<array-key, \Project\Domains\Admin\Currency\Domain\Currency\Currency>
     */
    private readonly array $currencies;

    private readonly OutputStyle $output;

    // private readonly Generator $faker;
    
    public function __construct(
        private readonly CommandBusInterface $commandBus,
        private readonly UuidGeneratorInterface $uuidGenerator,
        private readonly CategoryRepositoryInterface $categoryRepository,
        private readonly CurrencyRepositoryInterface $currencyRepository,
        private readonly FilesystemInterface $filesystem,
        private readonly Generator $fakeGenerator,
    )
    {
        $this->categories = $categoryRepository->get();
        $this->currencies = $currencyRepository->get();
    }

    public function run(): void
    {
        $count = 50;
        $this->output = $this->command->getOutput();
        $this->output->text('Create products: ');
        $this->output->progressStart($count);

        for ($i = 0; $i < $count; $i++) {
            $this->commandBus->dispatch(
                new Command(
                    $this->uuidGenerator->generate(),
                    fake()->text(random_int(20, 100)),
                    fake()->randomElement($this->categories)->getUuid()->value,
                    fake()->randomElement($this->currencies)->getUuid()->value,
                    fake()->randomFloat(2, 50, 500),
                    fake()->boolean ? random_int(0, 75) : 0,
                    $this->generateMedias(random_int(2, 5)),
                    fake()->text(random_int(20, 200)),
                    fake()->boolean,
                )
            );

            $this->output->progressAdvance();
        }

        $this->output->progressFinish();
    }

    private function generateMedias(int $mediaCount = 5): array
    {
        $generatedMedias = [];

        for ($i = 0; $i < $mediaCount; $i++) { 
            // $fp = $this->fakeGenerator->image(width: 400, height: 500, category: 'cats');
            $randomImageNumber = random_int(1, 15);
            $fp = storage_path("app/public/faker/image-{$randomImageNumber}.jpg");
            $generatedMedias[] = new UploadedFile($fp, "{$this->uuidGenerator->generate()}-fake.png", 'image/png');
        }

        return $generatedMedias;
    }
}
