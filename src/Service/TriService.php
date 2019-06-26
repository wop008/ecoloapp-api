<?php
/**
 * Created by PhpStorm.
 * User: maxim
 * Date: 15/04/2019
 * Time: 14:50
 */

namespace App\Service;

use App\Entity\Produit;

class TriService
{
    const EMBALLAGE_POUBELLE_JAUNE = ['plastique', 'carton', 'papier', 'métal', 'acier', 'aluminium', 'bouchon', 'kunststoff', 'plastic', 'conserve', 'brique',
        'couvercle', 'film', 'opercule', 'flacon', 'bouchon', 'canette', 'flasche', 'plastico', 'karton', 'sachet', 'tetra', 'pet', 'gourde', 'box',
        'triman', 'feuille', 'beutel', 'à recycler', 'plastik', 'cardboard'];
    const EMBALLAGE_POUBELLE_VERTE = ['verre', 'pot', 'glas', 'glass'];
    ///////// A voir par la suite /////////
    const EMBALLAGE_DECHETTERIE = ['bois'];
    ///////////////////////////////////////
    const EMBALLAGE_POUBELLE_NOIRE = ['à jeter', 'capsule', 'tube', 'squeezer', 'pp', 'bidon', 'bac', 'filet', 'blister', 'becher', 'sac', 'tüte', 'bolsa'];
    // Voir le cas où certains emballages sont utiles si tout seuls, e.g. bouteille, barquette
    const EMBALLAGE_NON_UTILE = ['frais', 'bottle', 'bouteille', 'barquette', 'boîte', 'surgele', 'surgeles', 'sous atmosphère protectrice', 'etui', 'sous vide',
        'stuck', 'produkt', 'point vert', 'pensez au tri', 'paquet', 'product', 'green dot', 'pap', 'dose', 'doypack', 'tablette', 'producto', 'decongele',
        'produit', 'refrigere', 'pack', 'packung', 'refrigerado'];

    // Faire différents cas par rapport à certains emballages ? -> e.g. boîte, différencier carton, métal, autre
    public function trashCanChoice(Produit $produit)
    {
        $poubelleJaune = [];
        $poubelleVerte = [];
        $poubelleNoire = [];

        foreach ($produit->getEmballages() as $emballage)
        {
            $foundInPN = false;
            $foundInPJ = false;
            if(!in_array($emballage, self::EMBALLAGE_NON_UTILE))
            {
                //Va falloir refacto là
                foreach (self::EMBALLAGE_POUBELLE_NOIRE as $noire)
                {
                    if(strpos($emballage, $noire))
                    {
                        array_push($poubelleNoire, $emballage);
                        $foundInPN = true;
                        break;
                    }
                }
                if(!$foundInPN) {
                    foreach (self::EMBALLAGE_POUBELLE_JAUNE as $jaune) {
                        if (strpos($emballage, $jaune) !== false) {
                            array_push($poubelleJaune, $emballage);
                            $foundInPJ = true;
                            break;
                        }
                    }
                    if (!$foundInPJ) {
                        foreach (self::EMBALLAGE_POUBELLE_VERTE as $verte) {
                            if (strpos($emballage, $verte) !== false) {
                                array_push($poubelleJaune, $emballage);
                                break;
                            }
                        }
                    }
                }
            }
        }

        echo 'Poubelle Jaune<br /><br />';
        foreach ($poubelleJaune as $recyc)
        {
            echo $recyc.'<br />';
        }
        echo '<br />Poubelle Verte<br /><br />';
        foreach ($poubelleVerte as $verre)
        {
            echo $verre.'<br />';
        }
        echo '<br />Poubelle Noire<br /><br />';
        foreach ($poubelleNoire as $dechet)
        {
            echo $dechet.'<br />';
        }
        die();

        $arrayEmballage = array('poubelle_jaune'    =>  $poubelleJaune,
                                'poubelle_verte'    =>  $poubelleVerte,
                                'poubelle_noire'    =>  $poubelleNoire
                                );

        return $arrayEmballage;
    }
}