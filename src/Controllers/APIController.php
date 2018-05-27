<?php

namespace OCEF\DonationAPI\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Request;

class APIController extends Controller
{
    protected $model;

    public function index()
    {
        $model = $this->model;
        $all = $model::all();
        return response()->json($all);
    }

    public function show($id)
    {
        $model = $this->model;
        $item = $model::find($id);
        return response()->json($item);
    }

    public function update(Request $request, $id)
    {
        $model = $this->model;
        $item = $model::find($id);
        if ($item) {
            $item->update(Request::all());
        }
        return response()->json($item);
    }

    public function destroy($id)
    {
        $model = $this->model;
        $item = $model::find($id);
        if ($item) {
            $item->delete();
        }
        return response()->json([]);
    }

    public function search()
    {
        $model = $this->model;
        $input = Input::all();
        $query = $model::search($input);
        return response()->json($query->get());
    }
}
