<?php

namespace App\Jobs;

use Illuminate\Bus\Batchable;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use App\Exports\AllrecordExport;


class Allrecord implements ShouldQueue
{
    
    use Batchable,Dispatchable, InteractsWithQueue, Queueable, SerializesModels;
    

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public $filename, $request; 

    public function __construct($filename,$request=[])
    {
        $this->filename = $filename;
        $this->request = $request;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        (new AllrecordExport($this->request))->store('public/'.$this->filename);
    }
}
