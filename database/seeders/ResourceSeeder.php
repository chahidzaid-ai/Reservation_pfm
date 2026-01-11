<?php

namespace Database\Seeders;

use App\Models\Resource;
use App\Models\ResourceCategory;
use App\Models\User;
use Illuminate\Database\Seeder;

class ResourceSeeder extends Seeder
{
    public function run(): void
    {
        $manager = User::where('email', 'manager@datacenter.local')->first();

        $serverCat = ResourceCategory::where('slug', 'serveurs')->first();
        $vmCat = ResourceCategory::where('slug', 'vm')->first();
        $storCat = ResourceCategory::where('slug', 'stockage')->first();
        $netCat = ResourceCategory::where('slug', 'reseau')->first();

        Resource::updateOrCreate(
            ['name' => 'SRV-01'],
            [
                'category_id' => $serverCat->id,
                'manager_id' => $manager?->id,
                'location' => 'Salle A / Rack 3',
                'state' => 'available',
                'specs' => ['CPU'=>'2x Xeon', 'RAM'=>'256 GB', 'OS'=>'Ubuntu', 'Stockage'=>'4 TB NVMe', 'Bande passante'=>'10 Gbps'],
                'notes' => 'Serveur de calcul général.'
            ]
        );

        Resource::updateOrCreate(
            ['name' => 'VM-DEV-01'],
            [
                'category_id' => $vmCat->id,
                'manager_id' => $manager?->id,
                'location' => 'Cluster VM',
                'state' => 'available',
                'specs' => ['CPU'=>'8 vCPU', 'RAM'=>'16 GB', 'OS'=>'Debian', 'Stockage'=>'200 GB', 'Bande passante'=>'1 Gbps'],
                'notes' => 'VM pour développement.'
            ]
        );

        Resource::updateOrCreate(
            ['name' => 'SAN-01'],
            [
                'category_id' => $storCat->id,
                'manager_id' => $manager?->id,
                'location' => 'Salle B / Baie 2',
                'state' => 'maintenance',
                'specs' => ['Capacité'=>'100 TB', 'Type'=>'iSCSI', 'RAID'=>'RAID6', 'Bande passante'=>'20 Gbps'],
                'notes' => 'Baie en maintenance périodique.'
            ]
        );

        Resource::updateOrCreate(
            ['name' => 'SW-CORE-01'],
            [
                'category_id' => $netCat->id,
                'manager_id' => $manager?->id,
                'location' => 'Salle A / Rack 1',
                'state' => 'available',
                'specs' => ['Ports'=>'48', 'Débit'=>'10/40 Gbps', 'OS'=>'NX-OS'],
                'notes' => 'Switch cœur.'
            ]
        );
    }
}
