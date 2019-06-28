<?php
/**
 * Created by PhpStorm.
 * User: benja
 * Date: 27/03/2019
 * Time: 11:40
 */

namespace App\Service;

use App\Entity\Emballage;
use App\Entity\Produit;
use Doctrine\Common\Persistence\ObjectManager;

class EmballageService
{
    public function __construct(ObjectManager $em)
    {
        $this->em = $em;
    }

    public function createEmballage($nom)
    {
        $emballage = new Emballage();
        $emballage->setNom($nom);

        return $emballage;
    }

    public function createEmballageProduit($emballages, Produit $produit)
    {
        foreach ($emballages as $emballageNom) {
            if (!empty($emballageNom)) {
                $emballage = $this->existEmballageDatabase($emballageNom);
                $produit->addEmballage($emballage);
            }
        }

        return $produit;
    }

    public function existEmballageDatabase($nom)
    {
        $emballageDb = $this->em->getRepository(Emballage::class)->findOneBy(array('nom' => $nom));
        if (!empty($emballageDb)) {
            return $emballageDb;
        }

        return $this->createEmballage($nom);
    }
}
