<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TugasAkhir extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'tugas_akhir';

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
    protected $fillable = ['id', 'judul', 'tahun', 'kata_kunci', 'kontributor_1', 'kontributor_2', 'kontributor_3', 'filepath', 'staf_perpus_pengunggah'];

    // * Relationship methods.

    public function mahasiswa()
    {
        return $this->hasMany(Mahasiswa::class);
    }

    public function hakAkses()
    {
        return $this->hasMany(HakAkses::class);
    }

    public function pengajuan()
    {
        return $this->hasOne(Pengajuan::class);
    }
}
