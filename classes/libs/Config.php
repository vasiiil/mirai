<?php

class Config Implements ArrayAccess
{
    protected $params;

    public function __construct(array $params)
    {
        $this->params = $params;
    }

    public function offsetExists($offset)
    {
        return array_key_exists($offset, $this->params);
    }

    public function offsetGet($offset)
    {
        return array_key_exists($offset, $this->params) ? $this->params[$offset] : null;
    }

    public function offsetSet($offset, $value)
    {
        $this->params[$offset] = $value;
    }

    public function offsetUnset($offset)
    {
        unset($this->params[$offset]);
    }

}
