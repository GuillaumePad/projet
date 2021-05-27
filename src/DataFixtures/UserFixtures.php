<?php

namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class UserFixtures extends Fixture
{
    private $encoder;
    public function __construct(UserPasswordEncoderInterface $encoder)
    {
        $this->encoder = $encoder;
    }
    public function load(ObjectManager $manager)
    {
        $user = new User();
        $user->setPseudo('util');
        $user->setEmail('aaa@gmail.com');
        $user->setRoles(["ROLE_USER"]);

        $originePassword= "pass";
        $encodedPassword=$this->encoder->encodePassword($user, $originePassword);
        $user->setPassword($encodedPassword);
        $manager->persist($user);

        $user = new User();
        $user->setPseudo('admin');
        $user->setEmail('zzz@gmail.com');
        $user->setRoles(["ROLE_ADMIN"]);

        $originePassword= "pass";
        $encodedPassword=$this->encoder->encodePassword($user, $originePassword);
        $user->setPassword($encodedPassword);
        $manager->persist($user);


        $manager->flush();
    }
}
