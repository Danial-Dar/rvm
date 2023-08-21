<?php

namespace Rvm\UserSetting\Http\Controllers;

use Laravel\Nova\Nova;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\UserSetting;
use Illuminate\Support\Facades\Hash;

class UserSettingController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $user = Nova::user($request);
        $settings = UserSetting::select('key', 'value', 'key_label')
        ->Where('user_id', $user->id)
        ->WhereIn('key', ['api_key', 'api_password', 'daily_max_limit'])->get();

        $fields = [
            'api_key' => null,
            'api_password' => null,
            'daily_max_limit' => null,
        ];
        foreach ($settings as $v) {
            $fields[$v->key] = $v->value;
        }

        return response()->json(
            [
                    'status' => true,
                    'fields' => [
                        'api_key' => $fields['api_key'],
                        'api_password' => $fields['api_password'],
                        'daily_max_limit' => $fields['daily_max_limit'],
                    ],
                    'userData' => [
                        'email' => $user->email,
                        'avatar_url' => $user->user_image_path,
                        'avatar' => $user->user_image,
                    ], ],
            200
        );
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $user = Nova::user($request);
        $request->validate(
            [
                'email' => ['required', 'email'],
                'image' => ['mimes:png,jpg,jpeg', 'max:2048'],
                'dailyLimit' => ['numeric'],
                'isDailyLimit' => [''],
                'apiKey' => [],
                'apiPassword' => [],
            ]
        );

        if (isset($request->image)) {
            $fileName = time().'.'.$request->image->extension();
            $client = connectAwsS3();
            $client->putObject(
                [
                    'Bucket' => 'RVM',
                    'Key' => $fileName,
                    'Body' => file_get_contents($request->image),
                    'ACL' => 'public-read',
                    'headers' => [
                        'Content-Type' => $request->image->getMimeType(),
                        'Content-Disposition' => 'attachment',
                    ],
                ],
            );
            $file_address = 'https://rvm.nyc3.digitaloceanspaces.com/RVM/'.$fileName;

            // $request->image->move(storage_path('images'), $fileName);
            $user->user_image = $fileName;
            $user->user_image_path = $file_address;
        }
        if (isset($request->email)) {
            $user->email = $request->email;
        }

        UserSetting::updateOrCreate(
            [
                'key' => 'daily_max_limit',
                'user_id' => $user->id,
                'company_id' => $user->company_id,
            ],
            [
                'value' => (isset($request->isDailyLimit) && $request->isDailyLimit) ? $request->dailyLimit : 0,
                'key_label' => 'Daily Max Limit',
                'key_description' => 'Daily Limit',
            ]
        );
        if (isset($request->apiKey) && $request->apiKey) {
            UserSetting::updateOrCreate(
                [
                    'key' => 'api_key',
                    'user_id' => $user->id,
                    'company_id' => $user->company_id,
                ],
                [
                    'value' => $request->apiKey,
                    'key_label' => 'Api Key',
                    'key_description' => 'Api Key',
                ]
            );
        }
        if (isset($request->apiPassword) && $request->apiPassword) {
            UserSetting::updateOrCreate(
                [
                    'key' => 'api_password',
                    'user_id' => $user->id,
                    'company_id' => $user->company_id,
                ],
                [
                    'value' => $request->apiPassword,
                    'key_label' => 'Api Password',
                    'key_description' => 'Api Password',
                ]
            );
        }
        if (isset($request->email) || isset($request->image)) {
            $user->save();
        }

        return response()->json(
            ['message' => 'Settings Updated Successfully.', 'status' => true],
            200
        );
    }

    public function updatePassword(Request $request)
    {
        $user = Nova::user($request);
        $request->validate(
            [
                'password' => ['required', 'string', 'min:8', 'confirmed'],
                'oldpassword' => ['required',
                function ($attribute, $value, $fail) use ($user) {
                    if (!Hash::check($value, $user->password)) {
                        $fail('The '.$attribute.' is Invalid.');
                    }
                },
            ],
            ]
        );

        $user->password = Hash::make($request->password);
        $user->save();

        return response()->json(
            ['message' => 'Settings Updated Successfully.', 'status' => true],
            200
        );
    }
}
