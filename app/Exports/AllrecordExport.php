<?php

namespace App\Exports;

use App\Models\Transaction;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\Exportable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithChunkReading;

class AllrecordExport implements WithMapping,FromQuery,ShouldQueue,WithHeadings,WithChunkReading
{
    /**
    * @return \Illuminate\Support\Collection
    */
    use Exportable;
    
    public function __construct($request)
    {
        $this->request = $request;
    }
    
    public function query()
    {
        $model = new Transaction;
        $model = $model->query()->with(['user']);
        $start_date = (isset($this->request['start_date']) && !empty($this->request['start_date']))?$this->request['start_date']:date('Y-m-d');
       
        $end_date = (isset($this->request['end_date']) && !empty($this->request['end_date']))?$this->request['end_date']:'';
        if(!empty($start_date)){
            $model=  $model->where('created_at','>=',$start_date);
        }
        if(!empty($end_date)){
            $model=  $model->where('created_at','<=',$end_date);
        }
        return $model;
    }

    public function headings(): array
    {
        return [
            '#',
            'Description',
            'Amount',
            'User',
            'phone',
            'address',
            'city',
            'pincode',
            'Created At'
        ];
    }

    public function map($transaction): array
    {
        return [
            $transaction->id,
            $transaction->description,
            $transaction->amount,
            $transaction->user->name,
            $transaction->user->phone,
            $transaction->user->address,
            $transaction->user->city,
            $transaction->user->pincode,
            $transaction->created_at
        ];
    }

    public function fields(): array
    {
        return [
            'id',
            'description',
            'amount',
            'user',
            'phone',
            'address',
            'city',
            'pincode',
            'created_at'
        ];
    }

    public function chunkSize(): int
    {
        return 2000;
    }
}
