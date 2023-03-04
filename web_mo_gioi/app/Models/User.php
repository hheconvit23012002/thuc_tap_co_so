<?php

namespace App\Models;

use App\Enums\UserRoleEnum;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Auth\Authenticatable;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class User extends Model implements AuthenticatableContract
{
    use HasFactory;
    use Authenticatable;
    use SoftDeletes;
    protected $fillable = [
        'email',
        'name',
        'avatar',
        'password',
    ];


    public function company():BelongsTo
    {
        return $this->belongsTo(Company::class);
    }
    public function getRoleNameAttribute(){
        return UserRoleEnum::getKeys($this->role)[0];
    }
    public function getGenderNameAttribute(){
        return $this->gender ==0 ? "Male" : "Female";
    }
}
