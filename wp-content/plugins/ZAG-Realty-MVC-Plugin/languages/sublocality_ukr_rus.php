<?php

function sublocality_translate($uk_subloc){
    
    $sublocalities = array (
        'Приморський район' =>'Приморский район',
        'Київський район' =>'Киевский район',
        'Малиновський район'=>'Малиновский район',
        'Суворовський район'=>'Суворовский район',
        
    );
    
    return $sublocalities[$uk_subloc];
}
