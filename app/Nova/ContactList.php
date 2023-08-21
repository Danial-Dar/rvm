<?php

namespace App\Nova;

use App\Nova\Filters\Category;
use Laravel\Nova\Fields\ID;
use Laravel\Nova\Fields\Text;
use Laravel\Nova\Fields\Badge;
use Laravel\Nova\Fields\HasMany;
use Laravel\Nova\Fields\BelongsTo;
use App\Nova\Metrics\ContactsTotal;
use App\Nova\Metrics\ContactsFailedTotal;
use Laravel\Nova\Http\Requests\NovaRequest;
use App\Nova\Metrics\ContactsSuccessfulTotal;
use App\Nova\Actions\ContactList\DownloadList;
use Carbon\Carbon;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\DB;
use Laravel\Nova\Nova;

class ContactList extends Resource
{
    /**
     * The model the resource corresponds to.
     *
     * @var string
     */
    public static $model = \App\Models\ContactList::class;

    /**
     * The single value that should be used to represent the resource when being displayed.
     *
     * @var string
     */
    public static $title = 'name';

    /**
     * The columns that should be searched.
     *
     * @var array
     */
    public static $search = [
        'id', 'name', 'status',
    ];

    public static $group = 'Voice';

    public static function label()
    {
        return 'Contact Lists';
    }

    /**
     * Get the fields displayed by the resource.
     *
     * @return array
     */
    public function fields(NovaRequest $request)
    {
        $debug = Config::get('app.env');
        $id = $this->id;
        // $dnc_count = Cache::remember($debug.'contact-list-dnc.'.$id,60000, function() use($id){
        //     $dnc_count = DB::table('dnc')
        //     ->join('contacts', 'contacts.number', '=', 'dnc.number')
        //     ->where('contacts.contact_list_id', '=', $id)->count();
        //     return $dnc_count;
        // });

        return [
            ID::make()->sortable(),
            Text::make('Name', 'name')->sortable()->rules('required', 'max:255'),
            BelongsTo::make('User')->sortable()->hideWhenCreating()->hideWhenUpdating()->canSee(function ($request) {
                return $request->user()->hasRole('super-admin');
            }),
            BelongsTo::make('Company')->sortable()->hideWhenCreating()->hideWhenUpdating()->canSee(function ($request) {
                return $request->user()->hasRole('super-admin');
            }),
            Text::make('Uploaded By', function () {
                return $this->user ? $this->user->first_name.' '.$this->user->last_name : '';
            })->hideWhenCreating()->hideWhenUpdating()->hideFromIndex(),
            Text::make('Total Recipients', 'total_contacts', function () {
                return number_format($this->total_contacts);
            })->hideWhenCreating()->hideWhenUpdating(),
            // Text::make('Dnc Contacts Count', function() use ($dnc_count){
            //     return $dnc_count;
            // })->onlyOnIndex(),
            Text::make('Success', 'success', function () {
                return is_null($this->success) ? '0' : number_format($this->success);
            })->hideWhenCreating()->hideWhenUpdating(),
            Text::make('Fail', 'failed', function () {
                return is_null($this->failed) ? '0' : number_format($this->failed);
            })->hideWhenCreating()->hideWhenUpdating()->hideFromIndex(),
            Badge::make('Status', 'status')->map([
                'active' => 'success',
                'deleted' => 'danger',
                'preprocessing' => 'info',
                'uploading' => 'warning',
            ]),
            Text::make('Created At', function () {
                return Carbon::createFromFormat('Y-m-d H:i:s', date($this->created_at))->format('m/d/Y h:i:s a');
            })->onlyOnIndex(),
            HasMany::make('Contacts', 'contacts', Contact::class),
        ];
    }

    /**
     * Get the cards available for the request.
     *
     * @return array
     */
    public function cards(NovaRequest $request)
    {
        return [
            (new ContactsTotal()),
            (new ContactsSuccessfulTotal()),
            (new ContactsFailedTotal()),
        ];
    }

    /**
     * Get the filters available for the resource.
     *
     * @return array
     */
    public function filters(NovaRequest $request)
    {
        return [];
    }

    /**
     * Get the lenses available for the resource.
     *
     * @return array
     */
    public function lenses(NovaRequest $request)
    {
        return [];
    }

    /**
     * Get the actions available for the resource.
     *
     * @return array
     */
    public function actions(NovaRequest $request)
    {
        return [
            (new DownloadList())->showInline()->withoutConfirmation()->canRun(function (NovaRequest $request) {
                return true;
            }),
        ];
    }

    public static function indexQuery(NovaRequest $request, $query)
    {
        if (!$request->user()->hasRole('super-admin')) {
             $query->where('user_id', $request->user()->id);
        }
        return $query->where(function($query) {
            $query->whereNull('type')->orWhere('type','=', '');
        });
    }

    public static function additionalActions()
    {
        return [['component' => 'contact-list-stat']];
    }

    public static function additionalButtons()
    {
        if (auth()->check() && Nova::user()->can('create-contact-list')) {

        return [
            [
                //'component' => 'UploadContactList',
                'component' => 'UploadContactListCsvBox',
            ],
        ];
        }
        else {
            return false;
        }
    }
}
