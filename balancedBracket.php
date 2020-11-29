<?php
function isValidBalancedBracket($sStr) {
    $aBrackets = array('()', 
                       '[]', 
                       '{}');
    do {
        $sStr = str_replace($aBrackets, '', $sStr, $iCount);
    } while ($iCount);
    return (bool)!$sStr;
}

$aTests = array("[][[{()}]]", "}{");

foreach ($aTests as $iKey => $sTest) {
	echo ($iKey+1)." - ".$sTest." - ";
    if (isValidBalancedBracket($sTest))
        echo "is valid";
    else
        echo "is not valid";
    echo "<br>";
}