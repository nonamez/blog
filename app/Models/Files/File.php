<?php

namespace App\Models\Files;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class File extends Model
{
    use HasFactory;

    protected $table    = 'files';
    protected $fillable = ['name', 'description'];
    protected $appends  = ['routes'];

    // ========================= Attributes ========================= //

    public function getRoutesAttribute()
    {
        return (object) [
            'preview' => $this->getURL(),

            // 'update' => route('dashboard.files.update', $this->id),
            'delete' => route('dashboard.files.delete', $this->id)
        ];
    }

    // ========================= Relations ========================= //

    public function fileable()
    {
        return $this->morphTo();
    }

    // ========================= Custom Methods ========================= //

    public function getPath($storage = false)
    {
        $path = sprintf('%s/%s/%s/%s', ($storage ? '' : 'app'), ($this->is_private ? 'private' : 'public'), $this->created_at->format('Y/m/d'), $this->name);

        if ($storage) {
            return $path;
        }

        return storage_path($path);
    }

    public function getURL()
    {
        if ($this->is_private) {
            return NULL;
        }

        return sprintf('%s/%s/%s', url('storage'), $this->created_at->format('Y/m/d'), $this->name);
    }
}
