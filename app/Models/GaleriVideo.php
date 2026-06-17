<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GaleriVideo extends Model
{
    use HasFactory;

    protected $table = 'galeri_videos';

    protected $fillable = [
        'judul',
        'deskripsi',
        'youtube_id',
        'kategori',
        'tanggal',
        'views',
        'durasi',
    ];

    protected $casts = [
        'tanggal' => 'date',
        'views' => 'integer',
    ];
}
