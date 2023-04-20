<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HakAkses extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'hak_akses';

    /**
     * The primary key associated with the table.
     *
     * @var string
     */
    protected $primaryKey = 'id';

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
    protected $fillable = ['id', 'diminta_pada', 'status_disetujui', 'akhir_peminjaman', 'hak_aksescol', 'mahasiswa_nim', 'tugas_akhir_id', 'admin_username'];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'diminta_pada' => 'datetime',
        'status_disetujui' => 'boolean',
        'akhir_peminjaman' => 'datetime',
    ];

    // * Relationship methods.

    public function admin()
    {
        return $this->belongsTo(Admin::class);
    }

    public function tugasAkhir()
    {
        return $this->belongsTo(TugasAkhir::class);
    }

    public function mahasiswa()
    {
        return $this->belongsTo(Mahasiswa::class);
    }
}
