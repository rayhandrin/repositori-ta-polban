<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class MahasiswaAktif extends Authenticatable implements MustVerifyEmail
{
    use HasFactory, Notifiable, HasApiTokens;

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

    /**
     * Indicates if the model's ID is auto-incrementing.
     *
     * @var bool
     */
    public $incrementing = false;

    /**
     * The attributes that aren't mass assignable.
     *
     * @var array
     */
    protected $guarded = [];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = ['password', 'email_verified_at', 'created_at', 'updated_at'];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    /**
     * Many-to-many relationship dengan admin.
     */
    public function admin()
    {
        return $this->belongsToMany(Admin::class, 'mahasiswa_aktif_has_admin', 'mahasiswa_aktif_nim', 'admin_id_admin');
    }

    /**
     * Many-to-many relationship dengan dokumenTA.
     */
    public function dokumenTA()
    {
        return $this->belongsToMany(DokumenTA::class, 'mahasiswa_aktif_has_dokumen_ta', 'mahasiswa_aktif_nim', 'dokumen_ta_id_dokumen');
    }
}
