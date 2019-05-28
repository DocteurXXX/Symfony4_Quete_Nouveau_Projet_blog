<?php

namespace App\Service;



class Slugify
{
    public function generate(string $input) : string
    {

        //Remplacement toute lettre avec accent, ...
        $input = str_replace(array("à","ç","é","è","ê","ë","û","ù","î","ï","ô"), array("a","c","e","e","e","e","u","u","i","i","o"), $input);

        //Suppression espace en début et fin de chaine
        $input = ltrim(rtrim($input," ")," ");

        //Minuscule + remplacement espace par -
        $input = strtolower(str_replace(" ", "-", $input));

        //Suppression ponctuation (sauf -)
        $input = preg_replace("/[^a-z-]+/i","",$input);

        // Pas de - successifs
        $input = preg_replace("/[ -]+/","-",$input);

        //Suppression - en début et fin de chaine
        $input = ltrim(rtrim($input,"-"),"-");

        return $input;


    }
}
