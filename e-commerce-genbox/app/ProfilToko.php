<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ProfilToko extends Model
{
    /**
     * Nama tabel yang digunakan oleh model ini.
     *
     * @var string
     */
    protected $table = 'profil_toko';

    /**
     * Atribut yang dapat diisi massal.
     *
     * @var array
     */
    protected $fillable = [
        'user_id', 'nama', 'nama_toko', 'nomor_telepon', 'jenis_kelamin', 'tanggal_lahir'
    ];

    /**
     * Mendapatkan User yang memiliki ProfilToko ini.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}