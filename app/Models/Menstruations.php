<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Menstruation extends Model
{
    use HasFactory;

    /**
     * Kolom yang bisa diisi (mass assignable)
     */
    protected $fillable = [
        'user_id',
        'start_date',
        'end_date'
    ];

    /**
     * Format tanggal yang akan digunakan
     */
    protected $casts = [
        'start_date' => 'date:Y-m-d',
        'end_date' => 'date:Y-m-d',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    /**
     * Relasi ke model User
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Scope untuk data user tertentu
     */
    public function scopeForUser($query, $userId)
    {
        return $query->where('user_id', $userId);
    }

    /**
     * Scope untuk data dalam rentang waktu
     */
    public function scopeDateRange($query, $start, $end)
    {
        return $query->whereBetween('start_date', [$start, $end]);
    }
}