<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Queue\SerializesModels;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use App\Models\Tesouraria;

class EntradaTesouraria
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    protected $tesouraria;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct(Tesouraria $tesouraria)
    {
        $this->tesouraria = $tesouraria;
    }

    /**
     * Baixa a receber
     *
     * @return \App\Models\Tesouraria  $tesouraria
     */
    public function tesouraria()
    {
        return $this->tesouraria;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\Channel|array
     */
    public function broadcastOn()
    {
        return new PrivateChannel('conta-bancaria');
    }
}
