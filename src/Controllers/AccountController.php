<?php

namespace OCEF\DonationAPI\Controllers;

use Illuminate\Support\Facades\Input;
use OCEF\DonationModels\Models\Account;

class AccountController extends APIController
{
    public function __construct()
    {
        $this->model = Account::class;
    }


    public function store()
    {
        $input = Input::all();

        $activity = Account::create([
            'amount' => array_get($input, 'amount'),
        ]);

        return response()->json($activity);
    }

}
