<?php

namespace App\Models;

use CodeIgniter\Model;

class Modelakun extends Model
{
    protected $table = 'akun';
    protected $primaryKey = 'username';
    protected $allowedFields = [
    'username','password','email','no_telp','birth_date'
    ];
}
