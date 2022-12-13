<?php

namespace App\Models;

use CodeIgniter\Model;

class Modeltempatwisata extends Model
{
    protected $table = 'tempatWisata';
    protected $primaryKey = 'nama';
    protected $allowedFields = [
    'nama','alamat','rating','lat','longi'
    ];
}
