<?php

class Map implements ArrayAccess, Countable, IteratorAggregate
{    
    public \SplFixedArray $map;
    
    public function __construct(int $size) {
        $map = new \SplFixedArray($size);
        for($i=0; $i < $size; $i++) {
            $map[$i] = new \SplFixedArray($size);
        }
        $this->map = $map;
    }
    
    public function offsetGet($offset) : \SplFixedArray {
        return $this->map[$offset];
    }
    
    public function offsetSet($offset, $value) {
        $this->map[$offset]=$value;
    }
    
    public function offsetUnset($offset) {
        throw new RuntimeException("unset not implemented");
    }
    
    public function offsetExists($offset) : bool {
        return array_key_exists($offset, $this->map);
    }
    
    public function count() : int {
        return count($this->map);
    }
    
    public function dump() : \SplFixedArray
    {
        return $this->map;        
    }
    
    public function getIterator()
    {
        return $this->map->getIterator();
    }
}