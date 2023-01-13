<?php

namespace App\Http\Livewire;
use App\Jobs\Allrecord ;
use Livewire\Component;
use Illuminate\Support\Facades\Bus;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Request;

class Transaction extends Component
{
   
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

    

    public function transaction($file)
    {
        $this->exporting = true;
        $this->exportFinished = false;
        $this->filename = time().'.csv';
        $data['start_date']=$this->start_date;
        $data['end_date']=$this->end_date;
       
        
        $batch = Bus::batch([
            new Allrecord($this->filename,$data),
        ])->dispatch();
         
        $this->batchId = $batch->id;
    }

    public function getExportBatchProperty()
    {
        if (!$this->batchId) {
            return null;
        }
        return Bus::findBatch($this->batchId);
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

    public function boot(Request $requst)
    {
       
    }
    
    public function render()
    {
        if($this->end_date){
            $this->max = $this->end_date;
        }else{
            $this->max = date('Y-m-d');
        }
        return view('livewire.transaction');
    }
}
