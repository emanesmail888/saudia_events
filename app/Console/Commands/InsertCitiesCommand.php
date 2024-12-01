<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Filesystem\Filesystem;
use App\Models\City;

class InsertCitiesCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'insert:cities-command';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'insert cities from json file to database.';

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
        $file = new Filesystem;
        $jsonData = $file->get(base_path('cities.json'));
        $data = json_decode($jsonData, true);

        foreach ($data as $cityData) {
            $region = City::create([
                'region_id' => $cityData['region_id'],
                'name_ar' => $cityData['name_ar'],
                'name_en' => $cityData['name_en'],
            ]);


        }

        $this->info('Cities inserted successfully.');
    }
}
