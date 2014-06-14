<?php

//echo decToFraction(1.33);
//echo decToPrice(1);

function decToPrice($number) {
	return "$" . money_format('%.2n', $number);
}

function decToFraction($float) {
    // 1/2, 1/4, 1/8, 1/16, 1/3 ,2/3, 3/4, 3/8, 5/8, 7/8, 3/16, 5/16, 7/16,
    // 9/16, 11/16, 13/16, 15/16
    $whole = floor ( $float );
    $decimal = $float - $whole;
    //$leastCommonDenom = 48; // 16 * 3;
    $leastCommonDenom = 8; // 16 * 3;
    //$denominators = array (2, 3, 4, 8, 16, 24, 48 );
    $denominators = array (2, 3, 4, 5, 6, 7, 8 );
    $roundedDecimal = round ( $decimal * $leastCommonDenom ) / $leastCommonDenom;
    if ($roundedDecimal == 0)
        return $whole;
    if ($roundedDecimal == 1)
        return $whole + 1;
    foreach ( $denominators as $d ) {
        if ($roundedDecimal * $d == floor ( $roundedDecimal * $d )) {
            $denom = $d;
            break;
        }
    }

	$rawfraction = ($roundedDecimal * $denom) . "/" . $denom;
	
	switch ($rawfraction) {
	    case "1/4":
	        $formattedfraction = "&frac14;";
	        break;
		case "1/2":
        	$formattedfraction = "&frac12;";
	    	break;
		case "3/4":
        	$formattedfraction = "&frac34;";
	    	break;
		case "1/3":
	       	$formattedfraction = "&#8531;";
	    	break;
	    case "2/3":
	        $formattedfraction = "&#8532;";
	        break;
		case "1/5":
        	$formattedfraction = "&#8533;";
	    	break;
		case "2/5":
        	$formattedfraction = "&#8354;";
	    	break;
		case "3/5":
	       	$formattedfraction = "&#8535;";
	    	break;
		case "4/5":
        	$formattedfraction = "&#8536;";
	    	break;
		case "1/6":
	       	$formattedfraction = "&#8537;";
	    	break;
	    case "5/6":
	        $formattedfraction = "&#8538;";
	        break;
		case "1/8":
        	$formattedfraction = "&#8539;";
	    	break;
		case "3/8":
        	$formattedfraction = "&#8540;";
	    	break;
		case "5/8":
	       	$formattedfraction = "&#8541;";
	    	break;
		case "7/8":
	       	$formattedfraction = "&#8542;";
	    	break;
		default:
			$formattedfraction = $rawfraction;
	}

    return ($whole == 0 ? '' : $whole) . " " . $formattedfraction;
}

function decToFraction2($float) {

	$whole = floor ( $float );
    $decimal = $float - $whole;

    //echo "From:" . $float . "To:" . $decimal . "<br />";

    switch (strval($decimal)) {
	    case "0.25":
	        $formattedfraction = "&frac14;";
	        break;
		case "0.50":
        	$formattedfraction = "&frac12;";
	    	break;
		case "0.75":
        	$formattedfraction = "&frac34;";
	    	break;
		case "0.33":
	       	$formattedfraction = "&#8531;";
	    	break;
	    case "0.67":
	        $formattedfraction = "&#8532;";
	        break;
		case "0.13":
        	$formattedfraction = "&#8539;";
	    	break;
		case "0.38":
        	$formattedfraction = "&#8540;";
	    	break;
		case "0.63":
	       	$formattedfraction = "&#8541;";
	    	break;
		case "0.88":
	       	$formattedfraction = "&#8542;";
	    	break;
		default:
			$formattedfraction = "";
	}

    return ($whole == 0 ? '' : $whole) . " " . $formattedfraction;
}

function factionToDec($faction) {
	$splitFrac = explode("/", $faction);

	return $splitFrac[0] / $splitFrac[1];
}

function getNumberSuffix($dNum)
{
	$daySuffix = 'th';
	if($dNum != 11 && $dNum != 12 && $dNum != 13) 
	{
		if($dNum > 9) { $dNum = $dNum % 10; }
		if ($dNum == 1) { $daySuffix = 'st'; }
		if ($dNum == 2) { $daySuffix = 'nd'; }
		if ($dNum == 3) { $daySuffix = 'rd'; }
	}
	return $daySuffix;
}
?>