<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Banner extends Model
{
    use HasFactory;

    protected $fillable = [
        'id',
        'name',
        'image',
        'active',
        'order',
        'type',
    ];

    public $incrementing = false; // Karena ID tidak auto-increment, kita set false
    protected $keyType = 'string'; // ID menggunakan tipe string

    protected $casts = [
        'active' => 'boolean',
        'order' => 'integer',
    ];
}
