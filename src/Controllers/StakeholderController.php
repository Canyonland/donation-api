<?php

namespace OCEF\DonationAPI\Controllers;

use Illuminate\Support\Facades\Input;
use OCEF\DonationModels\Models\Donation;
use OCEF\DonationModels\Models\Stakeholder;

class StakeholderController extends APIController
{
    public function __construct()
    {
        $this->model = Stakeholder::class;
    }

    public function store()
    {
        $input = Input::all();

        $activity = Donation::create([
            'donor' => array_get($input, 'donor'),
            'amount' => array_get($input, 'amount'),
        ]);

        return response()->json($activity);
    }

}
