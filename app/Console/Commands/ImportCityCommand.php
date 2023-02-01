<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

use App\Helpers\NovaPoshtaHelper;
use App\Models\City;

class ImportCityCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'import:cities';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Import Cities Nova Poshta';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $this->info('Start Import!');
        $this->info('Parse Cities.');
        $cities = NovaPoshtaHelper::getCities()
            ->filter(function ($item) {
                if (stristr($item["DescriptionRu"], "Абрикосовка") === false) {
                    return $item;
                }
            })
            ->filter(function ($item) {
                if (stristr($item["DescriptionRu"], "Агайманы") === false) {
                    return $item;
                }
            })
            ->filter(function ($item) {
                if (stristr($item["DescriptionRu"], "Агрономичное") === false) {
                    return $item;
                }
            })
            ->filter(function ($item) {
                if (stristr($item["DescriptionRu"], "Адамполь") === false) {
                    return $item;
                }
            })
            ->map(function ($item) {
                return [
                    'Description' => $item['Description'],
                    'DescriptionRu' => $item['DescriptionRu'],
                    'CityID' => $item['CityID'],
                    'AreaDescription' => $item['AreaDescription'],
                    'AreaDescriptionRu' => $item['AreaDescriptionRu']
                ];
            })
            ->take(20)
            ->toArray();
        $this->info('Insert to Database!');
        City::insert($cities);
        $this->info('Done!');
        return 0;
    }
}
