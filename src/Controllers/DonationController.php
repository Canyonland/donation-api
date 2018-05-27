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
            'amount' => array_get($input, 'amount'),
            'pledged_at' => array_get($input, 'pledged_at'),
        ]);

        return response()->json($activity);
    }

}
