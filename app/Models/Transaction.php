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
        $start_date = (isset($data['start_date']) && !empty($data['start_date']))?$data['start_date']:'';
       
        $end_date = (isset($data['end_date']) && !empty($data['end_date']))?$data['end_date']:'';
        if(!empty($start_date)){
            $model=  $model->where('created_at','>=',$start_date);
        }
        if(!empty($end_date)){
            $model=  $model->where('created_at','<=',$end_date);
        }

        if(!empty($data['searchpin'])){
            $model=  $model->where('pincode','=',$data['searchpin']);
        }

        if(!empty($data['searchdesc'])){
            $model=  $model->where('description','LIKE',$data['searchdesc'].'%');
        }
        return $model;

    }
}
