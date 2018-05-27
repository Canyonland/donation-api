<?php

namespace OCEF\DonationAPI\Fake;

use Illuminate\Support\Facades\DB;
use Faker\Factory as Faker;

class FakeRepository
{
    use FakeRecordsTraits;

    protected $models = ['Account', 'Activity', 'Donation', 'MatchingGift', 'Payment', 'Stakeholder', 'User'];
    protected $tables = ['accounts', 'activities', 'donations', 'matching_gifts', 'payments', 'stakeholders', 'users', 'account_payment', 'account_stakeholder', 'donation_payment'];

    protected $faker;

    public function __construct()
    {
        $this->faker = Faker::create();
    }

    public function cleanHouse()
    {
        $title = "Truncate All Tables";
        $message = "All data tables are truncated.";
        try {
            foreach ($this->tables as $table) {
                DB::table($table)->truncate();
            }
        } catch (\Exception $e) {
            $message = $e->getMessage();
        }

        return ['title' => $title, 'message' => $message];
    }
}