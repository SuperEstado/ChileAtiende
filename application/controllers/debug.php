<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Debug extends CI_Controller {

    public function index() {
        
    }

    public function text_difference() {


        $stringa = "hola mundo como estas";
        $stringb = "hola mundo como estas bien";

        //debug(diff(explode(" ",$stringa),explode(" ",$stringb)));
        debug(htmlDiff($stringa, $stringb));

        $stringa = "hola mundo como estas bien";
        $stringb = "hola mundo como estas";

        //debug(diff(explode(" ",$stringa),explode(" ",$stringb)));
        debug(htmlDiff($stringa, $stringb));

        $stringa = "hola mundo como estas bien";
        $stringb = "hola mundo estas bien";

        //debug(diff(explode(" ",$stringa),explode(" ",$stringb)));
        debug(htmlDiff($stringa, $stringb));

        $stringa = "hola mundo estas bien";
        $stringb = "hola mundo estas bien";

        //debug(diff(explode(" ",$stringa),explode(" ",$stringb)));
        debug(htmlDiff($stringa, $stringb));

        $stringa = "hola mundo estás bien";
        $stringb = "hola mundo estas bien";

        //debug(diff(explode(" ",$stringa),explode(" ",$stringb)));
        debug(htmlDiff($stringa, $stringb));

        $stringa = "hola mundo estás bien";
        $stringb = "hola mundo estás bien";

        //debug(diff(explode(" ",$stringa),explode(" ",$stringb)));
        debug(htmlDiff($stringa, $stringb));
    }

    public function sphinx() {

        $this->load->library('sphinxclient');

        $this->sphinxclient->SetServer("localhost", 9312);
        $this->sphinxclient->SetMatchMode(SPH_MATCH_ANY);
        
        
        /*Aca es posible aplicar diferentes filtros, por ejemplo que tengan ciertas categorias*/
        //$this->sphinxclient->SetFilter('categoria', array(3));
        
        /*Para pillar*/
        $result = $this->sphinxclient->Query('hola mundo soy un perrito bono', 'redchile_fichas'); //String, Index
        

        if ($result === false) {
            echo "Query failed: " . $this->sphinxclient->GetLastError() . ".\n";
        } else {
            if ($this->sphinxclient->GetLastWarning()) {
                echo "WARNING: " . $this->sphinxclient->GetLastWarning() . "";
            }

            debug($result);
            
        }
    }
    
    public function sphinx_helper(){
        $this->load->helper("sphinx");
        
        $a = search_wrapper(search("",null,true,5,40)); //Obtiene todas las fichas
        debug(implode(',',$a));
    }
    
    function rangos(){
        
        $rangos = Doctrine::getTable("RangoEdad")->rangosFromAge(10);
        debug(implode(',',$rangos));
        
    }
    
    function text(){
        
        
        $this->load->library("textHighlight");
        
        $lorem = "Lorem ipsum dolor sit amet, consectetur adipiscing elit. Duis congue sodales neque, non accumsan justo pellentesque ut. Phasellus eros libero, ullamcorper nec hendrerit suscipit, mollis eget nunc. Fusce aliquam turpis in nisl convallis porttitor. Mauris eu metus mi. Curabitur luctus, augue in mollis aliquet, risus arcu porttitor eros, ac venenatis lorem urna facilisis risus. Praesent dignissim metus ut orci luctus ac laoreet neque tristique. Donec sit amet velit id felis viverra mattis vitae eu nulla. Maecenas ullamcorper mi malesuada sem dapibus luctus. Curabitur venenatis est quis metus euismod sed suscipit diam facilisis.";
        $needles = array('ipsum','eros','sed','nec','elit');
        
        $this->texthighlight->setText($lorem);
        $this->texthighlight->setNeedles($needles);
        $this->texthighlight->setRadius(4);
        $this->texthighlight->createSegments();
        $this->texthighlight->mergeSegments();
        
        debug($lorem);
        echo "<br/>";
        debug($this->texthighlight->stringSegments());
       
        
        
        
    }
    
}
