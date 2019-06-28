<?php
/**
 * Created by PhpStorm.
 * User: benja
 * Date: 27/03/2019
 * Time: 11:47
 */

namespace App\Service;

use App\Entity\Marque;
use App\Entity\Produit;
use Doctrine\Common\Persistence\ObjectManager;

class MarqueService
{
    public function __construct(ObjectManager $em)
    {
        $this->em = $em;
    }

    public function createMarque($nom)
    {
        $marque = new Marque();
        $marque->setNom($nom);

        return $marque;
    }

    public function createMarqueProduit($marques, Produit $produit)
    {
        foreach ($marques as $marquesNom) {
            if (!empty($marquesNom)) {
                $marque = $this->existMarqueDatabase($marquesNom);
                $produit->addMarque($marque);
            }
        }

        return $produit;
    }

    public function existMarqueDatabase($nom)
    {
        $marqueDb = $this->em->getRepository(Marque::class)->findOneBy(array('nom' => $nom));
        if (!empty($marqueDb)) {
            return $marqueDb;
        }

        return $this->createMarque($nom);
    }
}
