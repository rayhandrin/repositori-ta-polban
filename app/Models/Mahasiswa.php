<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class Mahasiswa extends Authenticatable implements MustVerifyEmail
{
    use HasFactory, Notifiable, HasApiTokens;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'mahasiswa';

    /**
     * The primary key associated with the table.
     *
     * @var string
     */
    protected $primaryKey = 'nim';

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
    protected $fillable = ['nim', 'nama', 'email', 'email_verified_at', 'password', 'status_aktif', 'tugas_akhir_id', 'program_studi_nomor'];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'status_aktif' => 'boolean',
        'email_verified_at' => 'datetime'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = ['password'];

    /**
     * The model's default values for attributes.
     *
     * @var array
     */
    protected $attributes = [
        'status_aktif' => false,
    ];

    // * Relationship methods.

    public function tugasAkhir()
    {
        return $this->belongsTo(TugasAkhir::class);
    }

    public function programStudi()
    {
        return $this->belongsTo(ProgramStudi::class);
    }

    public function hakAkses()
    {
        return $this->hasMany(HakAkses::class);
    }

    public function pengajuan()
    {
        return $this->hasMany(Pengajuan::class);
    }
}
