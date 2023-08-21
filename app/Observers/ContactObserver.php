<?php

namespace App\Observers;

use App\Models\Contact;
use App\Models\ContactList;

use function PHPUnit\Framework\isNull;

class ContactObserver
{
    /**
     * Handle the Contact "created" event.
     *
     * @param  \App\Models\Contact  $contact
     * @return void
     */
    public function created(Contact $contact)
    {
        $contact_list = ContactList::Where('id', $contact->contact_list_id)->first();
        $contacts_count = Contact::Where('contact_list_id', $contact->contact_list_id)->Where('status', '!=','deleted')->count();
        $contact_list->total_contacts = $contacts_count;
        $success = ($contact_list->success == null) ? 0 : $contact_list->success ;
        $contact_list->success = (int) $success + 1;
        $contact_list->save();
    }

    /**
     * Handle the Contact "updated" event.
     *
     * @param  \App\Models\Contact  $contact
     * @return void
     */
    public function updated(Contact $contact)
    {
        //
    }

    /**
     * Handle the Contact "deleted" event.
     *
     * @param  \App\Models\Contact  $contact
     * @return void
     */
    public function deleted(Contact $contact)
    {
        $contact_list = ContactList::Where('id', $contact->contact_list_id)->first();
        $contacts_count = Contact::Where('contact_list_id', $contact->contact_list_id)->Where('status', '!=','deleted')->count();
        $contact_list->total_contacts = $contacts_count;
        // $success = isNull($contact_list->success) ? 0 : $contact_list->success ;
        if ($contact_list->success == null) {
            if ($contact_list->failed == null) {
                $contact_list->success = $contacts_count;
            }else {
                $contact_list->success = (int) $contacts_count - (int) $contact_list->failed;
            }
        }else {
            $contact_list->success = (int) $contact_list->success - 1 ;
        }
        $contact_list->save();
    }

    /**
     * Handle the Contact "restored" event.
     *
     * @param  \App\Models\Contact  $contact
     * @return void
     */
    public function restored(Contact $contact)
    {
        //
    }

    /**
     * Handle the Contact "force deleted" event.
     *
     * @param  \App\Models\Contact  $contact
     * @return void
     */
    public function forceDeleted(Contact $contact)
    {
        //
    }
}
