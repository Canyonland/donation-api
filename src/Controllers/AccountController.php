<?php

namespace OCEF\DonationAPI\Controllers;

use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Request;
use OCEF\DonationModels\Models\Account;

class AccountController extends APIController
{
    public function __construct()
    {
        $this->model = Account::class;
    }

    public function index()
    {
        $model = $this->model;
        $withOwner = Input::get('withOwner');
        $withStakeholders = Input::get('withStakeholders');

        $items = $model::whereRaw('1');
        if ($withOwner) {
            $items = $items->with('owner');
        }
        if ($withStakeholders) {
            $items = $items->with('stakeholders');
        }

        return response()->json($items->get());
    }

    public function show($id)
    {
        $model = $this->model;
        $item = $model::find($id);
        $item->load('donations', 'payments', 'owner', 'stakeholders');
        return response()->json($item);
    }

    public function update(Request $request, $id)
    {
        $model = $this->model;
        $item = $model::find($id);

        if ($item) {
            $itemData = Request::all();
            $stakeholderIds = array_get($itemData, 'stakeholderIds');
            // TODO Consider any failure ?  Is transaction needed ?
            try {
                $item->stakeholders()->sync($stakeholderIds);
                $item->update($itemData);
            } catch (\Exception $e) {
                return response()->json($e->getMessage());
            }
        }

        return response()->json($item);
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
