<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;

class JobStudy implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    private $name;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($name)
    {
        //
        $this->name = $name;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        //
        Log::info('Job Study', [
            'name' => $this->name
        ]);
    }
}
