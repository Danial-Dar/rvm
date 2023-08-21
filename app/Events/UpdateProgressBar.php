<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;
use App\Models\CampaignStats;

class UpdateProgressBar implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    protected $campaign;
    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct($campaign_id)
    {
        $this->campaign = \App\Models\Campaign::find($campaign_id);
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\Channel|array
     */
    public function broadcastOn()
    {
        return new Channel('progress-bar');
    }

    public function broadcastWith() {
        $campaign_stat = CampaignStats::where('campaign_id', $this->campaign->id)->first();

        if($this->campaign->status == 'played') {
            return [
                'campaign' => $this->campaign,
                'progress' => number_format((float) ($campaign_stat->initiated_count / ($campaign_stat->contact_count - $campaign_stat->dnc_count)) * 100, 2, '.', '')
            ];
        } else if($this->campaign->status == 'preprocesing') {
            $redis_key_count = RedisKey::where('campaign_id', $this->id)->count();
            $contacts = $campaign_stat->contact_count - $campaign_stat->sent_count - $campaign_stat->dnc_count;
            return [
                'campaign' => $this->campaign,
                'progress' => number_format( (float)$redis_key_count/($contacts/2000) * 100,2,'.','')
            ];
        }
    }
}
