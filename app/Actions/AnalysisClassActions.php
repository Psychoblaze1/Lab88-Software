<?php

namespace App\Actions;

use App\Models\AnalysisClass;

class AnalysisClassActions
{

    public function firstOrCreate(object $data)
    {
        $model = AnalysisClass::firstOrCreate(
            ['name' => $data->name]
        );

        if (isset($data->description)) {
            $model->description()->create(
                [
                    'content' => $data->description
                ]
            );
        }
        return $model;
    }
}
