<?php
//definiše se mime type
header("Content-type: application/xml");
//konekcija ka bazi
require_once "konekcija.php";
//priprema upita
$sql="SELECT * FROM tasks ORDER BY idTask ASC";
//kreiranje XMLDOM dokumenta
$dom = new DomDocument('1.0','utf-8');

//dodaje se koreni element
 $tasks = $dom->appendChild($dom->createElement('tasks'));

//izvršavanje upita
if (!$q=$mysqli->query($sql)){
//ako se upit ne izvrši
  //dodaje se element <greska> u korenom elementu <tasks>
 $greska = $tasks->appendChild($dom->createElement('error'));
 //dodaje se elementu <greska> sadrzaj cvora
 $greska->appendChild($dom->createTextNode("Error"));
} else {
//ako je upit u redu
if ($q->num_rows>0){
//ako ima rezultata u bazi
$niz = array();
while ($red=$q->fetch_object()){
  //dodaje se element <task> u korenom elementu <tasks>
 $task = $tasks->appendChild($dom->createElement('task'));

 //dodaje  se <idTask> element u <task>
 $idTask = $task->appendChild($dom->createElement('idTask'));
 //dodaje se elementu <idTask> sadrzaj cvora
 $idTask->appendChild($dom->createTextNode($red->idTask));

 //dodaje  se <name> element u <task>
 $name = $task->appendChild($dom->createElement('name'));
 //dodaje se elementu <name> sadrzaj cvora
 $name->appendChild($dom->createTextNode($red->name));
}
} else {
//ako nema rezultata u bazi
  //dodaje se element <greska> u korenom elementu <tasks>
 $greska = $tasks->appendChild($dom->createElement('Error'));
 //dodaje se elementu <greska> sadrzaj cvora
 $greska->appendChild($dom->createTextNode("Error"));
}
}
//cuvanje XML-a
$xml_string = $dom->saveXML(); 
echo $xml_string;
//zatvaranje konekcije
$mysqli->close()
?>