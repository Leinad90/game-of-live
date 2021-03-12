<?php
class Output
{
    public function __construct(
            protected World $World
    )
    {
        
    }
    
    public function toXml()
    {
        $a = new \XMLWriter();
        $a->openUri('output.xml');
        $a->startDocument();
        $a->startElement('life');
        
        $a->startElement('world');
        $a->startElement('cells');
        $a->text(count($this->World->map));
        $a->endElement();
        $a->startElement('iterations');
        $a->text($this->World->getIterations());
        $a->endElement();
        $a->endElement();
        $a->startElement('organisms');
        foreach ($this->World->map as $x => $row) {
            //var_dump($row);
            foreach ($row as $y => $cell) {
                if($cell) {
                    $a->startElement('organism');
                    
                    $a->startElement('x_pos');
                    $a->text($x);
                    $a->endElement();
                    $a->startElement('y_pos');
                    $a->text($y);
                    $a->startElement('species');
                    $a->text($cell);
                    $a->endElement();
                    
                    $a->endElement();
                }
            }
        }
        $a->endElement();
        
        $a->endElement(); 
        $a->endDocument();
        $a->flush();
    }
}
