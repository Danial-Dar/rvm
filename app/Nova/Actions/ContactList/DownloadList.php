<?php

namespace App\Nova\Actions\ContactList;

use App\Exports\ContactListExport;
use Aws\S3\S3Client;
use App\Models\ContactList;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Collection;
use Laravel\Nova\Actions\Action;
use Laravel\Nova\Fields\ActionFields;
use Laravel\Nova\Http\Requests\NovaRequest;
use Maatwebsite\Excel\Facades\Excel;

class DownloadList extends Action
{
    use InteractsWithQueue, Queueable;

    /**
     * Perform the action on the given models.
     *
     * @param  \Laravel\Nova\Fields\ActionFields  $fields
     * @param  \Illuminate\Support\Collection  $models
     * @return mixed
     */
    public function handle(ActionFields $fields, Collection $models)
    {
        if ($models->count() > 1) {
            return Action::danger('Please run this on only one user resource.');
        }

        $filename = $models->first()->path;
        Excel::store(new ContactListExport($models->first()->id), 'contact-lists/'.$filename);
//        return Excel::download(new ContactListExport($models->first()->id), 'contact_list.csv');
        $file = storage_path('app/contact-lists/'.$filename);
        $SPACES_KEY  = 'LXN3CWYQSMF7BNLWMOL4';
        $SPACES_SECRET = 'EQgbUayx5GvwNRRRbwYLH6p1KFjXLuBuWcqKv4DjYe4';

        $client = new S3Client([
            'version' => 'latest',
            'region'  => 'nyc3',
            'endpoint' => 'https://rvm.nyc3.digitaloceanspaces.com',
            'credentials' => [
                'key'    => $SPACES_KEY,
                'secret' => $SPACES_SECRET,
            ],

        ]);

        $client->putObject([
            'Bucket' => 'RVM',
            'Key'    => $filename,
            'Body'   => file_get_contents($file),
            'ACL'    => 'public-read',
            'headers' => [
                'Content-Type' => 'text/csv',
                'Content-Disposition' => 'attachment'
            ],
        ],
        );
        $path = 'https://rvm.nyc3.digitaloceanspaces.com/RVM/'.$filename;

        return Action::download($path,'contact_list.csv');
    }

    /**
     * Get the fields available on the action.
     *
     * @param  \Laravel\Nova\Http\Requests\NovaRequest  $request
     * @return array
     */
    public function fields(NovaRequest $request)
    {
        return [];
    }
}
