<?php

namespace App\Nova\Actions\Users;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Collection;
use Laravel\Nova\Actions\Action;
use Laravel\Nova\Fields\ActionFields;
use Laravel\Nova\Http\Requests\NovaRequest;
use App\Models\User;
use App\Models\Company;
use App\Models\UserSetting;
use Laravel\Nova\Fields\Number;
class UpdateSendLimit extends Action
{
    use InteractsWithQueue, Queueable;
    
    public $name = 'Update Send Limit';

    /**
     * Perform the action on the given models.
     *
     * @param  \Laravel\Nova\Fields\ActionFields  $fields
     * @param  \Illuminate\Support\Collection  $models
     * @return mixed
     */
    public function handle(ActionFields $fields, Collection $models)
    {
        // save multiple users
        if ($models->count() > 1) {
            foreach ($models as $model) {
                $user = User::findorFail($model->id);
                if($user){
                    $settings = UserSetting::Where('user_id', $user->id)->Where('key', 'daily_max_limit')->get()->toArray();
                    foreach($settings as $key => $setting){
                        $userSetting = UserSetting::updateOrCreate(
                            ['user_id' => $user->id, 'key' => 'daily_max_limit']
                        );
                        $userSetting->key_label = $setting['key_label'];
                        $userSetting->value = $fields->update_send_limit;
                        $userSetting->company_id = $user->company_id;
                        $userSetting->save();
                    }
                }
            }
            return Action::message('Send Limit updated successfully');
        }

        $user_id = $models->first()->id;
        $user = User::findorFail($user_id);
        $setting = UserSetting::Where('user_id', $user_id)->Where('key', 'daily_max_limit')->first();

        // return 0;
        $value = 0;

        if ($setting != "") {
            $value = $setting->value;
        }
        // single user update
        if($fields->update_send_limit && $user){
            $settings = UserSetting::Where('user_id', $user_id)->Where('key', 'daily_max_limit')->get()->toArray();
            foreach($settings as $key => $setting){
                $userSetting = UserSetting::updateOrCreate(
                    ['user_id' => $user->id, 'key' => 'daily_max_limit']
                );
                $userSetting->key_label = $setting['key_label'];
                $userSetting->value = $fields->update_send_limit;
                $userSetting->company_id = $user->company_id;
                $userSetting->save();
            }
            return Action::message('Send Limit updated Successfully');
        }else{
            return Action::modal('UpdateSendLimit', [
                'value' => $value,
            ]);
        }
        
        // return Action::message('Send Limit updated Successfully');
    }

    /**
     * Get the fields available on the action.
     *
     * @param  \Laravel\Nova\Http\Requests\NovaRequest  $request
     * @return array
     */
    public function fields(NovaRequest $request)
    {
        return [
            Number::make('Send Limit', 'update_send_limit')->min(0),
        ];
    }
}
