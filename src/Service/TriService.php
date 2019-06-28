<?php
/**
 * Created by PhpStorm.
 * User: maxim
 * Date: 15/04/2019
 * Time: 14:50
 */

namespace App\Service;

use App\Entity\Produit;
use App\Entity\Emballage;

class TriService
{
    // Tous les conditionnements faits pour ceux ayant + de 50 produits listés + qquns grâce au strpos()

    // Groupement d'emballages poubelle jaune
    const EMBALLAGE_PLASTIQUE = ['plasti', 'kunststoff', 'pet', 'pp', 'pap', '01', '02', '05', '07', '21', '♳', '♷',
        'film', 'bouchon', 'sachet', 'beutel'];
    const EMBALLAGE_CARTON = ['cart', 'brique', 'karton', 'brick', 'cardboard'];
    const EMBALLAGE_PAPIER = ['papier', 'feuille'];
    const EMBALLAGE_METAL = ['métal', 'acier', 'alu', 'conserv', 'konserve', 'can', 'lata'];

    // Groupement d'emballages poubelle verte
    const EMBALLAGE_VERRE = ['verre', 'bocal', 'pot', 'glas', 'vidrio'];

    // Groupement d'emballages allant à la déchetterie
    const EMBALLAGE_BOIS = ['bois'];

    // Le reste en vrac
    const EMBALLAGE_POUBELLE_JAUNE = ['couvercle', 'opercule', 'flacon', 'tetra', 'gourde', 'triman', 'à recycler',
        'recyclable', 'bib'];
    const EMBALLAGE_POUBELLE_NOIRE = ['à jeter', 'capsule', 'tube', 'squeezer', 'bidon', 'bac', 'filet', 'blister',
        'becher', 'sac', 'tüte', 'bolsa', 'bag', 'dosette'];

    public function trashCanChoice(Produit $produit)
    {
        $poubelleJaune = [];
        $poubelleVerte = [];
        $poubelleNoire = [];
        $dechetterie = [];

        $countEmballagesProduit = $produit->getEmballages()->count();
        $countEmballagesInconnus = 0;
        foreach ($produit->getEmballages() as $emballage) {
            if (!$this->foundInCan(self::EMBALLAGE_POUBELLE_NOIRE, $emballage, $poubelleNoire)) {
                if (!$this->foundInCan(self::EMBALLAGE_POUBELLE_JAUNE, $emballage, $poubelleJaune) &&
                !$this->groupEmballages(self::EMBALLAGE_PLASTIQUE, $emballage, $poubelleJaune, 'plastique') &&
                !$this->groupEmballages(self::EMBALLAGE_CARTON, $emballage, $poubelleJaune, 'carton') &&
                !$this->groupEmballages(self::EMBALLAGE_PAPIER, $emballage, $poubelleJaune, 'papier') &&
                !$this->groupEmballages(self::EMBALLAGE_METAL, $emballage, $poubelleJaune, 'métal')) {
                    if (!$this->groupEmballages(self::EMBALLAGE_VERRE, $emballage, $poubelleVerte, 'verre')) {
                        if (!$this->groupEmballages(self::EMBALLAGE_BOIS, $emballage, $dechetterie, 'bois')) {
                            $countEmballagesInconnus++;
                        }
                    }
                }
            }
        }
        if ($countEmballagesProduit === $countEmballagesInconnus) {
            return array();
        }

        $arrayEmballage = array('poubelle_jaune'    =>  $poubelleJaune,
                                'poubelle_verte'    =>  $poubelleVerte,
                                'dechetterie'       =>  $dechetterie,
                                'poubelle_noire'    =>  $poubelleNoire
                                );

        return $arrayEmballage;
    }

    public function foundInCan($emballagesPoubelle, Emballage $emballage, &$tableauFinal)
    {
        foreach ($emballagesPoubelle as $ep) {
            if (strpos($emballage, $ep) !== false) {
                array_push($tableauFinal, $emballage->getNom());
                return true;
            }
        }

        return false;
    }

    /* Regroupe les éléments en fonction de leur nature
       Par exemple, les éléments "pp, pap, 05, 07, 21"
       seront tous regroupés sous le terme "plastique" */
    public function groupEmballages($emballagesPoubelle, Emballage $emballage, &$tableauFinal, $nature)
    {
        foreach ($emballagesPoubelle as $ep) {
            if (strpos($emballage, $ep) !== false && !in_array($nature, $tableauFinal)) {
                array_push($tableauFinal, $nature);
                return true;
            }
        }

        return false;
    }
}
