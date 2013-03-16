<?php
/*Funcion que retorna la combinatoria de un set de elementos de un array, sacada de http://php.net/manual/en/ref.array.php*/
function combinations($elements) {
    if (is_array($elements)) {
        /*
          I want to generate an array of combinations, i.e. an array whose elements are arrays
          composed by the elements of the starting object, combined in all possible ways.
          The empty array must be an element of the target array.
         */
        $combinations = array(array()); # don't forget the empty arrangement!
        /*
          Built the target array, the algorithm is to repeat the operations below for each object of the starting array:
          - take the object from the starting array;
          - generate all arrays given by the target array elements merged with the current object;
          - add every new combination to the target array (the array of arrays);
          - add the current object (as a vector) to the target array, as a combination of one element.
         */
        foreach ($elements as $element) {
            $new_combinations = array(); # temporary array, see below
            foreach ($combinations as $combination) {
                $new_combination = array_merge($combination, (array) $element);
                # I cannot merge directly with the main array ($combinations) because I'm in the foreach cycle
                # I use a temporary array
                array_push($new_combinations, $new_combination);
            }
            $combinations = array_merge($combinations, $new_combinations);
        }
        return $combinations;
    } else {
        return false;
    }
}

function enumerar_en_espanol($arreglo,$last_char='y',$separador=',&nbsp;&nbsp;'){
    if(count($arreglo)>1){
        $ultimo = " &nbsp;{$last_char}&nbsp; ".$arreglo[count($arreglo)-1];
        unset($arreglo[count($arreglo)-1]);
    }else{
        $ultimo = "";
    }
    return implode($separador,$arreglo).$ultimo;
}

?>
