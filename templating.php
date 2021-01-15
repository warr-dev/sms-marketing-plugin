<?php 

    function templatize($str,$vals,$vars){
        foreach($vars as $var){
            $column=$var->varval;
            $str=str_replace('{{ ' . $var->varname . ' }}', $vals[$column] , $str);
        }
        return $str;
    }
?>