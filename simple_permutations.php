<?php 


/**
	Get the count of number of permutations possible for the length of the string
*/
function factorial($n) {
    if ($n <= 1) {
        return 1;
    } else {
        return $n * factorial($n - 1);
    }
}

function numberOfPermutations($length) {
    return factorial($length);
}

// Example usage
$length = 4;
$numberOfPermutations = numberOfPermutations($length);
echo "Number of permutations for length $length: " . $numberOfPermutations;


$newitems=[];
$newperms=[];
 
generatePermutations(array(0, 1, 2));

function generatePermutations($items, $perms = array()) {
    if (empty($items)) { 
        echo join(' ', $perms) . "</br>";
    } else {
        for ($i = count($items) - 1; $i >= 0; --$i) {
            $newItems = $items;
            $newPerms = $perms;
            list($currentItem) = array_splice($newItems, $i, 1);
            array_unshift($newPerms, $currentItem);
            generatePermutations($newItems, $newPerms);
        }
    }
}

 



?>
