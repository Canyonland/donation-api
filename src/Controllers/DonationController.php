<?php

namespace OCEF\DonationAPI\Controllers;

use Illuminate\Support\Facades\Input;
use OCEF\DonationModels\Models\Donation;

class DonationController extends APIController
{
    public function __construct()
    {
        $this->model = Donation::class;
    }

    public function store()
    {
        $input = Input::all();

        $activity = Donation::create([
            'amount' => array_get($input, 'amount'),
            'pledged_at' => array_get($input, 'pledged_at'),
        ]);

        return response()->json($activity);
    }

}
