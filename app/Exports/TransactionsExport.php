<?php

namespace App\Exports;

use App\Models\Transaction;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\Exportable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithHeadings;


class TransactionsExport implements FromQuery, WithHeadings, WithMapping
{
    use Exportable;

    public function query()
    {
        return Transaction::query()->with('user');
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
}
