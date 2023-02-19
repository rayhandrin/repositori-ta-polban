<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DokumenTA extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'dokumen_ta';

    /**
     * The primary key associated with the table.
     *
     * @var string
     */
    protected $primaryKey = 'id_dokumen';

    public function admin()
    {
        return $this->belongsToMany(Admin::class, 'admin_has_dokumen_ta', 'dokumen_ta_id_dokumen', 'admin_id_admin');
    }

    public function mahasiswaAktif()
    {
        return $this->belongsToMany(MahasiswaAktif::class, 'mahasiswa_aktif_has_dokumen_ta', 'dokumen_ta_id_dokumen', 'mahasiswa_aktif_nim');
    }

    public function kataKunci()
    {
        return $this->belongsToMany(KataKunci::class, 'kata_kunci_has_dokumen_ta', 'dokumen_ta_id_dokumen', 'kata_kunci_id_kata_kunci');
    }

    public function files()
    {
        return $this->hasMany(Files::class, 'dokumen_ta_id_dokumen', 'id_dokumen');
    }

    public function mahasiswaAlumni()
    {
        return $this->hasMany(MahasiswaAlumni::class, 'dokumen_ta_id_dokumen', 'id_dokumen');
    }
}
