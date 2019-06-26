<?php

namespace App\DataFixtures;

use App\Entity\Address;
use App\Entity\Emballage;
use App\Entity\Label;
use App\Entity\Marque;
use App\Entity\Produit;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use App\Entity\User;

class AppFixtures extends Fixture
{

    private $passwordEncoder;
    private $users = array();
    private $address = array();
    private $emballage = array();
    private $label = array();
    private $marque = array();
    private $produit = array();

    public function __construct(UserPasswordEncoderInterface $passwordEncoder)
    {
        $this->passwordEncoder = $passwordEncoder;
    }

    public function load(ObjectManager $manager)
    {
        // Emballage
        foreach($this->getEmballageData() as [$nom]) {

            $emballage = $this->createEmballage($nom);

            $manager->persist($emballage);
        }

        foreach($this->getLabelData() as [$nom]) {

            $label = $this->createLabel($nom);

            $manager->persist($label);
        }

        foreach($this->getMarqueData() as [$nom]) {

            $marque = $this->createMarque($nom);

            $manager->persist($marque);
        }

        foreach($this->getProduitData() as [$id, $nom, $qte, $origine, $imgUrl, $emballage, $label, $marque]) {

            $produit = $this->createProduit($id, $nom, $qte, $origine, $imgUrl, $emballage, $label, $marque);

            $manager->persist($produit);
        }

        // User
        foreach ($this->getUserData() as [$uid, $firstName, $lastName, $userName, $email, $password, $roles, $produit]) {

            $user = $this->createUser($uid, $firstName, $lastName, $userName, $email, $password, $roles, $produit);

            $manager->persist($user);
            $this->addReference($userName, $user); // J'ai oublié à quoi ça sert ... a check
        }

        // Address
        foreach($this->getAddressData() as [$user, $number, $street, $postalCode, $city]) {

            $address = $this->createAddress($user, $number, $street, $postalCode, $city);

            $manager->persist($address);
        }

        $manager->flush();
    }

    /**
     *
     * @return array address
     */
    private function getAddressData(): array
    {
        return [
            // [user_id, number, street, postal_code, city]
            [$this->users[0], 1, 'rue des saint-bernards', 35700, 'Rennes'],
            [$this->users[1], 7, 'rue des harpistes', 35700, 'Rennes'],
            [$this->users[2], 3, 'place des îles', 35700, 'Rennes']
        ];
    }

    private function createAddress($user, $number, $street, $postalCode, $city)
    {
        $address = new Address();

        $address->setUser($user);
        $address->setNumber($number);
        $address->setStreet($street);
        $address->setPostalCode($postalCode);
        $address->setCity($city);

        array_push($this->address, $address);

        return $address;
    }

    private function getEmballageData(): array
    {
        return [
            ['plastique'],
            ['carton']
        ];
    }

    private function createEmballage($nom)
    {
        $emballage = new Emballage();

        $emballage->setNom($nom);

        array_push($this->emballage, $emballage);

        return $emballage;
    }

    private function getLabelData(): array
    {
        return [
            ['bio'],
            ['label encore plus super ecolo']
        ];
    }

    private function createLabel($nom)
    {
        $label = new Label();

        $label->setNom($nom);

        array_push($this->label, $label);

        return $label;
    }

    private function getMarqueData(): array
    {
        return [
            ['monoprix'],
            ['bio c\'est bon']
        ];
    }

    private function createMarque($nom)
    {
        $marque = new Marque();

        $marque->setNom($nom);

        array_push($this->marque, $marque);

        return $marque;
    }

    private function getProduitData(): array
    {
        return [
            // nom, qte, origine
            ['0492029', 'yaourts bio', 100, 'France', 'http://url1' ,$this->emballage[0], $this->label[0], $this->marque[0]],
            ['32SD323', 'fraises', 21244, 'France', 'http://url2',$this->emballage[1], $this->label[1], $this->marque[1]]
        ];
    }

    private function createProduit($id, $nom, $qte, $origine, $imgUrl, $emballage, $label, $marque)
    {
        $produit = new Produit();

        $produit->setId($id);
        $produit->setNom($nom);
        $produit->setQuantite($qte);
        $produit->setOrigine($origine);
        $produit->setImgUrl($imgUrl);
        $produit->addEmballage($emballage);
        $produit->addLabel($label);
        $produit->addMarque($marque);

        array_push($this->produit, $produit);

        return $produit;
    }

    /**
     * @return array users
     */
    private function getUserData(): array
    {
        return [
            // $userData = [$firstName, $lastName, $username, $email, $password, $roles];
            ['234242TQSSTGDFQSEDQSGDFY', 'François', 'Damien', 'fanch', 'fanch@symfony.com', 'password', ['ROLE_USER'], $this->produit[0]],
            ['dqsozr324HD65t', 'Benjamin', 'Pilorgé', 'admin', 'admin@gmail.com', 'admin', ['ROLE_ADMIN'], $this->produit[1]],
            ['fkeorikg1247df5', 'Ronan', 'Le Guern', 'WaFF', 'waff@waff.com', 'password', ['ROLE_USER'], $this->produit[0]],
        ];
    }

    private function createUser($uid, $firstName, $lastName, $userName, $email, $password, $roles, $produit)
    {
        $user = new User();

        $user->setId($uid);
        $user->setFirstName($firstName);
        $user->setLastName($lastName);
        $user->setUserName($userName);
        $user->setEmail($email);
        $user->setPassword($this->passwordEncoder->encodePassword($user, $password));
        $user->setRoles($roles);
        $user->addProduit($produit);

        array_push($this->users, $user);

        return $user;
    }


}
