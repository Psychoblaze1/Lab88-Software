<?php

namespace App\Actions;

use App\Models\TestStandard;

class TestStandardActions
{

    public function firstOrCreate($name, $description = null)
    {
        $standard = TestStandard::firstOrCreate(
            ['name' => $name],
        );

        if (isset($description)) {
            $standard->description()->create(
                [
                    'content' => $description
                ]
            );
        }
        return $standard;
    }
}
