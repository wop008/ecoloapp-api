<?php

namespace App\Controller;

use App\Service\ProduitService;
use App\Service\TriService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use App\Service\UtilsService;
use App\Entity\User;
use App\Entity\Produit;
use Zend\Code\Scanner\Util;

class ProduitController extends AbstractController
{
    public function scan(string $uid, string $codebarre)
    {
        $em = $this->getDoctrine()->getManager();

        $produitService = new ProduitService($em); // A revoir... avec le fichier services.yaml ?
        $triService = new TriService();
        $utilsService = new UtilsService();

        $produit = $produitService->scanProduct($codebarre);
        $user = $this->getDoctrine()->getRepository(User::class)->find($uid);

        if($produit instanceof Produit) {
            $user->addProduit($produit);
            $em->persist($user);
            $em->flush();
        } else {
            return new Response($produit);
        }

        $trashCan = $triService->trashCanChoice($produit);
        $response = $utilsService->constructFinalJson($trashCan, $produit);

        return new Response($response);
    }
}
