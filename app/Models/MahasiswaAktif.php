<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MahasiswaAktif extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'mahasiswa_aktif';

    /**
     * The primary key associated with the table.
     *
     * @var string
     */
    protected $primaryKey = 'nim';

    public function admin()
    {
        return $this->belongsToMany(Admin::class, 'mahasiswa_aktif_has_admin', 'mahasiswa_aktif_nim', 'admin_id_admin');
    }

    public function dokumenTA()
    {
        return $this->belongsToMany(DokumenTA::class, 'mahasiswa_aktif_has_dokumen_ta', 'mahasiswa_aktif_nim', 'dokumen_ta_id_dokumen');
    }
}
