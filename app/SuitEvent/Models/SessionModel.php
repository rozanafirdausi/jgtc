<?php

namespace App\SuitEvent\Models;

use Illuminate\Database\Eloquent\Model;

class SessionModel extends Model
{
    protected $primaryKey = 'id';

    protected $hidden = ['id'];
    
    protected $sessionName = 'my_session';

    protected static $dataQuery = [];

    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);

        $this->{$this->getKeyName()} = array_get($attributes, $this->getKeyName(), null);
    }

    public function getSessionName($sufix = '')
    {
        return $this->sessionName . $sufix;
    }

    public static function createSession()
    {
        $session = session();

        $instance = new static;
        
        if (!$session->has($instance->getSessionName())) {
            $session->put($instance->getSessionName('_increment'), 0);

            $session->put($instance->getSessionName(), []);
        }

        return static::$dataQuery = session()->get($instance->getSessionName());
    }

    public static function forgetSession()
    {
        $session = session();

        $instance = new static;

        $session->put($instance->getSessionName('_increment'), 0);
        
        $session->put($instance->getSessionName(), []);
    }

    public static function getIncrement()
    {
        $instance = new static;
        return session()->get($instance->getSessionName('_increment'), 0);
    }

    public static function addIncrement()
    {
        $increment = static::getIncrement() + 1;
        $instance = new static;
        session()->put($instance->getSessionName('_increment'), $increment);

        return $increment;
    }

    public function save(array $options = [])
    {
        $attributes = $this->getAttributes();
        
        $id = $this->getKey();
        
        if ($id) {
            return $this->update($attributes);
        }

        return static::create($attributes);
    }

    public static function find($key)
    {
        $instance = new static;

        $data = $instance->getDataQuery()->where($instance->getKeyName(), $key)->first();

        return new static($data);
    }

    public static function create(array $attributes = [])
    {
        $id = static::addIncrement();

        $instance = new static;

        $attributes = array_only($attributes, $instance->getFillable());

        $attributes[$instance->getKeyName()] = $id;

        session()->put($instance->getSessionName() . '.' . $id, $attributes);

        return collect($attributes);
    }

    public function update(array $attributes = [], array $options = [])
    {
        $id = $this->getKey();

        session()->put($this->sessionName . '.' . $id, $attributes);
     
        return collect($attributes);
    }

    public function delete()
    {
        $id = $this->getKey();

        session()->forget($this->sessionName . '.' . $id);
     
        return collect($this);
    }

    public function getDataQuery()
    {
        static::createSession();
        return collect(static::$dataQuery);
    }

    public function newQuery()
    {
        return $this->getDataQuery();
    }

    public static function all($columns = [])
    {
        return app(static::class)->newQuery();
    }

    // public function __call($method, $params)
    // {
    //     return $this->getDataQuery();
    // }

    // public static function __callStatic($method, $params)
    // {
    //     return collect(static::$dataQuery);
    // }
}
