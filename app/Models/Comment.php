<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphTo;

class Comment extends Model
{
    protected $table = 'comments';
    protected $primaryKey = "id";
    protected $keyType = "int";
    public $incrementing = true;
    public $timestamps = true; // default-nya adalah true

    protected $attributes = [
        'title' => 'Sample Title Default Value',
        'comment' => 'Sample Comment Default Value'
    ];

    public function commentable(): MorphTo
    {
        return $this->morphTo();
    }
}
