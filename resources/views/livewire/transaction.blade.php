

<div class="card-body">
    <div class="mb-4 d-flex justify-content-between">
        <div class="me-1 ">
                <form class="d-flex align-items-center" method="post" wire:submit.prevent="transaction('<?php echo time().'.csv' ?>')">
                <input id ="start_date_from" type="date" class="form-control me-2" wire:model="start_date"   placeholder="Enter start Date"   max='{{ $this->max }}'/>
                
                
                <input id ="end_date_from" type="date" class="form-control me-2" wire:model="end_date" placeholder="Enter End Date" min='{{ $this->start_date }}' max="<?php echo date('Y-m-d') ?>"/>
                
                <input type="hidden" value ='dfad' wire:model="file" />
                <input id ="searchpin" type="text" class="form-control me-2" wire:model="searchpin"   placeholder="enter pincode"  />
                <input id ="searchdesc" type="text" class="form-control me-2" wire:model="searchdesc"   placeholder="Enter Description"  />
                
                <button type="submit"  class="btn btn-outline-primary" style="white-space: nowrap;">Export Report</button>
                </form>
            
                @if($exporting && !$exportFinished)
                    <div class="d-inline" wire:poll="updateExportProgress">Exporting...please wait.</div>
                @endif

                @if($exportFinished)
                    Done. Download file <a class="" wire:click="downloadExport">here</a>
                @endif
        </div>
    </div>
    <table class="table">
        <thead>
            <tr>
                <th>ID</th>
                <th>Description</th>
                <th>Amount</th>
                
                <th>Name</th>
                <th>Phone</th>
                <th>Address</th>
                <th>City</th>
                
                <th>Zip code</th>
                
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
                    <td>{{ $transaction->phone }}</td>
                    <td>{{ $transaction->address }}</td>
                    <td>{{ $transaction->city }}</td>
                    <td>{{ $transaction->pincode }}</td>
                    
                    
                    <td>{{ $transaction->created_at }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
    {{ $transactions->links() }}
    
</div>
              