<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class InstrumentSeeder extends Seeder
{
    private array $competitors = ['CasaDellaMusica', 'Rock2Day', 'HighRock'];

    private array $instruments = ['Guitar', 'Drums', 'Flute', 'Bass', 'Piano', 'Microphone'];




    /**
     * Run the database seeds.
     */
    public function run()
    {
        for ($i = 0; $i < 20; $i++) {
            DB::table('competitors')->insert([
                'competitor' => $this->competitors[array_rand($this->competitors)],
                'product_title' => $this->instruments[array_rand($this->instruments)],
                'sku' => rand(1, 9) . "AD" . rand(5, 35932),
                'sale_price' => (float)rand(1, 10000)
            ]);
        }
    }
}
