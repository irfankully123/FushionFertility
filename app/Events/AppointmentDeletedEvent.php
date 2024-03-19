<?php

namespace App\Events;

use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;
use JetBrains\PhpStorm\ArrayShape;

class AppointmentDeletedEvent implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public int $appointment_id;

    public int $id;

    public function __construct(int $appointment, int $id)
    {
        $this->appointment_id = $appointment;
        $this->id = $id;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return PrivateChannel
     */
    public function broadcastOn(): PrivateChannel
    {
        return new PrivateChannel('doctor.appointments.deletes.' . $this->id);
    }

    public function broadcastAs(): string
    {
        return 'appointment-destroyed';
    }

    #[ArrayShape(['message' => "string", 'appointment_id' => "int", 'id' => "int"])]
    public function broadcastWith(): array
    {
        return [
            'message' => 'The appointment has been deleted successfully.',
            'appointment_id' => $this->appointment_id,
            'id' => $this->id,
        ];
    }

}
