<?php

namespace OCEF\DonationAPI\Controllers;

use Illuminate\Support\Facades\Input;
use OCEF\DonationModels\Models\MatchingGift;

class MatchingGiftController extends APIController
{
    public function __construct()
    {
        $this->model = MatchingGift::class;
    }


    public function store()
    {
        $input = Input::all();

        $activity = MatchingGift::create([
            'donor' => array_get($input, 'donor'),
            'amount' => array_get($input, 'amount'),
        ]);

        return response()->json($activity);
    }

}
