<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ContactInfo extends Model
{
    use HasFactory;
    // Optionally, specify the table name if it's different
    protected $table = 'contact_infos';

    // Fillable fields
    protected $fillable = ['name', 'email', 'message', 'contact_number'];
}
