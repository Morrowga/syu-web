<?php

namespace App\Jobs;

use Carbon\Carbon;
use App\Models\User;
use App\Models\Order;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

class OrderExpiration implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $user_id;
    /**
     * Create a new job instance.
     */
    public function __construct($user_id = null)
    {
        $this->user_id = $user_id;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        if($this->user_id === null)
        {
            $orders = Order::where('order_status', 'pending')->get();
        } else {
            $orders = Order::where('order_status', 'pending')->where('user_id', $this->user_id)->get();
        }

        $currentDateTime = Carbon::now();

        foreach ($orders as $order) {
            $expiredDateTime = Carbon::parse($order->order_expired_date);

            if ($expiredDateTime->lte($currentDateTime)) {
                $order->update(['order_status' => 'expired']);
            }
        }
    }
}
