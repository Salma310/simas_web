<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AgendaDocument extends Model
{
    use HasFactory;

    protected $table = 'agenda_documents';
    protected $primaryKey = 'document_id';
    protected $fillable = ['agenda_id', 'file_name', 'file_path'];

    public function agenda()
    {
        return $this->belongsTo(Agenda::class);
    }
}
