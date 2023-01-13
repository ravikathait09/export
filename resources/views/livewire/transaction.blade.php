<div class="me-1 ">
    <form class="d-flex align-items-center" method="post" wire:submit.prevent="transaction('<?php echo time().'.csv' ?>')">
    <input id ="start_date_from" type="date" class="form-control me-2" wire:model="start_date"   placeholder="Enter start Date"   max='{{ $this->max }}'/>
       
    
       <input id ="end_date_from" type="date" class="form-control me-2" wire:model="end_date" placeholder="Enter End Date" min='{{ $this->start_date }}' max="<?php echo date('Y-m-d') ?>"/>
      
        <input type="hidden" value ='dfad' wire:model="file" />
        <button type="submit"  class="btn btn-outline-primary" style="white-space: nowrap;">Export Report</button>
    </form>
   
    @if($exporting && !$exportFinished)
        <div class="d-inline" wire:poll="updateExportProgress">Exporting...please wait.</div>
    @endif

    @if($exportFinished)
        Done. Download file <a class="" wire:click="downloadExport">here</a>
    @endif
</div>


