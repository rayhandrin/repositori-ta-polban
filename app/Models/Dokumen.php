<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Dokumen extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'dokumen';

    /**
     * The primary key associated with the table.
     *
     * @var string
     */
    protected $primaryKey = null;

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
    protected $fillable = ['dokumen_1', 'dokumen_2', 'dokumen_3', 'dokumen_4', 'dokumen_opsional_1', 'dokumen_opsional_2', 'tugas_akhir_id'];

    // * Relationship methods.

    public function tugasAkhir()
    {
        return $this->belongsTo(TugasAkhir::class);
    }
}
