<?php

/*
 * Smarty plugin
 * -------------------------------------------------------------
 * Type:     modifier
 * Name:     google_highlight
 * Version:  1.0
 * Date:     April 18, 2005
 * Author:   Jeroen de Jong <jeroen@telartis.nl>
 * Purpose:  html safe case insensitive google highlight
 * Comments: based on work by Tom Anderson <toma@etree.org>
 * 
 * Example smarty code:
 *
{assign var=text value="This is a <a href=this>string</a> I want to search through"}
{assign var=search value="this \"to search\" through"}
{$text|google_highlight:$search}
 *
 * -------------------------------------------------------------
 */
function smarty_modifier_google_highlight($text, $search)
{
    $colors = array('#FFFF00','#00FFFF','#99FF99','#FF9999','#FF66FF',
                    '#880000','#00AA00','#886800','#004699','#990099');

    $terms = array();
    preg_match_all('/(".+?"|\S+)/', $search, $m);
    foreach (array_unique($m[0]) as $s) $terms[] = str_replace('"', '', $s);

    $r = $text;
    for ($i = 0; $i < count($terms); $i++) {
        $blocks = preg_split('/(<.+?'.'>)/s', $r, -1,
                             PREG_SPLIT_NO_EMPTY | PREG_SPLIT_DELIM_CAPTURE);
        $r = '';
        for ($j = 0; $j < count($blocks); $j++) {
            if (substr($blocks[$j], 0, 1) != '<') {
                $replace = '<b style="color:'.($i / 5 % 2 ? 'white':'black').
                           ';background-color:'.$colors[$i % 10].'">\\1</b>';
                $blocks[$j] = preg_replace('/('.preg_quote($terms[$i]).')/i', 
                                           $replace, $blocks[$j]);
            }
            $r .= $blocks[$j];
        }
    }
    return $r;
}

?>