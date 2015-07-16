<?
/**
 * Created by PhpStorm.
 * User: YanTotal
 * Date: 14.07.15
 * Time: 21:47
 */
error_reporting(-1) ; // включить все виды ошибок, включая  E_STRICT
ini_set('display_errors', 'On');  // вывести на экран помимо логов
//Array
$arr = array(
    array("Jon", "Skeet", 13000),
    array("Gennady", "Korotkevich", 950000),
    array("Linus", "Torvalds", 128000),
    array("Jeff", "Dean", 632000),
    array("John", "Carmack", 718000),
    array("Petr", "Mitrechev", 192000),
    array("Fabrice", "Bellard", 820000)
);
$count = count($arr);
$colspan = count($arr[0]);
$summ = 0;
$doc = new DOMDocument;
//Create html
$html = $doc->appendChild($doc->createElement('html'));
$html = $doc->appendChild($doc->createElement('body'));
//Create table
$tableElement = $doc->createElement('table');
$tableAttribute = $doc->createAttribute('border');
$tableAttribute->value = '1';
$tableElement->appendChild($tableAttribute);
$html->appendChild($tableElement);
//Show coll
$i = 0;
foreach ($arr as $tr_array) {
    //Create tr element
    $trElement = $doc->createElement('tr');
    //Add style attribute
    if($i % 2 == 0) {
        //Add class attribute
        $trAttribute = $doc->createAttribute('style');
        $trAttribute->value = 'background-color: #ddd';
        $trElement->appendChild($trAttribute);
    }
    $tr = $tableElement->appendChild($trElement);
    //Show row
    $a = 1;
    foreach($tr_array as $td_text) {
        //Create td element
        $tdElement = $doc->createElement('td');
        //Add class attribute
        $tdAttribute = $doc->createAttribute('class');
        $tdAttribute->value = 'cell';
        $tdElement->appendChild($tdAttribute);
        //Insert
        $tr->appendChild($tdElement);
        $tdElement->appendChild($doc->createTextNode($td_text));
        //max colspan
        if($a > $colspan)
            $colspan = $a;
        $a++;
        //summ
        if(is_numeric($td_text)) {
            $summ = $summ + $td_text;
        }
    }
    $i++;
}
//Show footer rable
//Create tr element
$trElement = $doc->createElement('tr');
$tr = $tableElement->appendChild($trElement);
//Create td element
$tdElement = $doc->createElement('td');
//Add class attribute
$tdAttribute = $doc->createAttribute('style');
$tdAttribute->value = 'font-weight: bold;';
$tdElement->appendChild($tdAttribute);
//Add class attribute
$tdAttribute = $doc->createAttribute('colspan');
$tdAttribute->value = $colspan;
$tdElement->appendChild($tdAttribute);
//Insert
$tr->appendChild($tdElement);
$tdElement->appendChild($doc->createTextNode($summ));
$doc->formatOutput = true;
print $doc->saveHTML();
?>