<?php

namespace App\Listeners;

use App\Events\ProductDeleted;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Storage;

class DeleteAttachments
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  \App\Events\ProductDeleted  $event
     * @return void
     */
    public function handle(ProductDeleted $event)
    {
        $paths = $event->product->attachments;

        foreach ($paths as $key => $value) {
            if (Storage::disk('public')->exists($value)) {
                Storage::disk('public')->delete($value);
            }
        }
    }
}
