<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Course extends Model
{
    /** @use HasFactory<\Database\Factories\CourseFactory> */
    use HasFactory;

    /**
     * The path to the image.
     *
     * @var string
     */
    const IMAGE_PATH = 'courses';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'description',
        'mentor_id',
        'image',
        'start_date',
        'end_date',
        'quota',
        'price',
        'status',
    ];

    /**
     * Get the mentor of the course.
     * 
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function mentor(): BelongsTo
    {
        return $this->belongsTo(User::class, 'mentor_id', 'id');
    }   

    /**
     * Get the bookings for the course.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function bookings(): HasMany
    {
        return $this->hasMany(CourseBooking::class, 'course_id');
    }
}
