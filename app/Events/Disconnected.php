<?php

namespace App\Events;

use App\Models\Agent;
use App\Models\PredictiveAgent;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class Disconnected implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;
    protected $agent_id;
    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct($agent_id)
    {
        $this->agent_id = $agent_id;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\Channel|array
     */
    public function broadcastOn()
    {
        return new Channel('call-status');
    }

    public function broadcastWith() {
        $agent = PredictiveAgent::find($this->agent_id);
        $agent->status = 'disconnected';
        $agent->save();
        return [
            'agent' => $agent,
            'message' => 'disconnected'
        ];
    }
}
