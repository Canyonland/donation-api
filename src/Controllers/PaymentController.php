<?php

namespace OCEF\DonationAPI\Controllers;

use Illuminate\Support\Facades\Input;
use OCEF\DonationModels\Models\Donation;
use OCEF\DonationModels\Models\Payment;

class PaymentController extends APIController
{
    public function __construct()
    {
        $this->model = Payment::class;
    }

    public function index()
    {
        $model = $this->model;
        $withAccount = Input::get('withAccount');

        $items = $model::whereRaw('1');
        if ($withAccount) {
            $items = $items->with('account');
        }

        return response()->json($items->get());
    }

    public function show($id)
    {
        $model = $this->model;
        $item = $model::find($id);
        $item->load('account');
        return response()->json($item);
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
