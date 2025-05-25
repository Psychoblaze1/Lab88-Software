<?php

namespace Database\Seeders;

use App\Models\Account;
use App\Models\Instrument;
use App\Models\Lab;
use App\Models\TestParameter;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class LabSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $accounts = Account::all();
        $params = TestParameter::all();

        $godInst =  Instrument::create([
            'name' => 'GOD OF ALL PARAMS'
        ]);
        foreach ($params as $parameter) {
            DB::table('instruments_test_parameters')->insert(
                [
                    'instrument_id' => $godInst->id,
                    'test_parameter_id' => $parameter->id
                ]
            );
        }

        $i = 1;
        $instrument = Instrument::all();
        foreach ($accounts as $account) {
            $lab =  Lab::create(
                [
                    'account_id' => $account->id,
                    'name' => 'Lab:_' . $i
                ]
            );

            $lab->instruments()->attach($instrument);
            $i++;
        }
    }
}
