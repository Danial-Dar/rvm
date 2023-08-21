<?php

namespace App\Observers;

use App\Models\SmsBannedWord;
use App\Models\User;
use Laravel\Nova\Notifications\NovaNotification;

class SmsBannedWordObserver
{
    /**
     * Handle the SmsBannedWord "created" event.
     *
     * @param  \App\Models\SmsBannedWord  $smsBannedWord
     * @return void
     */
    public function created(SmsBannedWord  $smsBannedWord)
    {
        // foreach(SmsBannedWord::all() as $sbw){
        //     $sbw->notify(NovaNotification::make()
        //         ->message('New Banned Word')
        //         ->icon('ban')
        //         ->type('success'));
        // }
        $this->getNovaNotification($smsBannedWord, 'New Banned Word', 'success');

    }

    /**
     * Handle the SmsBannedWord "updated" event.
     *
     * @param  \App\Models\SmsBannedWord  $smsBannedWord
     * @return void
     */
    public function updated(SmsBannedWord $smsBannedWord)
    {
        $this->getNovaNotification($smsBannedWord, 'Updated Banned Word', 'info');
    }

    /**
     * Handle the SmsBannedWord "deleted" event.
     *
     * @param  \App\Models\SmsBannedWord  $smsBannedWord
     * @return void
     */
    public function deleted(SmsBannedWord $smsBannedWord)
    {
        $this->getNovaNotification($smsBannedWord, 'Deleted Banned Word', 'error');
    }

    /**
     * Handle the SmsBannedWord "restored" event.
     *
     * @param  \App\Models\SmsBannedWord  $smsBannedWord
     * @return void
     */
    public function restored(SmsBannedWord $smsBannedWord)
    {
        $this->getNovaNotification($smsBannedWord, 'Restored Banned Word', 'success');
    }

    /**
     * Handle the SmsBannedWord "force deleted" event.
     *
     * @param  \App\Models\SmsBannedWord  $smsBannedWord
     * @return void
     */
    public function forceDeleted(SmsBannedWord $smsBannedWord)
    {
        $this->getNovaNotification($smsBannedWord, 'Force Deleted Banned Word', 'error');
    }

    private function getNovaNotification($smsBannedWord, $message, $type){
        foreach(SmsBannedWord::all() as $sbw){
            $sbw->notify(NovaNotification::make()
                ->message($message)
                ->icon('ban')
                ->type($type));
        }
    }
}
