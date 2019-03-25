# Laravel 5 Repositories Slim

Laravel 5 Repositories Slim is a trimmed down version of [Anderson Andrade's](https://github.com/andersao) [andersao/l5-repository
](https://github.com/andersao/l5-repository) used to abstract the data layer. Always thought the original package had a little more than what i needed not to mention some its features already come right out of the box with newer versions of Laravel. So everthing is still the same only i've removed `Validator`, `Presenter` and `Transformer`, figured they could be substituted with Laravel's `FormRequest` and `Resource` classes.

[![Latest Stable Version](https://poser.pugx.org/acdevelopers/l5-repository-slim/v/stable)](https://packagist.org/packages/acdevelopers/l5-repository-slim)
[![License](https://poser.pugx.org/acdevelopers/l5-repository-slim/license)](https://packagist.org/packages/acdevelopers/l5-repository-slim)
[![Latest Unstable Version](https://poser.pugx.org/acdevelopers/l5-repository-slim/v/unstable)](https://packagist.org/packages/acdevelopers/l5-repository-slim)

You want to know a little more about the Repository pattern? [Read this great article](http://bit.ly/1IdmRNS).

## Table of Contents

- <a href="#installation">Installation</a>
    - <a href="#composer">Composer</a>
    - <a href="#laravel">Laravel</a>
- <a href="#methods">Methods</a>
    - <a href="#AcDevelopersrepositorycontractsrepositoryinterface">RepositoryInterface</a>
    - <a href="#AcDevelopersrepositorycontractsrepositorycriteriainterface">RepositoryCriteriaInterface</a>
    - <a href="#AcDevelopersrepositorycontractscacheableinterface">CacheableInterface</a>
    - <a href="#AcDevelopersrepositorycontractscriteriainterface">CriteriaInterface</a>
- <a href="#usage">Usage</a>
	- <a href="#create-a-model">Create a Model</a>
	- <a href="#create-a-repository">Create a Repository</a>
	- <a href="#generators">Generators</a>
	- <a href="#use-methods">Use methods</a>
	- <a href="#create-a-criteria">Create a Criteria</a>
	- <a href="#using-the-criteria-in-a-controller">Using the Criteria in a Controller</a>
	- <a href="#using-the-requestcriteria">Using the RequestCriteria</a>
- <a href="#cache">Cache</a>
    - <a href="#cache-usage">Usage</a>
    - <a href="#cache-config">Config</a>
- <a href="#cache">Credits</a>
- <a href="#cache">Licence</a>


## Installation

### Composer

Execute the following command to get the latest version of the package:

```terminal
composer require ac-developers/l5-repository-slim
```

### Laravel

#### >= laravel5.5

ServiceProvider will be attached automatically

#### Other

In your `config/app.php` add `AcDevelopers\Repository\Providers\RepositoryServiceProvider::class` to the end of the `providers` array:

```php
'providers' => [
    ...
    AcDevelopers\Repository\Providers\RepositoryServiceProvider::class,
],
```

If Lumen

```php
$app->register(AcDevelopers\Repository\Providers\LumenRepositoryServiceProvider::class);
```

Publish Configuration

```shell
php artisan vendor:publish --provider "AcDevelopers\Repository\Providers\RepositoryServiceProvider"
```

## Methods

### AcDevelopers\Repository\Contracts\RepositoryInterface

- all($columns = array('*'))
- first($columns = array('*'))
- firstOrNew(array $attributes = [])
- firstOrCreate(array $attributes = [])
- paginate($limit = null, $columns = ['*'])
- find($id, $columns = ['*'])
- findByField($field, $value, $columns = ['*'])
- findWhere(array $where, $columns = ['*'])
- findWhereIn($field, array $where, $columns = [*])
- findWhereNotIn($field, array $where, $columns = [*])
- create(array $attributes)
- update(array $attributes, $id)
- updateOrCreate(array $attributes, array $values = [])
- delete($id)
- deleteWhere(array $where)
- orderBy($column, $direction = 'asc');
- with(array $relations);
- has(string $relation);
- whereHas(string $relation, closure $closure);
- hidden(array $fields);
- visible(array $fields);
- scopeQuery(Closure $scope);
- getFieldsSearchable();
- setPresenter($presenter);
- skipPresenter($status = true);


### AcDevelopers\Repository\Contracts\RepositoryCriteriaInterface

- pushCriteria($criteria)
- popCriteria($criteria)
- getCriteria()
- getByCriteria(CriteriaInterface $criteria)
- skipCriteria($status = true)
- getFieldsSearchable()

### AcDevelopers\Repository\Contracts\CacheableInterface

- setCacheRepository(CacheRepository $repository)
- getCacheRepository()
- getCacheKey($method, $args = null)
- getCacheMinutes()
- skipCache($status = true)

### AcDevelopers\Repository\Contracts\CriteriaInterface

- apply($model, RepositoryInterface $repository);


## Usage

### Create a Model

Create your model normally, but it is important to define the attributes that can be filled from the input form data.

```php
namespace App;

class Post extends Eloquent { // or Ardent, Or any other Model Class

    protected $fillable = [
        'title',
        'author',
        ...
     ];

     ...
}
```

### Create a Repository

```php
namespace App;

use AcDevelopers\Repository\Eloquent\BaseRepository;

class PostRepository extends BaseRepository {

    /**
     * Specify Model class name
     *
     * @return string
     */
    function model()
    {
        return "App\\Post";
    }
}
```

### Generators

Create your repositories easily through the generator.

#### Config

You must first configure the storage location of the repository files. By default is the "app" folder and the namespace "App". Please note that, values in the `paths` array are acutally used as both *namespace* and file paths. Relax though, both foreward and backward slashes are taken care of during generation.

```php
    ...
    'generator'=>[
        'basePath'=>app()->path(),
        'rootNamespace'=>'App\\',
        'paths'=>[
            'models'       => 'Entities',
            'repositories' => 'Repositories',
            'interfaces'   => 'Repositories',
            'controllers'  => 'Http/Controllers',
            'provider'     => 'RepositoryServiceProvider',
            'criteria'     => 'Criteria',
        ]
    ]
```

You may want to save the root of your project folder out of the app and add another namespace, for example

```php
    ...
     'generator'=>[
        'basePath'      => base_path('src/Lorem'),
        'rootNamespace' => 'Lorem\\'
    ]
```

Additionally, you may wish to customize where your generated classes end up being saved.  That can be accomplished by editing the `paths` node to your liking.  For example:

```php
    'generator'=>[
        'basePath'=>app()->path(),
        'rootNamespace'=>'App\\',
        'paths'=>[
            'models'=>'Models',
            'repositories'=>'Repositories\\Eloquent',
            'interfaces'=>'Contracts\\Repositories',
            'controllers'  => 'Http/Controllers',
            'provider'     => 'RepositoryServiceProvider',
            'criteria'     => 'Criteria',
        ]
    ]
```

#### Commands

To generate everything you need for your Model, run this command:

```terminal
php artisan make:entity Post
```

This will create the Controller, the Validator, the Model, the Repository, the Presenter and the Transformer classes.
It will also create a new service provider that will be used to bind the Eloquent Repository with its corresponding Repository Interface.
To load it, just add this to your AppServiceProvider@register method:

```php
    $this->app->register(RepositoryServiceProvider::class);
```

You can also pass the options from the ```repository``` command, since this command is just a wrapper.

To generate a repository for your Post model, use the following command

```terminal
php artisan make:repository Post
```

To generate a repository for your Post model with Blog namespace, use the following command

```terminal
php artisan make:repository "Blog\Post"
```

Added fields that are fillable

```terminal
php artisan make:repository "Blog\Post" --fillable="title,content"
```

To add validations rules directly with your command you need to pass the `--rules` option and create migrations as well:

```terminal
php artisan make:entity Cat --fillable="title:string,content:text" --rules="title=>required|min:2, content=>sometimes|min:10"
```

The command will also create your basic RESTfull controller so just add this line into your `routes.php` file and you will have a basic CRUD:

 ```php
 Route::resource('cats', CatsController::class);
 ```

When running the command, you will be creating the "Entities" folder and "Repositories" inside the folder that you set as the default.

Done, done that just now you do bind its interface for your real repository, for example in your own Repositories Service Provider.

```php
App::bind('{YOUR_NAMESPACE}Repositories\PostRepository', '{YOUR_NAMESPACE}Repositories\PostRepositoryEloquent');
```

And use

```php
public function __construct({YOUR_NAMESPACE}Repositories\PostRepository $repository){
    $this->repository = $repository;
}
```

Alternatively, you could use the artisan command to do the binding for you.

```php
php artisan make:bindings Cats
```

### Use methods

```php
namespace App\Http\Controllers;

use App\PostRepository;

class PostsController extends BaseController {

    /**
     * @var PostRepository
     */
    protected $repository;

    public function __construct(PostRepository $repository){
        $this->repository = $repository;
    }

    ....
}
```

Find all results in Repository

```php
$posts = $this->repository->all();
```

Find all results in Repository with pagination

```php
$posts = $this->repository->paginate($limit = null, $columns = ['*']);
```

Find by result by id

```php
$post = $this->repository->find($id);
```

Hiding attributes of the model

```php
$post = $this->repository->hidden(['country_id'])->find($id);
```

Showing only specific attributes of the model

```php
$post = $this->repository->visible(['id', 'state_id'])->find($id);
```

Loading the Model relationships

```php
$post = $this->repository->with(['state'])->find($id);
```

Find by result by field name

```php
$posts = $this->repository->findByField('country_id','15');
```

Find by result by multiple fields

```php
$posts = $this->repository->findWhere([
    //Default Condition =
    'state_id'=>'10',
    'country_id'=>'15',
    //Custom Condition
    ['columnName','>','10']
]);
```

Find by result by multiple values in one field

```php
$posts = $this->repository->findWhereIn('id', [1,2,3,4,5]);
```

Find by result by excluding multiple values in one field

```php
$posts = $this->repository->findWhereNotIn('id', [6,7,8,9,10]);
```

Find all using custom scope

```php
$posts = $this->repository->scopeQuery(function($query){
    return $query->orderBy('sort_order','asc');
})->all();
```

Create new entry in Repository

```php
$post = $this->repository->create( Input::all() );
```

Update entry in Repository

```php
$post = $this->repository->update( Input::all(), $id );
```

Delete entry in Repository

```php
$this->repository->delete($id)
```

Delete entry in Repository by multiple fields

```php
$this->repository->deleteWhere([
    //Default Condition =
    'state_id'=>'10',
    'country_id'=>'15',
])
```

### Create a Criteria

#### Using the command

```terminal
php artisan make:criteria My
```

Criteria are a way to change the repository of the query by applying specific conditions according to your needs. You can add multiple Criteria in your repository.

```php

use AcDevelopers\Repository\Contracts\RepositoryInterface;
use AcDevelopers\Repository\Contracts\CriteriaInterface;

class MyCriteria implements CriteriaInterface {

    public function apply($model, RepositoryInterface $repository)
    {
        $model = $model->where('user_id','=', Auth::user()->id );
        return $model;
    }
}
```

### Using the Criteria in a Controller

```php

namespace App\Http\Controllers;

use App\PostRepository;

class PostsController extends BaseController {

    /**
     * @var PostRepository
     */
    protected $repository;

    public function __construct(PostRepository $repository){
        $this->repository = $repository;
    }


    public function index()
    {
        $this->repository->pushCriteria(new MyCriteria1());
        $this->repository->pushCriteria(MyCriteria2::class);
        $posts = $this->repository->all();
		...
    }

}
```

Getting results from Criteria

```php
$posts = $this->repository->getByCriteria(new MyCriteria());
```

Setting the default Criteria in Repository

```php
use AcDevelopers\Repository\Eloquent\BaseRepository;

class PostRepository extends BaseRepository {

    public function boot(){
        $this->pushCriteria(new MyCriteria());
        // or
        $this->pushCriteria(AnotherCriteria::class);
        ...
    }

    function model(){
       return "App\\Post";
    }
}
```

### Skip criteria defined in the repository

Use `skipCriteria` before any other chaining method

```php
$posts = $this->repository->skipCriteria()->all();
```

### Popping criteria

Use `popCriteria` to remove a criteria

```php
$this->repository->popCriteria(new Criteria1());
// or
$this->repository->popCriteria(Criteria1::class);
```


### Using the RequestCriteria

RequestCriteria is a standard Criteria implementation. It enables filters to perform in the repository from parameters sent in the request.

You can perform a dynamic search, filter the data and customize the queries.

To use the Criteria in your repository, you can add a new criteria in the boot method of your repository, or directly use in your controller, in order to filter out only a few requests.

#### Enabling in your Repository

```php
use AcDevelopers\Repository\Eloquent\BaseRepository;
use AcDevelopers\Repository\Criteria\RequestCriteria;


class PostRepository extends BaseRepository {

	/**
     * @var array
     */
    protected $fieldSearchable = [
        'name',
        'email'
    ];

    public function boot(){
        $this->pushCriteria(app('AcDevelopers\Repository\Criteria\RequestCriteria'));
        ...
    }

    function model(){
       return "App\\Post";
    }
}
```

Remember, you need to define which fields from the model can be searchable.

In your repository set **$fieldSearchable** with the name of the fields to be searchable or a relation to fields.

```php
protected $fieldSearchable = [
	'name',
	'email',
	'product.name'
];
```

You can set the type of condition which will be used to perform the query, the default condition is "**=**"

```php
protected $fieldSearchable = [
	'name'=>'like',
	'email', // Default Condition "="
	'your_field'=>'condition'
];
```


#### Enabling in your Controller

```php
	public function index()
    {
        $this->repository->pushCriteria(app('AcDevelopers\Repository\Criteria\RequestCriteria'));
        $posts = $this->repository->all();
		...
    }
```

#### Example the Criteria

Request all data without filter by request

`http://ac-developers.local/users`

```json
[
    {
        "id": 1,
        "name": "John Doe",
        "email": "john@gmail.com",
        "created_at": "-0001-11-30 00:00:00",
        "updated_at": "-0001-11-30 00:00:00"
    },
    {
        "id": 2,
        "name": "Lorem Ipsum",
        "email": "lorem@ipsum.com",
        "created_at": "-0001-11-30 00:00:00",
        "updated_at": "-0001-11-30 00:00:00"
    },
    {
        "id": 3,
        "name": "Laravel",
        "email": "laravel@gmail.com",
        "created_at": "-0001-11-30 00:00:00",
        "updated_at": "-0001-11-30 00:00:00"
    }
]
```

Conducting research in the repository

`http://ac-developers.local/users?search=John%20Doe`

or

`http://ac-developers.local/users?search=John&searchFields=name:like`

or

`http://ac-developers.local/users?search=john@gmail.com&searchFields=email:=`

or

`http://ac-developers.local/users?search=name:John Doe;email:john@gmail.com`

or

`http://ac-developers.local/users?search=name:John;email:john@gmail.com&searchFields=name:like;email:=`

```json
[
    {
        "id": 1,
        "name": "John Doe",
        "email": "john@gmail.com",
        "created_at": "-0001-11-30 00:00:00",
        "updated_at": "-0001-11-30 00:00:00"
    }
]
```

By default RequestCriteria makes its queries using the **OR** comparison operator for each query parameter.
`http://ac-developers.local/users?search=age:17;email:john@gmail.com`

The above example will execute the following query:
``` sql
SELECT * FROM users WHERE age = 17 OR email = 'john@gmail.com';
```

In order for it to query using the **AND**, pass the *searchJoin* parameter as shown below:

`http://ac-developers.local/users?search=age:17;email:john@gmail.com&searchJoin=and`





Filtering fields

`http://ac-developers.local/users?filter=id;name`

```json
[
    {
        "id": 1,
        "name": "John Doe"
    },
    {
        "id": 2,
        "name": "Lorem Ipsum"
    },
    {
        "id": 3,
        "name": "Laravel"
    }
]
```

Sorting the results

`http://ac-developers.local/users?filter=id;name&orderBy=id&sortedBy=desc`

```json
[
    {
        "id": 3,
        "name": "Laravel"
    },
    {
        "id": 2,
        "name": "Lorem Ipsum"
    },
    {
        "id": 1,
        "name": "John Doe"
    }
]
```

Sorting through related tables

`http://ac-developers.local/users?orderBy=posts|title&sortedBy=desc`

Query will have something like this

```sql
...
INNER JOIN posts ON users.post_id = posts.id
...
ORDER BY title
...
```

`http://ac-developers.local/users?orderBy=posts:custom_id|posts.title&sortedBy=desc`

Query will have something like this

```sql
...
INNER JOIN posts ON users.custom_id = posts.id
...
ORDER BY posts.title
...
```


Add relationship

`http://ac-developers.local/users?with=groups`



#### Overwrite params name

You can change the name of the parameters in the configuration file **config/repository.php**

### Cache

Add a layer of cache easily to your repository

#### Cache Usage

Implements the interface CacheableInterface and use CacheableRepository Trait.

```php
use AcDevelopers\Repository\Eloquent\BaseRepository;
use AcDevelopers\Repository\Contracts\CacheableInterface;
use AcDevelopers\Repository\Traits\CacheableRepository;

class PostRepository extends BaseRepository implements CacheableInterface {

    use CacheableRepository;

    ...
}
```

Done , done that your repository will be cached , and the repository cache is cleared whenever an item is created, modified or deleted.

#### Cache Config

You can change the cache settings in the file *config/repository.php* and also directly on your repository.

*config/repository.php*

```php
'cache'=>[
    //Enable or disable cache repositories
    'enabled'   => true,

    //Lifetime of cache
    'minutes'   => 30,

    //Repository Cache, implementation Illuminate\Contracts\Cache\Repository
    'repository'=> 'cache',

    //Sets clearing the cache
    'clean'     => [
        //Enable, disable clearing the cache on changes
        'enabled' => true,

        'on' => [
            //Enable, disable clearing the cache when you create an item
            'create'=>true,

            //Enable, disable clearing the cache when upgrading an item
            'update'=>true,

            //Enable, disable clearing the cache when you delete an item
            'delete'=>true,
        ]
    ],
    'params' => [
        //Request parameter that will be used to bypass the cache repository
        'skipCache'=>'skipCache'
    ],
    'allowed'=>[
        //Allow caching only for some methods
        'only'  =>null,

        //Allow caching for all available methods, except
        'except'=>null
    ],
],
```

It is possible to override these settings directly in the repository.

```php
use AcDevelopers\Repository\Eloquent\BaseRepository;
use AcDevelopers\Repository\Contracts\CacheableInterface;
use AcDevelopers\Repository\Traits\CacheableRepository;

class PostRepository extends BaseRepository implements CacheableInterface {

    // Setting the lifetime of the cache to a repository specifically
    protected $cacheMinutes = 90;

    protected $cacheOnly = ['all', ...];
    //or
    protected $cacheExcept = ['find', ...];

    use CacheableRepository;

    ...
}
```

The cacheable methods are : all, paginate, find, findByField, findWhere, getByCriteria

### Credits
- [Anderson Andrade](https://github.com/andersao)

### Licence
The L5 Repository Slim is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).