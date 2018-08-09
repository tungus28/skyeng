<?php

function getBigIntSum(string $a, string $b) : string
{
    $getAbsolute = function(string $value) : string
    {
        if ( '-' === $value[0] ) {
            $value = substr_replace($value, '', 0, 1);
        }
        return $value;
    };
	
	$compareValues = function(string $a, string $b, int $aLength, int $bLength) : int
    {
        if ( $a === $b ) {
            return 0;
        }
		
        if ( $aLength > $bLength ) {
            return 1;
        } elseif ( $aLength < $bLength ) {
            return -1;
        }
		
        for ($i = 0; $i < $aLength; $i++) {
            $ai = (int)$a[$i];
            $bi = (int)$b[$i];
            
			if ( $ai > $bi ) {
                return 1;
            }
			
            if ( $ai < $bi ) {
                return -1;
            }
        }
        return 0;
    };		
	
    $calculateFinal = function(string $a, string $b, int $aLength, int $bLength, bool $sumMode) {
        $shift = 0;
        $result  = '';
        $maxLength  = max($aLength, $bLength);
		
        for ($i = 1; $i <= $maxLength; $i++) {
            $iA = $aLength - $i;
            $iB = $bLength - $i;
            $aa = $iA >= 0 && isset($a[$iA]) ? (int)$a[$iA] : 0;
            $bb = $iB >= 0 && isset($b[$iB]) ? (int)$b[$iB] : 0;
            
			if ( $sumMode ) {
                $sum = $aa + $bb + $shift;
                $shift = $sum >= 10 ? 1 : 0;
                $result .= $sum % 10;
            } else {
                $s = 10 + $aa - $bb - $shift;
                $shift = $s < 10 ? 1 : 0;
                $result .= $s % 10;
            }
        }
		
        if ( $sumMode ) {
            if ($shift !== 0) {
                $result .= $shift;
            }
        } else {
            $result = rtrim($result, '0');
        }
		
        return strrev($result);
    };	
    
    $aAbsolute = $getAbsolute($a);
    $bAbsolute = $getAbsolute($b);    
	
    $aIsNegative = $a !== $aAbsolute;
    $bIsNegative = $b !== $bAbsolute;    
	
    $aLength = strlen($aAbsolute);
    $bLength = strlen($bAbsolute);
	
    if ( $aIsNegative xor $bIsNegative ) { //если переменные разные по знаку
        $compareValues = $compareValues($aAbsolute, $bAbsolute, $aLength, $bLength);
        if ( 0 === $compareValues ) {
            return '0'; //переменные разные по знаку, но равны по абсолютному значению
        } elseif ( -1 === $compareValues ) {
            $result = $calculateFinal($bAbsolute, $aAbsolute, $bLength, $aLength, false);
            $ifNeedMinus = !$aIsNegative;
        } else {
            $result = $calculateFinal($aAbsolute, $bAbsolute, $aLength, $bLength, false);
            $ifNeedMinus = !$bIsNegative;
        }
    } else { //если переменные не разные по знаку
        $ifNeedMinus = $aIsNegative && $bIsNegative;
        $result = $calculateFinal($aAbsolute, $bAbsolute, $aLength, $bLength, true);
    }
	
    if ( $ifNeedMinus ) {
        $result = '-' . $result;
    }
	
    return $result;
}
