<?php

namespace App\Http\Livewire;
use App\Jobs\Allrecord ;
use Livewire\Component;
use Illuminate\Support\Facades\Bus;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Request;
use Livewire\WithPagination;
use App\Models\Transaction as TransactionModel;

class Transaction extends Component
{
    use WithPagination;
   
    public $batchId;
    public $exporting = false;
    public $exportFinished = false;
    public $filename ;
    public $module;
    public $start_date;
    public $end_date;
    public $file;
    public $max;
    public $request;
    protected $export ;
    //public $name;
    public $transactionModel;
    public $searchpin;
    public $searchdesc;
    protected $paginationTheme = 'bootstrap';


    

    public function transaction($file)
    {
        $transactionModel = new TransactionModel();
        $this->exporting = true;
        $this->exportFinished = false;
        $this->filename = time().'.xlsx';
        $data['start_date']=$this->start_date;
        $data['end_date']=$this->end_date;
        $data['searchpin']=$this->searchpin;
        $data['searchdesc']=$this->searchdesc;
        //public $searchpin;
       
        $total =$transactionModel->searchQuery($data)->count();
        $chunksize =5000;
        for($i=0; $i<$total; )
        {
            $batches[]=  new Allrecord($this->filename,$data,$i,$chunksize);
            $i+=$chunksize; 
        }

      
        $filename = $this->filename;
        $batch = Bus::batch($batches)->name('Export Users')
        ->then(function () use ($filename) {
            $file = storage_path( $filename);  
        })
        ->catch(function () {
        })
        ->finally(function ()  { 

        })->dispatch();
        $this->batchId = $batch->id;
        
    }

    public function getExportBatchProperty()
    {
        if (!$this->batchId) {
            return null;
        }
        return Bus::findBatch($this->batchId);
    }

    public function updatingSearch()
    {
        $this->resetPage();
    }

    

   

    public function downloadExport()
    {
        return Storage::download('public/'.$this->filename);
    }

    public function updateExportProgress()
    {
        $this->exportFinished = $this->exportBatch->finished();
        $exists = Storage::disk('public')->exists($this->filename);
       
        if ($this->exportFinished) {
            if(!$exists)
            {
                $this->exportFinished  =false;
            }else{
                $this->exporting = false;
            }
        }
    }

    

    public function updatingsearchpin(): void
    {
        $this->gotoPage(1);
    }

    public function updatingsearchdesc(): void
    {
        $this->gotoPage(1);
    }

    public function updatingstart_date(): void
    {
        $this->gotoPage(1);
    }

    public function updatingend_date(): void
    {
        $this->gotoPage(1);
    }
    
    public function render()
    {
        if($this->end_date){
            $this->max = $this->end_date;
        }else{
            $this->max = date('Y-m-d');
        }
        $transactionModel = new TransactionModel();
        $data['start_date']=$this->start_date;
        $data['end_date']=$this->end_date;
        $data['searchpin']=$this->searchpin;
        $data['searchdesc']=$this->searchdesc;

        $transactions =  $transactionModel->searchQuery($data)->paginate(30);
        return view('livewire.transaction',compact('transactions'));
    }
}
