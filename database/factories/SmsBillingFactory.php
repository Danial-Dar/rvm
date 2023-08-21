<?php

namespace Database\Factories;

use App\Models\Campaign;
use App\Models\Company;
use App\Models\Message;
use App\Models\SmsBilling;
use App\Models\SmsCampaign;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class SmsBillingFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */

    protected $model = SmsBilling::class;

    public function definition()
    {
        $ele = $this->faker->numberBetween($min = 1, $max = 4);
        $description = '';
        $amount = 0;
        $type = null;
        $message = Message::inRandomOrder()->first();
        $company = Company::where('id', $message !==  null ?? $message->company_id)->first();
        $user = User::where('company_id', $company !==  null ?? $company->id)->inRandomOrder()->first();
        $campaign = SmsCampaign::where('user_id', $user !==  null ?? $user->id)->inRandomOrder()->first();
        $date = $this->faker->dateTimeBetween('-7 days', '+2 months')->format('Y-m-d H:i:s');
        switch ($ele) {
            case 1:
                $type = 'INBOUND_SMS';
                $amount = $this->faker->numberBetween($min = 2, $max = 5);
                $description = 'INBOUND_SMS#'.$message !==  null ?? $message->id.';COST#'.$amount.';Date-'.$date;
                break;
            case 2:
                $type = 'OUT_BOUND_SMS';
                $amount = $this->faker->numberBetween($min = 5, $max = 8);
                $description = 'OUT_BOUND_SMS#'.$message !==  null ?? $message->id.';COST#'.$amount.';Date-'.$date;
                break;
            case 3:
                $type = 'SMS_CAMPAIGN';
                $amount = $this->faker->numberBetween($min = 30, $max = 100);
                $description = 'SMS_CAMPAIGN#'.$campaign !==  null ?? $campaign->id.';COST#'.$amount.';Date-'.$date;
                break;
            case 4:
                $type = 'MONTHLY_CHARGE';
                $amount = $this->faker->numberBetween($min = 150, $max = 200);
                $description = 'MONTHLY_CHARGE;COST#'.$amount.';Date-'.$date;
                break;
            default:
                # code...
                break;
        }
        return [
            'type' => $type,
            'amount' => $amount,
            'description' => $description,
            'user_id' => $user !== null ?? $user->id,
            'company_id' => $company !== null ?? $company->id,
            'created_at' => $date
        ];
    }
}
