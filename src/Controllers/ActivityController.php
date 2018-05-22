<?php

namespace OCEF\DonationAPI\Controllers;

use Illuminate\Support\Facades\Input;
use OCEF\DonationModels\Models\Activity;

class ActivityController extends APIController
{
    public function __construct()
    {
        $this->model = Activity::class;
    }


    public function store()
    {
        $input = Input::all();

        $activity = Activity::create([
            'description' => array_get($input, 'description'),
            'data' => json_encode(array_get($input, 'data'))
        ]);

        return response()->json($activity);
    }

}
