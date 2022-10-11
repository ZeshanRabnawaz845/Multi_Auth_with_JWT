<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\Course as Authenticatable;

class Course extends Model
{
    use HasFactory, Notifiable;

    protected $table = 'courses';
    public $timestamps = true;

    public function teacher()
    {
    return $this->belongsTo(Teacher::class);
    }

    // public function students()
    //  {
    // return $this->belongsToMany(Student::class)
    //     ->withPivot('start_date', 'cancel_date', 'status');
    //   }

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */

    protected $fillable = [

        'teacher_id',
        'course_name',
        'course_title',
        'course_description',
    ];


    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

   
    
}
