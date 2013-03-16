<?php

function prepare_content_ficha($texto, $movil=false) {
    $texto = preg_replace('/\[\[(\d+)\]\]/', site_url((($movil) ? 'movil/' : '') . 'fichas/ver/$1'), $texto);

    if (preg_match('/\{\{youtube:(.*?)\}\}/', $texto)) {
        $pattern = '/\{\{youtube:(.*?)\}\}/';
        $replacement = '<iframe width="600" height="335" src="http://www.youtube-nocookie.com/embed/$1?rel=0" frameborder="0" allowfullscreen></iframe>';
        $texto = preg_replace($pattern, $replacement, $texto);
    }

    if (preg_match('/\{\{vimeo:(.*?)\}\}/', $texto)) {
        $pattern = '/\{\{vimeo:(.*?)\}\}/';
        $replacement = '<iframe src="http://player.vimeo.com/video/$1?title=0&amp;byline=0&amp;portrait=0" width="601" height="338" frameborder="0" webkitAllowFullScreen mozallowfullscreen allowFullScreen></iframe>';
        $texto = preg_replace($pattern, $replacement, $texto);
    }
    
    if (preg_match('/\{\{podcaster:(.*?)\}\}/', $texto)) {
        $pattern = '/\{\{podcaster:(.*?)\}\}/';
        $replacement = '<embed height="62" width="327" flashvars="meta=http://www.podcaster.cl/get_podcast?id=$1" wmode="transparent" quality="high" bgcolor="#FFFFFF" name="podplayer" id="podplayer" src="http://www.podcaster.cl/i/player.swf" type="application/x-shockwave-flash"/>';
        $texto = preg_replace($pattern, $replacement, $texto);
    }

    return $texto;
}

function prepare_search_terms($needle) {

    if (!$needle)
        return "";

    //$needle = leave_alpha_numerical($needle);
    $needle = preg_replace('/[aàáâãåäæAÁ]/iu', '[aàáâãåäæAÁ]', $needle);
    $needle = preg_replace('/[eèéêëEÉ]/iu', '[eèéêëEÉ]', $needle);
    $needle = preg_replace('/[iìíîïÍI]/iu', '[iìíîïÍI]', $needle);
    $needle = preg_replace('/[oòóôõöøÓO]/iu', '[oòóôõöøÓO]', $needle);
    $needle = preg_replace('/[uùúûüUÚ]/iu', '[uùúûüUÚ]', $needle);
    return $needle;
}

function highlight_phrases($content, $needles, $class="highlight") {
    $needles = array_map("prepare_search_terms", $needles);
    $needles = implode("|", $needles);
    if ($needles != "")
        $content = preg_replace("/$needles/ui", "<b class='{$class}'>$0</b>", $content);
    return $content;
}

function leave_alpha_numerical($string) {
    return trim(preg_replace('/[^A-Za-z0-9aàáâãåäæAÁeèéêëEÉiìíîïÍIoòóôõöøÓOuùúûüUÚñ ]/i', '', $string));
}

function debug($string="", $color="black", $whereis = FALSE, $level = 1) {

    $inf = debug_backtrace();

    $info = $inf[$level - 1];

    $file = $info['file'];
    $line = $info['line'];

    //print_r($info3['file']);
    //print_r($info3['line']);

    echo "<pre style='width: 900px; color:$color;'>";
    if ($whereis)
        print_r("<div style='padding: 5px;'><b>Debug:</b> En linea <b>$line</b>, dentro del archivo <b>$file</b></div>");
    echo "<div style='padding-left: 15px;'>";
    print_r($string);
    echo "</div>";
    echo "</pre>";
}

function search_smart_truncate($text, $len, $needles) {
    if (is_array($needles) && count($needles)) {
        return truncatePreserveWords($text, $needles);
    } else {
        if (str_len($txt) > $len) {
            return word_limiter($text, $len);
        }
    }
}

function truncatePreserveWords($text, $needles, $w_near_keywords=30, $class="highlight") {
    $b = explode(" ", trim(strip_tags($text))); //haystack words
    $c = array();      //array of words to keep/remove
    for ($j = 0; $j < count($b); $j++)
        $c[$j] = false;
    for ($i = 0; $i < count($b); $i++)
        for ($k = 0; $k < count($needles); $k++)
            if (stristr($b[$i], $needles[$k])) {
                //$b[$i]=preg_replace("/".$needles[$k]."/i","<$tag $class>\\0</$tag>",$b[$i]);
                for ($j = max($i - $w_near_keywords, 0); $j < min($i + $w_near_keywords, count($b)); $j++)
                    $c[$j] = true;
            }
    $o = ""; // reassembly words to keep
    for ($j = 0; $j < count($b); $j++)
        if ($c[$j])
            $o.=" " . $b[$j]; else
            $o.=".";
    return highlight_phrases(preg_replace("/\.{3,}/i", "...", $o), $needles, $class);
}

/*
  Paul's Simple Diff Algorithm v 0.1
  (C) Paul Butler 2007 <http://www.paulbutler.org/>
  May be used and distributed under the zlib/libpng license.

  This code is intended for learning purposes; it was written with short
  code taking priority over performance. It could be used in a practical
  application, but there are a few ways it could be optimized.

  Given two arrays, the function diff will return an array of the changes.
  I won't describe the format of the array, but it will be obvious
  if you use print_r() on the result of a diff on some test data.

  htmlDiff is a wrapper for the diff command, it takes two strings and
  returns the differences in HTML. The tags used are <ins> and <del>,
  which can easily be styled with CSS.
 */

function diff($old, $new) {
    $maxlen = 0;
    foreach ($old as $oindex => $ovalue) {
        $nkeys = array_keys($new, $ovalue);
        foreach ($nkeys as $nindex) {
            $matrix[$oindex][$nindex] = isset($matrix[$oindex - 1][$nindex - 1]) ?
                    $matrix[$oindex - 1][$nindex - 1] + 1 : 1;
            if ($matrix[$oindex][$nindex] > $maxlen) {
                $maxlen = $matrix[$oindex][$nindex];
                $omax = $oindex + 1 - $maxlen;
                $nmax = $nindex + 1 - $maxlen;
            }
        }
    }
    if ($maxlen == 0)
        return array(array('d' => $old, 'i' => $new));
    return array_merge(
                    diff(array_slice($old, 0, $omax), array_slice($new, 0, $nmax)), array_slice($new, $nmax, $maxlen), diff(array_slice($old, $omax + $maxlen), array_slice($new, $nmax + $maxlen)));
}

function htmlDiff($old, $new) {
    $ret = '';
    $diff = diff(explode(' ', $old), explode(' ', $new));
    foreach ($diff as $k) {
        if (is_array($k))
            $ret .= (!empty($k['d']) ? "<del>" . implode(' ', $k['d']) . "</del> " : '') .
                    (!empty($k['i']) ? "<ins>" . implode(' ', $k['i']) . "</ins> " : '');
        else
            $ret .= $k . ' ';
    }
    return $ret;
}

function comparar($obja, $objb, $field) {
    if ($obja->$field == $objb->$field) {
        return $obja->$field;
    } else {
        return htmlDiff($obja->$field, $objb->$field);
    }
}

