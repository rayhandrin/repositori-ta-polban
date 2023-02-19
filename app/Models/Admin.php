<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Admin extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'admin';

    /**
     * The primary key associated with the table.
     *
     * @var string
     */
    protected $primaryKey = 'id_admin';

    public function mahasiswaAktif()
    {
        return $this->belongsToMany(MahasiswaAktif::class, 'mahasiswa_aktif_has_admin', 'admin_id_admin', 'mahasiswa_aktif_nim');
    }

    public function dokumenTA()
    {
        return $this->belongsToMany(DokumenTA::class, 'admin_has_dokumen_ta', 'admin_id_admin', 'dokumen_ta_id_dokumen');
    }

    public function mahasiswaAlumni()
    {
        return $this->belongsToMany(MahasiswaAlumni::class, 'admin_has_mahasiswa_alumni', 'admin_id_admin', 'mahasiswa_alumni_nim');
    }
}
