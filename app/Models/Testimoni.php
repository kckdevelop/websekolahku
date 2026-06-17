<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class Testimoni extends Model
{
    use HasFactory;

    protected $table = 'testimonis';

    protected $fillable = [
        'nama',
        'alumni_tahun',
        'pekerjaan',
        'kutipan',
        'foto',
    ];

    /**
     * Accessor: URL foto testimoni alumni.
     */
    public function getFotoSrcAttribute(): string
    {
        if ($this->foto && Storage::disk('public')->exists($this->foto)) {
            return Storage::url($this->foto);
        }
        return 'https://ui-avatars.com/api/?name=' . urlencode($this->nama) . '&size=100&background=f97316&color=fff';
    }
}

