@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">{{ __('Dashboard') }}</div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    <div class="mb-4 d-flex justify-content-between">
                        @livewire('transaction', ['module' => 'ExportStudent'])
                        
                    </div>


                    <table class="table">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Description</th>
                                <th>Amount</th>
                                <th>User</th>
                                <th>Created At</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($transactions as $transaction)
                                <tr>
                                    <td>{{ $transaction->id }}</td>
                                    <td>{{ $transaction->description }}</td>
                                    <td>{{ number_format($transaction->amount / 100, 2) }}</td>
                                    <td>{{ $transaction->user->name }}</td>
                                    <td>{{ $transaction->created_at }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>

                    {{ $transactions->links() }}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection