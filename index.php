<?php
 require_once 'class.parser.php';
 require_once 'class.output.php';
 
 $filename=$_REQUEST['filename'];
 
try {
    $Parser = new Parser($filename);
    $World = $Parser->parse();
    $World->proceed();
    $Output = new Output($World);
    $Output->toXml();
} catch (ParserException $e) {
    echo "Failed to parse file $filename ".$e->getMessage();
}
