<?php

namespace App\Models;

use App\Traits\CanSaveFile;
use App\Traits\HasOriginalAttributes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class Gallery extends Model
{
    use HasFactory, HasOriginalAttributes, CanSaveFile {
        CanSaveFile::saveFile as saveFileTrait;
    }

    protected $fillable = ['image'];

    public function getImageUrlAttribute()
    {
        if (file_exists(storage_path("app/{$this->fullPath()}/{$this->image}"))) {
            return asset("storage/galleries/{$this->image}");
        }

        return "https://placehold.co/600x400";
    }

    /**
     * Return the full path where the file will be saved
     *
     * @return string
     */
    public function fullPath()
    {
        return $this->options['root_folder'] . '/galleries';
    }

    /**
     * Delete file from storage
     *
     * @param string $name
     * @return void
     */
    public function deleteFile($name)
    {
        Storage::delete("{$this->fullPath()}/{$name}");
    }
}
