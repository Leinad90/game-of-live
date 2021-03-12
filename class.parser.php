<?php
declare (strict_types=1);
require_once 'class.world.php';

class Parser
{

    public function __construct(string $data, bool $dataIsUrl = true)
    {
        try {
            $this->object = new SimpleXMLElement($data, dataIsURL: $dataIsUrl); 
        } catch (\Exception $e) {
            throw new ParserException("Error while parsing input data", 10, $e);
        }
    }
    
    public function parse() : World
    {
        $species = array();
        $world = $this->object->world;
        $cells = (int)$world->cells;
        $iterations = (int)$world->iterations;
        $map = new Map($cells+1);
        $organisms = $this->object->organisms;
        $organismsChildren = $organisms->children();
        if($organismsChildren === null) {
            throw new ParserException("Tag organisms has no chidls", 20);
        }
        foreach ($organismsChildren as $organism) {
            $specie = (string)$organism->species;
            $species[] = $specie;
            try {
                $map[$x=(int)$organism->x_pos][$y=(int)$organism->y_pos]=$specie;
            } catch (\RuntimeException $e) {
                throw new ParserException("Point [$x,$y] out of range $cells", 21, $e);
            }
        }
        $species = array_filter(array_unique($species));
        return new World($map, $iterations, $species);
    }

}

class ParserException extends Exception
{
    
}