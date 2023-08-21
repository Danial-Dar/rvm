<?php

namespace App\Nova\Actions\Campaign;

use App\Models\Campaign;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Collection;
use Laravel\Nova\Actions\Action;
use Laravel\Nova\Fields\ActionFields;
use Laravel\Nova\Fields\Text;
use Laravel\Nova\Http\Requests\NovaRequest;
use Rvm\RangeInput\RangeInput;
use Rvm\SendSpeed\SendSpeed;

class UpdateSendSpeed extends Action
{
    use InteractsWithQueue, Queueable;

    protected $campaign_id;
    protected $drops_per_hour;
    /**
     * Perform the action on the given models.
     *
     * @param  \Laravel\Nova\Fields\ActionFields  $fields
     * @param  \Illuminate\Support\Collection  $models
     * @return mixed
     */
    public function __construct($drops_per_hour)
    {
        $this->drops_per_hour = $drops_per_hour;

    }
    public function handle(ActionFields $fields, Collection $models)
    {
        $models = $models->transform(function ($item, $key) {
            return $item->id;
        })->toArray();

        Campaign::whereIn('id', $models)->update(['drops_per_hour' => $fields->drops_per_hour]);

        Action::message('Send Speed Successfully');


        $curl = curl_init();

        curl_setopt_array($curl, array(
        CURLOPT_URL => 'https://vos-api.voslogic.com/api/callqueues/'.$models[0],
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => '',
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 0,
        CURLOPT_FOLLOWLOCATION => true,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => 'DELETE',
        ));

        $response = curl_exec($curl);

        curl_close($curl);
        $curl = curl_init();

        curl_setopt_array($curl, array(
        CURLOPT_URL => 'https://vos-api.voslogic.com/api/callqueues/'.$models[0],
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => '',
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 0,
        CURLOPT_FOLLOWLOCATION => true,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => 'POST',
        ));

        $response = curl_exec($curl);

        curl_close($curl);

        return Action::visit('/resources/campaigns');
        //
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
            SendSpeed::make('Send Speed','drops_per_hour')->default($this->drops_per_hour),

            // RangeInput::make('Drops Per Hour', 'drops_per_hour')->default(function ($request) {
            //     return '0';
            // }),
        ];
    }
}
