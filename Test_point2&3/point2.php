<?php
    $content = '{
        "array" : [
            {
                "user" : "Oscar",
                "age" : 18,
                "scoring" : 40
            },
            {
                "user" : "Mario",
                "age" : 45,
                "scoring" : 10
            },
            {
                "user" : "Zulueta",
                "age" : 33,
                "scoring" : 78
            },
            {
                "user" : "Mario",
                "age" : 45,
                "scoring" : 78
            },
            {
                "user" : "Patricio",
                "age" : 22,
                "scoring" : 9
            }
        ],
        "sort" : [
            {
                "age" : "DESC"
            },
            {
                "scoring" : "DESC"
            }
        ]

    }';

    
    function sortElements($content){

        $json = json_decode($content, true);

        $array = $json["array"];
        $arrayOriginal = $array;
        $order = $json["sort"]; 
        return $this->json($order);
        usort($array, function($element, $next) use ($order) {
            foreach($order as $field => $directionSort){
                switch($directionSort){
                    case 'DESC':
                        $direction=-1;
                        break;
                    case 'ASC':
                    default:
                        $direction=1;
                        break;
                }
                if ($element[$field] > $next[$field]) {
                    return $direction;
                } else if ($element[$field] < $next[$field]){
                    return $direction*-1;
                }
            }
            return 0;
        });

        return $array;
    }
?>