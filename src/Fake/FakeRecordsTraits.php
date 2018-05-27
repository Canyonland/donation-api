<?php

namespace OCEF\DonationAPI\Fake;
use Illuminate\Support\Facades\Hash;
use App\User;
use Illuminate\Support\Facades\Input;
use OCEF\DonationModels\Models\Account;
use OCEF\DonationModels\Models\Activity;
use OCEF\DonationModels\Models\Donation;
use OCEF\DonationModels\Models\MatchingGift;
use OCEF\DonationModels\Models\Payment;
use OCEF\DonationModels\Models\Stakeholder;

trait FakeRecordsTraits
{
    public function fakeRecords($count, $model)
    {
        $title = "Create Fake Records";
        $message = "{$count} {$model} records created.<hr>";

        if (in_array($model, $this->models)) {
            try {
                $methodName = 'fake' . $model;
                if (method_exists($this, $methodName)) {
                    if (is_numeric($count)) {
                        for ($i = 0; $i < $count; $i++) {
                            $record = $this->{$methodName}();
                            $message .= '<pre>'. json_encode($record, JSON_PRETTY_PRINT) . '</pre><hr>';
                        }
                    }
                }
            } catch (\Exception $e) {
                $message = $e->getMessage();
            }
        } else {
            $message = 'Invalid model "' .  $model . '".  Valid models are: ' . implode(', ', $this->models);
        }

        return ['title' => $title, 'message' => $message];
    }

    protected function fakeAccount()
    {
        // columns: name, is_primary, owner_id (stakeholder ID)
        // Create a stakeholder first no matter what, then use the new stakeholder's ID as the owner ID here.
        // While creating stakeholder, "withUser" will be checked, and a new user will be created if it's truthy.
        $stakeholder = $this->fakeStakeholder();
        $owner_id = $stakeholder->id;
        $name = 'Account for ' . $stakeholder->name;

        $account = Account::create([
            'name' => $name,
            'is_primary' => 1, // TODO fake the scenario of non-primary account ?
            'owner_id' => $owner_id
        ]);

        $account->load('owner');

        return $account;
    }

    // TODO
    protected function fakeActivity()
    {
        // columns: description, data (JSON)
        return Activity::create([
            // TODO
        ]);
    }

    protected function fakeDonation()
    {
        // columns: amount, pledged_at, account_id (account ID)
        // When creating a fake donation, it'll be associated with a randomly chosen account.
        // If there's no account at all in the system, create a new account -- but the stakeholder (owner) of this new account will not have a user associated.
        $account = $this->randomAccount();

        $donation = Donation::create([
            'amount' => rand(10, 200),
            'pledged_at' => $this->faker->dateTimeThisDecade,
            'account_id' => $account['id']
        ]);

        $donation->load('account');

        return $donation;
    }

    protected function fakeMatchingGift()
    {
        // columns: amount, payment_id
        // When creating a fake matching gift, it'll be originated from and associated with an existing payment.
        // If there's no payment at all in the system, create a new payment,
        // then set the matching gift amount to a random number between 1/2 of the payment and the full amount.
        $payments = Payment::all()->toArray();
        if (count($payments) <= 0) {
            $payments = [$this->fakePayment()];
        }
        $payment = $payments[rand(0, count($payments) - 1)];

        $matchingGift = MatchingGift::create([
            'amount' => rand( round($payment['amount'] / 2), $payment['amount']),
            'payment_id' => $payment['id']
        ]);

        $matchingGift->load('payment');

        return $matchingGift;
    }

    protected function fakePayment()
    {
        // columns: amount, payment_method, identifier, initiated_at, shown_at, memo, account_id
        // When creating a fake payment, it'll be associated with a randomly chosen account.
        // If there's no account at all in the system, create a new account -- but the stakeholder (owner) of this new account will not have a user associated.
        $account = $this->randomAccount();

        $initiatedAt =  $this->faker->dateTimeThisDecade;
        $shownAt = date_add($initiatedAt, date_interval_create_from_date_string('3 days'));
        $payment = Payment::create([
            'amount' => rand(10, 200),
            'payment_method' => 'check', // fixed for now
            'identifier' => substr($this->faker->uuid, 0, 100),
            'initiated_at' => $initiatedAt,
            'shown_at' => $shownAt,
            'memo' => substr($this->faker->text, 0, 100),
            'account_id' => $account['id']
        ]);

        $payment->load('account');

        return $payment;
    }

    protected function fakeStakeholder()
    {
        // columns: name, is_business, user_id (nullable), profile (JSON)
        // If a parameter "withUser" is passed in with an truthy value, create a user first,
        // then use the new user's name to create a new stakeholder.
        $withUser = Input::get('withUser');

        $name = $this->faker->name;
        $isBusiness = rand(0, 1);
        if ($isBusiness) {
            $name .= ' Company';
        }

        $user_id = null;

        if ($withUser) {
            $fakeUser = $this->fakeUser($name);
            $user_id = $fakeUser->id;
        }

        $stakeholder = Stakeholder::create([
            'name' => $name,
            'is_business' => $isBusiness,
            'user_id' => $user_id,
            'profile' => null // TODO fake profile
        ]);

        $stakeholder->load('user');

        return $stakeholder;
    }

    protected function fakeUser($name = '')
    {
        // columns: name, email, password ...
        return User::create([
            'name' => $name ? $name : $this->faker->name,
            'email' => $this->faker->email,
            'password' => Hash::make('name')
        ]);
    }

    protected function randomAccount()
    {
        $accounts = Account::all()->toArray();
        if (count($accounts) <= 0) {
            $accounts = [$this->fakeAccount()];
        }
        return $accounts[rand(0, count($accounts) - 1)];
    }
}