# Combi Eloquent

Eloquent support for PHP\Combi Framework.

## How to use

1.  Create combi project(if not)

```
composer create-project combi/combi=dev-master myapp
```

2.  Require combi/eloquent

```
composer require combi/eloquent=dev-master
```

3.  Configure database connection

```
mkdir src/config/eloquent/databases.neon
vim src/config/eloquent/databases.neon
```

Enter connection config like this:

```yaml
default:
    driver:     mysql
    host:       127.0.0.1
    port:       3306
    database:   mydb
    username:   root
    password:   123456
    charset:    utf8mb4
    collation:  utf8mb4_general_ci
    prefix:     ''
```

4.  Try to use

```php
use Combi\Eloquent as DB;

foreach (DB::table('users')->get() as $entry) {
    helper::du($entry->toArray());
}
```

5.  Use entity

Declare entity:

```php
use Combi\{
    Helper as helper,
    Abort as abort,
    Core as core
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
```

And use it:

```php
$user = new User();
$user->name     = 'abc'.mt_rand(10000, 99999);
$user->pass     = md5('123123');
$user->email    = $user->name.'@xxx.com';
$user->nickname = $user->name.'-nick';
$user->gender   = mt_rand(1, 2);
$user->birthday = '2017-10-11 '.date('H:i:s');
$user->save();

$user2 = User::query()->where('name', 'somename')->first();
```

## Use Cabin

Cabin is an entry container in a combi action. It will control entry load only once in an action, and will auto save the changes when action is done.

like this:

```php
$user = User::find(2);
$user->name = 'def'.mt_rand(10000, 99999);
// and it will auto save when action done.

for ($i = 0; $i < 1000; $i++) {
    User::find(1);
}
// it will load once by db.
```

If you do not want to use cabin, make entity proporty ```$_cabin_id=null```.

If want disable auto release feature, make config file ```src/config/eloquent/settings.neon``` like:

```yaml
cabin:
    auto_release:
        #-   0   # release default cabin when action done
```