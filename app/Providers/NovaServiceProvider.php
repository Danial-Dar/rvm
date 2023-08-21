<?php

namespace App\Providers;

use App\Nova\DNC;
use App\Nova\Email;
use App\Nova\CallFlowNumber;
use App\Nova\Address;
use App\Nova\PostCard;
use App\Nova\Role;
use App\Nova\User;
use App\Nova\Company;
use App\Nova\Campaign;
use App\Nova\MyNumber;
use App\Nova\SwNumber;
use Laravel\Nova\Nova;
use App\Nova\Recording;
use App\Nova\Permission;
use App\Nova\SmsDomains;
use Rvm\Billing\Billing;
use Rvm\ContactListStat\ContactListStat;
use Rvm\Setting\Setting;
use App\Nova\ContactList;
use App\Nova\SmsCompaign;
use App\Nova\SmsBannedWord;
use App\Nova\SmsOptOutWord;
use Illuminate\Http\Request;
use App\Nova\IncomingCallLog;
use App\Nova\SmsContactLists;
use Laravel\Nova\Fields\Number;
use Laravel\Nova\Menu\MenuItem;
use Rvm\UserSetting\UserSetting;
use App\Nova\CallerIdContactList;
use App\Models\User as ModelsUser;
use App\Nova\Agent;
use App\Nova\Dashboards\CirInsights;
use Laravel\Nova\Menu\MenuSection;
use Illuminate\Support\Facades\Gate;
use Rvm\CampaignHours\CampaignHours;
use Outl1ne\NovaSettings\NovaSettings;
use App\Nova\Dashboards\DashboardInsights;
use Sms\SmsCompaignBuilder\SmsCompaignBuilder;
use Laravel\Nova\NovaApplicationServiceProvider;
use Rvm\AddPhrase\AddPhrase;
use App\Nova\ApiSetting;
use App\Nova\CallerIdSettings;
use App\Nova\Dashboards\QaReports;
use App\Nova\Department;
use App\Nova\Lead;
use App\Nova\Scorecard;
use App\Nova\Unroutable;
use Laravel\Nova\Menu\MenuGroup;
use Laravel\Nova\Notifications\Notification;
use Laravel\Nova\Observable;
use Rvm\AgentDashboard\AgentDashboard;
use Rvm\Department\Department as DepartmentDepartment;
use Rvm\EditMynumber\EditMynumber;
use Rvm\Flaggedcalls\Flaggedcalls;
use Rvm\Processingcalls\Processingcalls;
use Rvm\Reports\Reports;
use Rvm\Scorecard\Scorecard as ScorecardScorecard;
use Rvm\SearchCalls\SearchCalls;
use Rvm\ViewStat\ViewStat;
use Rvm\ViewSmsStat\ViewSmsStat;
use App\Observers\NotificationObserver;
use App\Nova\AgentLog;
use App\Nova\Banner;
use App\Nova\Bot as BotResource;
use App\Nova\CallFlow;
use App\Nova\CallFlowStep;
use App\Nova\CampaignScript;
use App\Nova\Cdr;
use App\Nova\ContactUs;
use App\Nova\Disposition;
use App\Nova\LeadList;
use App\Nova\PredictiveAgent;
use App\Nova\SmsNumber;
use App\Nova\Team;
use App\Nova\Topic;
use Rvm\Bot\Bot;
// use Rvm\BotTrain\BotTrain;
use Rvm\SmsCampaignBuilder\SmsCampaignBuilder;
use CodencoDev\NovaGridSystem\NovaGridSystem;
use Rvm\BotTrain\BotTrain;
use Rvm\CallFlowStep\CallFlowStep as CallFlowStepCallFlowStep;
use Rvm\NewCallFlowStep\NewCallFlowStep;

class NovaServiceProvider extends NovaApplicationServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        parent::boot();

        Nova::style('custom', resource_path('css/custom.css'));


        $arr = [
                // MenuSection::dashboard(DashboardInsights::class)->icon('chart-bar'),
                MenuSection::make('Dashboards', [
                    MenuItem::dashboard(DashboardInsights::class),
                    MenuItem::dashboard(CirInsights::class),
                    MenuItem::dashboard(QaReports::class),
                    MenuItem::make('Agent Dashboard')->path('agent-dashboard'),

                ]),

                MenuSection::make('Voice', [
                    MenuItem::resource(Campaign::class),
                    MenuItem::resource(MyNumber::class),
                    MenuItem::resource(DNC::class),
                    MenuItem::resource(ContactList::class),
                    MenuItem::resource(IncomingCallLog::class),
                    MenuItem::resource(Recording::class),
                    MenuItem::make('Contact List Stat')->path('contact-list-stat'),
                    MenuItem::make('Bot')->path('bot'),
                ])->icon('phone')->collapsable(),

                MenuSection::make('Sms', [
                    MenuItem::resource(SmsBannedWord::class),
                    MenuItem::resource(SmsCompaign::class),
                    MenuItem::resource(SmsContactLists::class),
                    MenuItem::resource(SmsNumber::class),
                    MenuItem::resource(SmsDomains::class),
                    MenuItem::resource(SmsOptOutWord::class),
                ])->icon('chat')->collapsable()->canSee(function($request) {
                    return $request->user()->can('view-sms');
                }),

                MenuSection::make('Email', [
                    MenuItem::resource(Email::class),
                     MenuItem::resource(Address::class),
                    MenuItem::resource(PostCard::class),
                   // MenuItem::make('Email List')->path('email'),
                  //  MenuItem::make('Create Email')->path('create-email'),
                   // MenuItem::make('Send Email')->path('send-email'),
                    /*MenuItem::resource(SmsBannedWord::class),
                    MenuItem::resource(SmsCompaign::class),
                    MenuItem::resource(SmsContactLists::class),
                    MenuItem::resource(SmsNumber::class),
                    MenuItem::resource(SmsDomains::class),
                    MenuItem::resource(SmsOptOutWord::class),*/
                ])->icon('mail')->collapsable()->canSee(function($request) {
                    return $request->user()->can('view-email');
                }),


                 MenuSection::make('Call Flow', [
                    //MenuItem::make('Number')->path('numer'),
                    MenuItem::resource(CallFlowNumber::class),
                    MenuItem::resource(CallFlow::class),
                    MenuItem::resource(CallFlowStep::class),
                   /* MenuItem::resource(Email::class),
                     MenuItem::resource(Address::class),
                    MenuItem::resource(PostCard::class),*/
                   // MenuItem::make('Email List')->path('email'),
                  //  MenuItem::make('Create Email')->path('create-email'),
                   // MenuItem::make('Send Email')->path('send-email'),
                    /*MenuItem::resource(SmsBannedWord::class),
                    MenuItem::resource(SmsCompaign::class),
                    MenuItem::resource(SmsContactLists::class),
                    MenuItem::resource(SmsNumber::class),
                    MenuItem::resource(SmsDomains::class),
                    MenuItem::resource(SmsOptOutWord::class),*/
                ])->icon('phone')->collapsable()->canSee(function($request) {
                    return $request->user();
                    // ->can('view-email');
                }),
                MenuSection::make('QA-Tool', [
                    // MenuItem::resource(Scorecard::class),

                    // MenuItem::make('Scorecards')->path('scorecard'),
                    // MenuItem::make('Departments')->path('department'),
                    // MenuItem::resource(Topic::class),

                    MenuItem::resource(Agent::class),

                    // MenuGroup::make('Manage QA', [
                        // MenuItem::resource(Group::class),
                        // MenuItem::resource(Department::class),
                    // ])->collapsable(),
                    MenuGroup::make('Search Calls', [
                        MenuItem::make('All Calls')->path('search-calls'),
                        MenuItem::make('Processing Calls')->path('processingcalls'),
                        MenuItem::make('Flagged Calls')->path('flaggedcalls'),
                    ])->collapsable(),
                ])->icon('question-mark-circle')->collapsable()->canSee(function ($request) {
                    if($request->user()){
                        return $request->user()->can('view-qa');
                    }

                    return false;
                }),

                MenuSection::make('Caller Id', [

                    MenuItem::resource(CallerIdContactList::class),
                    // MenuItem::resource(CallerIdSettings::class),

                ])->icon('chat')->collapsable()->canSee(function($request) {
                    return $request->user()->can('view-caller-id-reputation');
                }),



                MenuSection::make('User', [
                    MenuItem::resource(User::class),
                    MenuItem::resource(Role::class),
                    MenuItem::resource(Permission::class),
                    MenuItem::make('User Setting', '/user-setting')->canSee(function ($request) {
                        if($request->user()){
                            return $request->user()->role === 'user';
                        }

                        return false;
                    }),
                ])->icon('user')->collapsable(),

                MenuSection::make('Billing')->path('billing')->icon('cash')->canSee(function ($request) {
                    if($request->user()){
                        return $request->user()->can('view-billing');
                    }

                    return false;
                }),

                MenuSection::make('Campaign Hour')->path('campaign-hours')->icon('clock')->canSee(function ($request) {
                    if($request->user()){
                        return $request->user()->role == 'user' || $request->user()->role == 'company';
                    }

                    return false;
                }),

                MenuSection::make('Add Phrase')->path('add-phrase')->icon('cog')->canSee(function ($request) {
                    // return $request->user()->role == 'admin';
                }),


                MenuSection::make('Admin Tools', [
                    MenuItem::resource(Banner::class),
                    // MenuItem::resource(Bot::class),
                    MenuItem::resource(Company::class),
                    MenuItem::resource(ContactUs::class),
                    MenuItem::resource(CallerIdSettings::class),
                    MenuItem::make('Settings')->path('setting')->canSee(function ($request) {
                        if($request->user()){
                            return $request->user()->role == 'admin';
                        }

                        return false;
                    }),
                    MenuItem::link('Reports', 'reports')->canSee(function($request) {
                        if($request->user()){
                            return $request->user()->role == 'admin';
                        }

                        return false;
                    }),
                    MenuItem::resource(ApiSetting::class),
                    MenuItem::resource(Unroutable::class)->canSee(function($request) {
                        if($request->user()){
                            return $request->user()->role == 'admin';
                        }

                        return false;
                    }),

                    MenuItem::resource(Cdr::class)->canSee(function ($request) {
                        if($request->user()){
                            return $request->user()->role == 'admin';
                        }

                        return false;
                    }),
                    MenuItem::resource(SwNumber::class),
                ])->icon('user')->collapsable(),

                MenuSection::make('Predictive Dialer', [
                    MenuItem::make('Agent Portal')->path('agent-dashboard'),
                    MenuItem::resource(PredictiveAgent::class),
                    MenuItem::resource(LeadList::class),
                    MenuItem::resource(Lead::class),
                    MenuItem::resource(AgentLog::class),
                    MenuItem::resource(CampaignScript::class),
                    MenuItem::resource(Team::class),
                    MenuItem::resource(Disposition::class),

                ])->canSee(function($request) {
                    return $request->user()->can('view-predictive-dialer');
                })->icon('paper-airplane')->collapsable(),

            ];
        Nova::mainMenu(function (Request $request) use ($arr) {
            return $arr;
        });


        NovaSettings::addSettingsFields([
            Number::make('Daily Limit', 'daily_limit'),
            Number::make('Rvm Call Price', 'rvm_call_price'),
            Number::make('Bot Call Price', 'bot_call_price'),
            Number::make('Press 1 Call Price', 'press_1_call_price'),
            Number::make('Number Price', 'number_price'),
            Number::make('Per Minute Price', 'per_minute_call_price'),
        ]);


    }

    /**
     * Register the Nova routes.
     *
     * @return void
     */
    protected function routes()
    {
        Nova::routes()
                ->withAuthenticationRoutes()
                ->withPasswordResetRoutes()
                ->register();
    }

    /**
     * Register the Nova gate.
     *
     * This gate determines who can access Nova in non-local environments.
     *
     * @return void
     */
    protected function gate()
    {
        $users = ModelsUser::get()->pluck('email')->toArray();
        Gate::define('viewNova', function ($user) use ($users) {
            return in_array($user->email, $users);
        });
    }

    /**
     * Get the dashboards that should be listed in the Nova sidebar.
     *
     * @return array
     */
    protected function dashboards()
    {
        return [
            new CirInsights(),
            new DashboardInsights(),
            new QaReports(),
        ];
    }

    /**
     * Get the tools that should be listed in the Nova sidebar.
     *
     * @return array
     */
    public function tools()
    {
        return [
            // (new SmsCompaignBuilder())->canSee(function ($request) {
            //     return $request->user()->role === 'admin';
            // }),
            (new CampaignHours())->canSee(function ($request) {
                return $request->user()->role == 'user' || $request->user()->role == 'company';
            }),

            new SmsCompaignBuilder(),

            new Setting(),

            new Billing(),
            (new UserSetting())->canSee(function ($request) {
                return auth()->user()->role === 'user';
            }),

            // (new SearchCalls())->canSee(function ($request) {
            //     return auth()->user()->role === 'admin';
            // }),
            new SearchCalls(),
            new AddPhrase(),
            new Processingcalls(),
            new Flaggedcalls(),
            (new Reports())->canSee(function ($request) {
                return $request->user()->role === 'admin';
            }),
            new AgentDashboard(),

            new ScorecardScorecard(),
            new ContactListStat(),

            new Bot(),

            new ViewStat(),
            //new BotTrain(),
            new ViewSmsStat(),

            new DepartmentDepartment(),

            new EditMynumber(),

            new SmsCampaignBuilder(),
            new NovaGridSystem(),
            new CallFlowStepCallFlowStep(),
            new NewCallFlowStep(),
        ];
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
    }
}
