<?php

namespace App\Jobs;

use Illuminate\Bus\Batchable;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use App\Models\Transaction;
use Illuminate\Support\Facades\Storage;

class Allrecord implements ShouldQueue
{
    
    use Batchable,Dispatchable, InteractsWithQueue, Queueable, SerializesModels;
    

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public $filename, $request,$start, $limit; 

    public function __construct($filename,$request=[],$start=0,$end=10000)
    {
        $this->filename = $filename;
        $this->request = $request;
        $this->start = $start;
        $this->limit = $end;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $model = new Transaction;
        $transaction =$model->searchQuery($this->request)  ->skip($this->start)
        ->take($this->limit)->get()
            ->map(function ($transaction) {
                return [
                    $transaction->id,
                    $transaction->description,
                    $transaction->amount,
                    $transaction->user->name,
                    $transaction->phone,
                    $transaction->address,
                    $transaction->city,
                    $transaction->pincode,
                    $transaction->created_at
                ];
            });

        $file = Storage::disk('public')->path($this->filename);
        $open = fopen($file, 'a+');
        if($this->start==0)
        {
            fputcsv($open,  [
                'id',
                'description',
                'amount',
                'user',
                'phone',
                'address',
                'city',
                'pincode',
                'created_at'
            ]);
        }

        foreach ($transaction as $user) {
            fputcsv($open, $user);
        }
        fclose($open);
    }
}
