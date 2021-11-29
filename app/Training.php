<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Training extends Model
{
    protected $fillable = ['category_id','name','slug','status','start_date','end_date','pretest_link','posttest_link','task_desc','trainer_name'];

    protected $with = ['category'];

    public function category(){
        return $this->belongsTo(Category::class);
    }
}
