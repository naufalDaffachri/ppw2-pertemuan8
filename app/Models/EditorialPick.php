<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EditorialPick extends Model
{
    use HasFactory;
    protected $fillable = ['editorial_pick'];

    public function book()
    {
        return $this->belongsTo(Buku::class);
    }

}
