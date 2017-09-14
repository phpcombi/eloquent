<?php

use Combi\{
    Helper as helper,
    Abort as abort,
    Runtime as rt
};

use Illuminate\Database\Eloquent\SoftDeletes;

/**
 *
 *
 * @property int $id
 * @property string $name
 * @property string $pass
 * @property string $email
 * @property string $nickname
 * @property int $gender
 * @property string $birthday
 */
class User extends Combi\Eloquent\Entity
{
    use SoftDeletes;

    protected $table    = 'users';
    protected $dates    = ['deleted_at'];

    protected $fillable = [
        'email',
        'nickname',
        'gender',
        'birthday',
    ];
    protected $casts = [
        'id'        => 'integer',
        'name'      => 'string',
        'pass'      => 'string',
        'email'     => 'string',
        'nickname'  => 'string',
        'gender'    => 'integer',
        'birthday'  => 'datetime',
    ];
}