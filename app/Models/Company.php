<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Company extends Model
{
    use HasFactory;

    public $timestamps = false;

    protected $primaryKey = 'companyId';

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'companyFoundationDate' => 'datetime:Y.m.d',
        'date' => 'datetime:Y.m.d H:i:s',
    ];

    public $fillable = ['companyName', 'companyRegistrationNumber', 'companyFoundationDate', 'country', 'zipCode', 'city', 'streetAddress', 'latitude', 'longitude', 'companyOwner', 'employees', 'activity', 'active', 'email', 'password'];
    public $visible = ['companyId', 'companyName', 'companyRegistrationNumber', 'companyFoundationDate', 'country', 'zipCode', 'city', 'streetAddress', 'latitude', 'longitude', 'companyOwner', 'employees', 'activity', 'active', 'email', 'date'];

    protected function companyNames(): Attribute
    {
        return Attribute::make(
            get: fn ($value) => explode('|', $value),
        );
    }
}
