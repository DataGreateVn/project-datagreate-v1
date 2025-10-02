<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Setting extends Model
{
    protected $fillable = ['name', 'val'];
    protected $casts = ['val' => 'json'];

    public function setValAttribute($value): void
    {
        if ($value === null || (is_string($value) && trim($value) === '')) {
            $this->attributes['val'] = null;
            return;
        }
        if (is_string($value)) {
            $trim = trim($value);
            $decoded = json_decode($trim, true);
            if (json_last_error() === JSON_ERROR_NONE) {
                $this->attributes['val'] = json_encode($decoded, JSON_UNESCAPED_UNICODE);
                return;
            }
            $this->attributes['val'] = json_encode($value, JSON_UNESCAPED_UNICODE);
            return;
        }
        $this->attributes['val'] = json_encode($value, JSON_UNESCAPED_UNICODE);
    }
}
