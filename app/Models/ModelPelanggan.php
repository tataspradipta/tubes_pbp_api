<?php

namespace App\Models;

use CodeIgniter\Model;

class ModelPelanggan extends Model
{
    protected $table            = 'pelanggan';
    protected $primaryKey       = 'id';
    protected $allowedFields    = [
        'id', 'username', 'password', 'nama', 'email', 'tanggalLahir', 'noTelp'
    ];
}
