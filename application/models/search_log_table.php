<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

class SearchLogTable extends Doctrine_Table {
    function getMasBuscados($limit = False) {
        $query = Doctrine_Query::create();
        $query->select('COUNT(*) AS cnt, search_query');
        $query->from('SearchLog');
        $query->groupby('search_query');
        $query->orderby('cnt DESC');
        if($limit) $query->limit( $limit );

        $result = $query->execute();
        return $result;
    }
}