<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Filesystem\Filesystem;
use App\Models\Region;

class InsertRegionsCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'insert:regions-command';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'insert regions from json';

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
        $jsonData = $file->get(base_path('regions.json'));
        $data = json_decode($jsonData, true);

        foreach ($data as $regionData) {
            $region = Region::create([
                // 'id' => $regionData['id'],
                'code' => $regionData['code'],
                'name_ar' => $regionData['name_ar'],
                'name_en' => $regionData['name_en'],
            ]);


        }

        $this->info('Regions inserted successfully.');
    }
}
