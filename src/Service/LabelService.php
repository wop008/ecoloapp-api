<?php
/**
 * Created by PhpStorm.
 * User: benja
 * Date: 27/03/2019
 * Time: 11:46
 */

namespace App\Service;

use App\Entity\Label;
use App\Entity\Produit;
use Doctrine\Common\Persistence\ObjectManager;

class LabelService
{
    private $em;

    public function __construct(ObjectManager $em) // Voir pour refactor
    {
        $this->em = $em;
    }

    public function createLabel($nom)
    {
        $label = new Label();
        $label->setNom($nom);

        return $label;
    }

    public function createLabelProduit($labels, Produit $produit)
    {
        foreach($labels as $labelNom) {
            if (!empty($labelNom)) {
                $label = $this->existLabelDatabase($labelNom);
                $produit->addLabel($label);
            }
        }

        return $produit;
    }

    public function existLabelDatabase($nom)
    {
        $labelDb = $this->em->getRepository(Label::class)->findOneBy(array('nom' => $nom));
        if(!empty($labelDb))
            return $labelDb;

        return $this->createLabel($nom);
    }
}