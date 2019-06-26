<?php
/**
 * Created by PhpStorm.
 * User: WOPII
 * Date: 12/09/2018
 * Time: 22:22
 */

namespace App\Repository;

use App\Entity\Address;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

class AddressRepository extends ServiceEntityRepository
{

    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Address::class);
    }







}