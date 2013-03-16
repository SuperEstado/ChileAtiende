<?php

    function paginacion($total_fichas,$fichas_por_pagina,$pagina_actual,$prev=FALSE,$next=FALSE){

        $total_paginas = ceil($total_fichas/$fichas_por_pagina);
        if($total_fichas == 0 || !$pagina_actual){
            $pagina_actual = 1;
        }else{
            //filtro valores negativos o si ponen mas paginas de las que hay:
            $pagina_actual = ($pagina_actual>0)?(($pagina_actual<=$total_paginas)?$pagina_actual:$total_paginas):1;
        }

        if($prev) $pagina_actual--;
        if($next) $pagina_actual++;
        $pagina_actual = ($pagina_actual > 0) ? $pagina_actual : 1;
        $offset = ($pagina_actual-1)*$fichas_por_pagina;

        return array(
            'page'=>$pagina_actual,
            'total_paginas'=>$total_paginas,
            'total_fichas'=>$total_fichas,
            'offset'=>$offset,
            'show_next' => ($pagina_actual<$total_paginas),
            'show_prev' => ($pagina_actual>1)
            );

    }
