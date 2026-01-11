<?php

namespace Database\Seeders;

use App\Models\ResourceCategory;
use Illuminate\Database\Seeder;

class ResourceCategorySeeder extends Seeder
{
    public function run(): void
    {
        $cats = [
            ['name' => 'Serveurs', 'slug' => 'serveurs'],
            ['name' => 'Machines virtuelles', 'slug' => 'vm'],
            ['name' => 'Stockage', 'slug' => 'stockage'],
            ['name' => 'Équipements réseau', 'slug' => 'reseau'],
        ];

        foreach ($cats as $c) {
            ResourceCategory::updateOrCreate(['slug' => $c['slug']], $c);
        }
    }
}
