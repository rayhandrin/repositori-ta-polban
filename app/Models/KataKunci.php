<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KataKunci extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'kata_kunci';

    /**
     * The primary key associated with the table.
     *
     * @var string
     */
    protected $primaryKey = 'id_kata_kunci';

    public function dokumenTA()
    {
        return $this->belongsToMany(DokumenTA::class, 'kata_kunci_has_dokumen_ta', 'kata_kunci_id_kata_kunci', 'dokumen_ta_id_dokumen');
    }
}
