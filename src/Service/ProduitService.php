<?php
/**
 * Created by PhpStorm.
 * User: benja
 * Date: 27/03/2019
 * Time: 11:21
 */

namespace App\Service;

use App\Entity\Produit;
use Doctrine\Common\Persistence\ObjectManager;

class ProduitService
{
    private $apiService;
    private $emballageService;
    private $labelService;
    private $marqueService;

    public function __construct(ObjectManager $em)
    {
        $this->em = $em; // Voir pour refactor
        $this->apiService = new APIService();
        $this->emballageService = new EmballageService($em);
        $this->labelService = new LabelService($em);
        $this->marqueService = new MarqueService($em);
    }

    public function scanProduct(string $codebarre)
    {
        $response = $this->apiService->getProduit($codebarre);  // réponse api
        if(!$this->apiService->produitExists($response))
        {
            http_response_code(404);
            return 'Le produit n\'a pas été trouvé';
        }
        $responseFormated = $this->apiService->formatProduitResponse($response); // réponse formaté

        $produit = $this->existProduitDatabase($codebarre);
        if(empty($produit))
        {
            $produit = $this->createProduit($codebarre, $responseFormated['nom'], $responseFormated['origine'], $responseFormated['imgUrl'],$responseFormated['qte']);  // Création produit

            // A vérifier si ça fonctionne correctement l'hydratation de l'objet produit
            $this->labelService->createLabelProduit($responseFormated['labels'], $produit); // Ajout labels produit
            $this->marqueService->createMarqueProduit($responseFormated['marques'], $produit);  // Ajout marques produit
            $this->emballageService->createEmballageProduit($responseFormated['emballages'], $produit); // Ajout emballages produit
        }

        return $produit;
    }

    public function createProduit($id, $nom, $origine, $img_url, $qte = 0, $emballage = null, $label = null, $marque = null)
    {
        $produit = new Produit();

        $produit->setId($id);
        $produit->setNom($nom);
        $produit->setOrigine($origine);
        $produit->setQuantite($qte);
        $produit->setImgUrl($img_url);

        if (!empty($emballage)) {
            $produit->addEmballage($emballage);
        }

        if(!empty($label)) {
            $produit->addLabel($label);
        }

        if(!empty($marque)) {
            $produit->addMarque($marque);
        }

        return $produit;
    }

    public function existProduitDatabase($codebarre)
    {
        $produitDb = $this->em->getRepository(Produit::class)->find($codebarre);

        return $produitDb;
    }
}