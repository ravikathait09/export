<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    use HasFactory;

    protected $fillable = ['amount', 'description', 'user_id'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function searchQuery($data)
    {
        $model =  $this->query()->with(['user']);
        $start_date = (isset($this->request['start_date']) && !empty($this->request['start_date']))?$this->request['start_date']:'';
       
        $end_date = (isset($this->request['end_date']) && !empty($this->request['end_date']))?$this->request['end_date']:'';
        if(!empty($start_date)){
            $model=  $model->where('created_at','>=',$start_date);
        }
        if(!empty($end_date)){
            $model=  $model->where('created_at','<=',$end_date);
        }
        return $model;

    }
}
