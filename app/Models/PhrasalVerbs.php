<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PhrasalVerbs extends Model
{
    use HasFactory;
    protected $table = "phrasal_verbs";
    protected $fillable = ["word", "traduction", "derivatives", "examples", "synonyms", "date_create", "learned", "date_learned", "date_revision", "important", "order"];
    public $timestamps = false;
}
