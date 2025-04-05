<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Musica extends Model
{
    protected $fillable = ['titulo', 'visualizacoes', 'youtube_id', 'thumb', 'status'];
}
