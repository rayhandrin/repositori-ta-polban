<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MahasiswaAlumni extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'mahasiswa_alumni';

    /**
     * The primary key associated with the table.
     *
     * @var string
     */
    protected $primaryKey = 'nim';

    public function admin()
    {
        return $this->belongsToMany(Admin::class, 'admin_has_mahasiswa_alumni', 'mahasiswa_alumni_nim', 'admin_id_admin');
    }

    public function dokumenTA()
    {
        return $this->belongsTo(DokumenTA::class, 'dokumen_ta_id_dokumen', 'id_dokumen');
    }
}
