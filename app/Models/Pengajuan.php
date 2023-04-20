<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pengajuan extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'pengajuan';

    /**
     * The primary key associated with the table.
     *
     * @var string
     */
    protected $primaryKey = 'nomor';

    /**
     * Indicates if the model's ID is auto-incrementing.
     *
     * @var bool
     */
    public $incrementing = false;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['nomor', 'status', 'direspon_pada', 'alasan_penolakan', 'mahasiswa_nim', 'admin_username'];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'status' => 'boolean',
        'direspon_pada' => 'datetime'
    ];

    // * Relationship methods.

    public function admin()
    {
        return $this->belongsTo(Admin::class);
    }

    public function mahasiswa()
    {
        return $this->belongsTo(Mahasiswa::class);
    }
}
