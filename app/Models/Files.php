<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Files extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'files';

    /**
     * The primary key associated with the table.
     *
     * @var string
     */
    protected $primaryKey = 'id_file';

    public function dokumenTA()
    {
        return $this->belongsTo(DokumenTA::class, 'dokumen_ta_id_dokumen', 'id_dokumen');
    }
}
