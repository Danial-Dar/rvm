<?php

namespace App\Nova;

use App\Nova\Actions\CompanyDncStats;
use Carbon\Carbon;
use Eminiarts\Tabs\Tabs;
use GrahamCampbell\ResultType\Success;
use Illuminate\Http\Request;
use Laravel\Nova\Fields\Badge;
use Laravel\Nova\Fields\File;
use Laravel\Nova\Fields\HasMany;
use Laravel\Nova\Fields\HasOne;
use Laravel\Nova\Fields\ID;
use Laravel\Nova\Fields\Number;
use Laravel\Nova\Fields\Select;
use Laravel\Nova\Fields\Text;
use Laravel\Nova\Fields\Textarea;
use Laravel\Nova\Http\Requests\NovaRequest;
use Laravel\Nova\Nova;
use YieldStudio\NovaPhoneField\PhoneNumber;
use Rvm\FileDragDrop\FileDragDrop;

class Company extends Resource
{
    /* The model the resource corresponds to.
     *
     * @var string
     */
    public static $model = \App\Models\Company::class;

    /* The single value that should be used to represent the resource when being displayed.
     *
     * @var string
     */
    public static $title = 'name';

    /* The columns that should be searched.
     *
     * @var array
     */
    public static $search = [
        'id', 'name',
    ];

    /* Get the fields displayed by the resource.
     *
     * @param  \Laravel\Nova\Http\Requests\NovaRequest  $request
     * @return array
     */
    public function fields(NovaRequest $request)
    {
        $balance = \App\Models\Balance::where('company_id',$this->id)->sum('amount');
        $balance = number_format($balance, 2);

        $bal = \App\Models\Balance::where('company_id',$this->id)->where('type', 'PAYMENT')->sum('amount');
        $date = Carbon::parse($this->created_at);
        $now = Carbon::now();

        $diff = $date->diffInDays($now);
        $avg = 0;
        if ($diff != 0 && $bal != 0) {
            $avg = ($bal / $diff) * 100;
            $avg = number_format($avg, 2);
        }
        return [
            ID::make()->sortable(),

            Text::make('Company name', 'name')
                    ->sortable()->onlyOnIndex(),

            Text::make('Average Daily Spend', function() use ($avg){
                return $avg;
            })->onlyOnIndex(),

            Text::make('User count', 'user_count')->onlyOnIndex(),

            Text::make('Sent', 'Sent')->onlyOnIndex(),

            Text::make('Pending', 'Pending')->onlyOnIndex(),

            Text::make('Dnc Count', 'Dnc')->onlyOnIndex(),

            // Text::make('Credit Limit', 'credit_limit'),
            //Number::make('Credit Limit', 'credit_limit')->min(1)->max(20000)->step(0.01),

            new Tabs('Basic Info', [
                'Basic Info' => [
                    Text::make('Name', 'name')
                    ->sortable()
                    ->hideFromIndex()
                    ->rules('required', 'max:255'),

                    Textarea::make('Notes', 'notes')
                    ->rows(3)->hideFromIndex(),

                    Select::make('Status')->options([
                        1 => 'Active',
                        0 => 'InActive',
                    ])->hideFromDetail()->hideFromIndex()->displayUsingLabels()->rules('required'),
                ],

                'Contact Info' => [

                    // Text::make('Name', 'name')
                    //     ->sortable()
                    //     ->hideFromIndex()
                    //     ->rules('required', 'max:255'),
                    Text::make('First Name', 'first_name'),
                    Text::make('Last Name', 'last_name'),
                    Text::make('Address', 'address')->rules('required')
                    ->sortable()->hideFromIndex(),
                    Text::make('City', 'city')
                    ->sortable()->hideFromIndex(),

                    Text::make('State', 'state')
                    ->sortable()->hideFromIndex(),

                    Text::make('Zip Code', 'zip')
                    ->sortable()->hideFromIndex(),
                    Text::make('Country', 'country')
                    ->sortable()->hideFromIndex(),

                    PhoneNumber::make('Phone Number', 'phone_number')->rules('required')
                    ->sortable()->hideFromIndex(),

                    Text::make('Email', 'email')->rules('required')
                    ->sortable()->hideFromIndex(),

                    Text::make('Ein', 'ein')->rules('required')
                    ->sortable()->hideFromIndex(),
                ],
                'Documents' => [
                    FileDragDrop::make('Document')->hideFromIndex(),
                ],
                'Pricing' => [
                    HasMany::make('Company Setting', 'company_settings', CompanySetting::class)
                ]
            ]),



            Badge::make('Status','custom_status')->map([
                'Active' => 'success',
                'InActive' => 'danger'
            ])->onlyOnIndex()->rules('required'),


            HasMany::make('User', 'users'),
            Badge::make('Balance', function() use ($balance){
                return $balance;
            })->map([
                $balance => ((float) $balance >= 0) ? 'success':'danger',
            ])->onlyOnIndex(),


            // File::make('Document')->disk('public')->hideFromIndex(),

            // Badge::make('Status','custom_status')->map([
            //     'Active' => 'success',
            //     'InActive' => 'danger'
            // ])->hideWhenCreating(),


            // HasOne::make('Company Setting', 'company_settings', CompanySetting::class)
        ];
    }

    public static function additionalButtons()
    {
        $user = Nova::user();
        if($user && $user->can('add-payment')) {
            return [['component' => 'AddPayment']];
        }
    }

    /* Get the cards available for the request.
     *
     * @param  \Laravel\Nova\Http\Requests\NovaRequest  $request
     * @return array
     */
    public function cards(NovaRequest $request)
    {
        return [];
    }

    /* Get the filters available for the resource.
     *
     * @param  \Laravel\Nova\Http\Requests\NovaRequest  $request
     * @return array
     */
    public function filters(NovaRequest $request)
    {
        return [];
    }

    /* Get the lenses available for the resource.
     *
     * @param  \Laravel\Nova\Http\Requests\NovaRequest  $request
     * @return array
     */
    public function lenses(NovaRequest $request)
    {
        return [];
    }

    /* Get the actions available for the resource.
     *
     * @param  \Laravel\Nova\Http\Requests\NovaRequest  $request
     * @return array
     */
    public function actions(NovaRequest $request)
    {
        return [
            (new CompanyDncStats())->showInline()->withoutConfirmation()->canSee(function ($request) {
                return true;
            })->canRun(function($request, $model) {
                return true;
            })
        ];
    }
    public static function additionalActions() {

        return [
            [
                'component' => 'CompanyDncStat'
            ],
        ];
    }
}
