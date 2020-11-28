<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Queue\SerializesModels;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use App\Models\BaixaPagar;

class BaixaLancamentoPagar
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    protected $lancamentoPagar;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct(BaixaPagar $lancamento)
    {
        $this->lancamentoPagar = $lancamento;
    }

    /**
     * Baixa a pagar
     *
     * @return \App\Models\BaixaPagar  $lancamentoPagar
     */
    public function baixaPagar()
    {
        return $this->lancamentoPagar;
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
