<?php

namespace App\Nova\Actions\CallerIdContactList;

use Aws\S3\S3Client;
use Illuminate\Bus\Queueable;
use Laravel\Nova\Actions\Action;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Facades\Excel;
use Laravel\Nova\Fields\ActionFields;
use Illuminate\Queue\InteractsWithQueue;
use Laravel\Nova\Http\Requests\NovaRequest;
use App\Exports\CalleridContactExportByGivenPayroll;

class CallerIdDownloadList extends Action
{
    use InteractsWithQueue;
    use Queueable;

    /**
     * Perform the action on the given models.
     *
     * @return mixed
     */
    public function handle(ActionFields $fields, Collection $models)
    {
        // dd($fields,$models);
        if ($models->count()<1) {
            return Action::danger('Please run this on atleast one Selected Row.');
        }

        $filename = 'callerid_contacts.csv';

        Excel::store(new CalleridContactExportByGivenPayroll(
            $models
        ), 'callerid-contact-lists/'.$filename);

        //return Excel::download(new SmsContactListExport($models->first()->id), 'contact_list.csv');
        $file = storage_path('app/callerid-contact-lists/'.$filename);
        $SPACES_KEY = 'LXN3CWYQSMF7BNLWMOL4';
        $SPACES_SECRET = 'EQgbUayx5GvwNRRRbwYLH6p1KFjXLuBuWcqKv4DjYe4';

        $client = new S3Client([
            'version' => 'latest',
            'region' => 'nyc3',
            'endpoint' => 'https://rvm.nyc3.digitaloceanspaces.com',
            'credentials' => [
                'key' => $SPACES_KEY,
                'secret' => $SPACES_SECRET,
            ],
        ]);

        $client->putObject(
            [
            'Bucket' => 'RVM',
            'Key' => $filename,
            'Body' => file_get_contents($file),
            'ACL' => 'public-read',
            'headers' => [
                'Content-Type' => 'text/csv',
                'Content-Disposition' => 'attachment',
            ],
        ],
        );
        $path = 'https://rvm.nyc3.digitaloceanspaces.com/RVM/'.$filename;

        return Action::download($path, 'callerid_contact_list.csv');
    }

    /**
     * Get the fields available on the action.
     *
     * @return array
     */
    public function fields(NovaRequest $request)
    {
        return [];
    }
}
