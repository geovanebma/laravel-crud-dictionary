<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Dictionary extends Model
{
    use HasFactory;
    protected $table = "dictionary";
    protected $fillable = ["word", "traduction", "type", "definitions", "date_create", "date_learned", "date_revision", "learned", "important", "order"];
    public $timestamps = false;
}
