<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

class textHighlight{
    
    var $text;
    var $needles;
    var $segments;
    var $radius;
    
    /* Se asume un texto plano! */
    function textHighligh(){
        $this->radius = 4;
    }
    
    function setText($text){
        
        $order= array("\r\n", "\n", "\r");
        $text = str_replace($order, ' ', $text);
        $this->text = explode(" ",$text);
    }
    
    function setNeedles($needles){
        $this->needles = $needles;
    }
    
    function setRadius($radius){
        $this->radius = $radius;
    }
    
    function addRadius($add){
        $this->radius += $add;
    }
    
    function lessRadius($less){
        $this->radius -= $less;
    }
    
    function reset(){
        $this->text = "";
        $this->needles = array();
        $this->segments = array();
    }
    
    function createSegments(){
        
        $this->radius = ($this->radius) ? $this->radius:4;

        $n_segments = 0;
        
        for($i = 0; $i<count($this->text); $i++)
            foreach($this->needles as $needle)
                if($this->match($needle,$this->text[$i]))
                    $n_segments++;
        
        if($n_segments < 4){
            $this->addRadius(3);
        }elseif($n_segments>6){
            
        }
        
        for($i = 0; $i<count($this->text); $i++){

            //debug(array('word',$this->removeNoneAlpha($this->text[$i])));
            foreach($this->needles as $needle){
                
                if($this->match($needle,$this->text[$i])){
                    
                    //debug("match!");
                    
                    $start = ($i-$this->radius > 0)?($i-$this->radius):0; 
                    $end = ($i+$this->radius < count($this->text))?$i+$this->radius:count($this->text)-1;
                    $segment = $this->array_segment($this->text,$start,$end);
                    
                    $segment = new Segment($segment,$start,$end);
                    $segment->addNeedle($i);
                    $this->segments[] = $segment;
                    
                }
            }
        }
        
    }
    
    function mergeSegments(){
        
        if(count($this->segments)){
            //debug($this->segments);
            for($i = 0; $i<count($this->segments)-1;$i++){
                //debug(count($this->segments));
                //debug($i);
                //debug($i+1);
                if($this->segments[$i]->contains($this->segments[$i+1])){
                    $this->segments[$i+1] = $this->segments[$i]->merge($this->segments[$i+1]);
                    unset($this->segments[$i]);
                }

            }
        }
    }
    
    function stringSegments($segment_limit = 5,$keyword_limit = 10){
        $res = array();
        
        $n_segments = 0;
        $n_keywords = 0;
        
        if($this->segments)
        foreach($this->segments as $segment){
            $n_keywords += $segment->needleCount();
            if($n_segments>$segment_limit) break;
            if($n_keywords>$keyword_limit) break;
            $res[] = $segment->toString();
            $n_segments++;
        }
        return $res;
    }
    
    function match($a,$b){
        return ($this->removeNoneAlpha($a) == $this->removeNoneAlpha($b));
    }
    
    function removeNoneAlpha($a){
        
        $a = strtolower($a);
        $to_replace = array('/',"\\",'[',']','\'','"',".",",",":",";","-","_");
        $a = str_replace($to_replace, "", $a);

        $to_replace = array('á',"é",'í','ó','ú');
        $replace = array('a','e','i','o','u');
        $a = str_replace($to_replace,$replace,$a);
        
        $b = preg_replace("[^A-Za-z]", "", $a );
        return $b;
    }
    
    function array_segment($array,$start,$end){
        
        if($start >= $end ) return Array();
        $start = ($start>0)?$start:0;
        $end = ($end < count($array))?$end:count($array)-1;
        
        $new_array = Array();
        for($i = $start; $i <= $end; $i++){
            $new_array[$i] = $array[$i];
        }
        
        return $new_array;
    }
    
    
}


class Segment{
    
    var $text;
    var $start;
    var $end;
    var $needle_positions;
    var $close_tag;
    var $open_tag;

    
    function Segment($text,$start,$end){
        
        $this->text = $text;
        $this->start = $start;
        $this->end = $end;
        $this->needle_positions = array();
    
    }
    
    function setNeedles($needles){
        $this->needle_positions = $needles;
    }
    
    function addNeedle($needle_position){
        $this->needle_positions[] = $needle_position;
    }
    
    function needleCount(){
        return count($this->needle_positions);
    }
    
    function getStart(){
        return $this->start;
    }
    
    function getEnd(){
        return $this->end;
    }
    
    function contains($segment){
        return ($this->end > $segment->getStart());
    }
    
    function merge($segment){
        
        if($this->contains($segment)){
            
            for($i = $this->getEnd(); $i <= $segment->getEnd(); $i++){
                $this->text[$i] = $segment->text[$i];
            }
            
            $new_segment = new Segment($this->text,$this->getStart(),$segment->getEnd());
            $new_segment->setNeedles(array_merge($this->needle_positions,$segment->needle_positions));
            return $new_segment;
        }
        
        return False;
    }
    
    function toString(){
        
        $this->open_tag = ($this->open_tag)?$this->open_tag:"<b class='highlight'>";
        $this->close_tag = ($this->close_tag)?$this->close_tag:"</b>";
        
        $text_to_string = $this->text;
        foreach($text_to_string as $key => $word){
            if(in_array($key, $this->needle_positions)){
                $text_to_string[$key] = $this->open_tag.$text_to_string[$key].$this->close_tag;
            }
        }
                
        $end = "...";
        $start = "";
        if($this->start > 3) $start = "...";
        return $start.implode(" ",$text_to_string).$end;
        
    }
    
}

?>
