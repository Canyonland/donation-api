<?php

namespace OCEF\DonationAPI\Fake;

use App\Http\Controllers\Controller;
use OCEF\DonationAPI\Fake\FakeRepository;

class FakeController extends Controller
{
    protected $repository;

    public function __construct()
    {
        $this->repository = new FakeRepository();
    }

    public function fake($count, $model)
    {
        return response()->json($this->repository->fakeRecords($count, $model));
    }

    public function cleanHouse()
    {
        return response()->json($this->repository->cleanHouse());
    }
}