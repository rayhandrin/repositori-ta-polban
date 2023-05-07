<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProgramStudi extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'program_studi';

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
    protected $fillable = ['nomor', 'nama', 'kode', 'jurusan', 'diploma'];

    // * Relationship methods.

    public function mahasiswa()
    {
        return $this->hasMany(Mahasiswa::class);
    }
}
