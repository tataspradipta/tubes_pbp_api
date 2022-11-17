<?php

namespace App\Models;

use CodeIgniter\Model;

class ModelSalon extends Model
{
    protected $table            = 'salon';
    protected $primaryKey       = 'id';
    protected $allowedFields    = [
        'id', 'nama_salon', 'deskripsi'
    ];

}
