<?php

namespace Database\Seeders;

use App\Models\AssetChain;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class AssetChainSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        $types = ['site', 'asset', 'component', 'sample_point'];
        $parent_id = null;
        foreach ($types as $type) {

            $chain = AssetChain::create([
                'account_id' => \App\Models\Account::first()->id,
                'parent_id' => $parent_id,
                'name' => 'nm ' . $type,
                'type' => $type
            ]);

            $parent_id = $chain->id;
        }
    }
}
