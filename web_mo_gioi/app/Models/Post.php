<?php

namespace App\Models;

use App\Enums\PostCurrnencySalary;
use App\Enums\PostStatusEnum;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Sluggable\HasSlug;
use Spatie\Sluggable\SlugOptions;
use Cviebrock\EloquentSluggable\Sluggable;

class Post extends Model
{
    use HasFactory;
    use Sluggable;
    protected $fillable =[
        'job_title',
        'company_id',
        'city',
        'status',
    ];

    protected static function booted()
    {
        static::creating(static function($object){
            $object->user_id = 1;
        });
    }

//    public function getSlugOptions() : SlugOptions
//    {
//        return SlugOptions::create()
//            ->generateSlugsFrom('job_title')
//            ->saveSlugsTo('slug');
//    }
    public function getCurrencySalaryCodeAttribute(){
        return PostCurrnencySalary::getKey($this->currency_salary);
    }
    public function getStatusNameAttribute(){
        return PostStatusEnum::getKey($this->status);
    }

    public function sluggable(): array
    {
        return [
            'slug' => [
                'source' => 'job_title'
            ]
        ];
    }
}
