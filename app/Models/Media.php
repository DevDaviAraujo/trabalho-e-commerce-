<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
use App\Models\Content;

class Media extends Model
{

    protected $table = 'medias';
    protected $fillable = [

        'id',
        'file',
        'file_type',
        'width',
        'height',
        'origin_type',
        'origin_id',
        'created_at',
        'updated_at',
        'deleted_at'

    ];

    public function getDir()
    {

        $file_path = $this->origin_type . '/' .  $this->file;

        if (Storage::disk('public')->exists($file_path)) {

           $file_dir = asset('storage/' . $file_path);

           return $file_dir; 
        }
        
        return asset('storage/examples/not_found.avif');

    }

    
    public function deleteDir()
    {

        $file_path = $this->origin_type . '/' .  $this->file;

        if (Storage::disk('public')->exists($file_path)) {

            $file_dir = Storage::disk('public')->delete($file_path);

        }

    }
}
