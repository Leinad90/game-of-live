<?php
declare(strict_types=1);
require_once 'class.map.php';

class World
{
    
    protected array $die = [0,1,4,5,6,7];
    
    protected array $born = [3];
    
    public function __construct(
            public Map $map,
            private int $iterations,
            public array $species
    ) {

    }
    
    public function proceed()
    {
        while ($this->hasWork()) {
            $this->doStep();
        }
    }

    public function hasWork(): bool
    {
        return $this->iterations > 0;
    }
    
    protected function stepProcessed() : void
    {
        $this->iterations --;
    }
    
    public function getIterations() { /* type intenationaly not set */
        return $this->iterations;
    }


    protected function doStep()
    {
        $lenght = count($oldMap = $this->map);
        $newMap = new Map($lenght);
        for($i = 0; $i<$lenght; $i++) {
            for($j = 0; $j<$lenght; $j++) {
                $newMap[$i][$j] = $oldMap[$i][$j];
                $neighbors = $this->getNeighbors($i, $j);
                foreach ($neighbors as $specie => $count) {
                    if($this->mayBorn($count)) {
                        $newMap[$i][$j] = $specie;
                        break;
                    }
                    if($specie === $oldMap[$i][$j] && $this->mayDie($count)) {
                        $newMap[$i][$j] = null;
                    }
                }
            }
        }
        $this->map = $newMap;
        $this->stepProcessed();
    }
        
    protected function getNeighbors(int $x, int $y) : array
    {
        $return = array();
        foreach ($this->species as $specie) {
            $return[$specie] = 0;
        }
        unset($specie);
        for($i = max($x-1,0); $i<=min($x+1, count($this->map)-1); $i++) {
            for($j = max($y-1,0); $j<=min($y+1, count($this->map)-1); $j++) {
                if($i===$x && $j===$y) {
                    continue;
                }
                $specie = $this->map[$i][$j];
                if($specie) {
                    $return[$specie] ++; 
                }
            }
        }
        return $return;
    }
    
    protected function mayBorn(int $neighbors) : bool
    {
        return in_array($neighbors, $this->born);
    }
    
    protected function mayDie(int $neighbors) : bool
    {
       return in_array($neighbors, $this->die);       
    }
    
}