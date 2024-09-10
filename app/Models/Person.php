<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Person extends Model
{
    // use HasFactory;

    protected $table = 'persons';
    protected $primaryKey = 'id';
    protected $keyType = 'int';
    public $incrementing = true;
    public $timestamps = true;
    protected $casts = [
        'created_at' => 'datetime',
        "updated_at" => 'datetime',
    ];

    protected function fullName(): Attribute
    {
        return Attribute::make(
            get: function (): string {
                return "$this->first_name $this->last_name";
            },
            set: function (string $value): array {
                $names = explode(' ', $value);
                return [
                    'first_name' => $names[0],
                    "last_name" => $names[1] ?? '',
                ];
            }
        );
    }

    protected function firstNameUpper(): Attribute // function dipanggil dengan deklarasi attribut first_name_upper 
    {
        return Attribute::make(
            get: function ($value, $attributes): string {
                return strtoupper($value);
            },
            set: function (string $value): array {
                return [
                    'first_name' => strtoupper($value),
                ];
            }
        );
    }

    protected function lastNameUpper(): Attribute // function dipanggil dengan deklarasi attribut last_name_upper 
    {
        return Attribute::make(
            get: function ($value, $attributes): string {
                return strtoupper($value);
            },
            set: function (string $value): array {
                return [
                    'last_name' => strtoupper($value),
                ];
            }
        );
    }
}
