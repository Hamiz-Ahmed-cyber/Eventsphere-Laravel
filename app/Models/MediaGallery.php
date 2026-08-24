<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MediaGallery extends Model
{
    protected $table = 'media_gallery';
    protected $primaryKey = 'media_id';
    public $timestamps = false;

    protected $fillable = ['event_id', 'file_type', 'file_url', 'uploaded_by', 'caption', 'status', 'uploaded_on'];

    public function event()
    {
        return $this->belongsTo(Event::class, 'event_id');
    }

    public function uploader()
    {
        return $this->belongsTo(User::class, 'uploaded_by');
    }
}
