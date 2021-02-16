<?php

namespace App\DataFixtures;

use App\Entity\RealEstate;
use App\Entity\Type;
use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\String\Slugger\SluggerInterface;

class AppFixtures extends Fixture
{
    private $slugger;
    private $passwordEncoder;

    public function __construct(SluggerInterface $slugger, UserPasswordEncoderInterface $passwordEncoder){
        $this->slugger = $slugger;
        $this->passwordEncoder = $passwordEncoder;
    }




    public function load(ObjectManager $manager)
    {
        $faker = Factory::create('fr_FR');


        $user = new User();
        $user->setEmail('test@test.fr');
        $user->setPassword($this->passwordEncoder->encodePassword($user, 'test'));
        $user->setRoles(['ROLE_ADMIN']);
        $this->addReference('user-0', $user);

        $manager->persist($user);




    for($i = 1; $i <= 9; $i++){
        $user = new User();
        $user->setEmail($faker->email);
        $user->setPassword($this->passwordEncoder->encodePassword($user, 'test'));
        $this->addReference('user-'.$i, $user);
        $manager->persist($user);
    }




        $typeNames = ['Maison', 'Appartement', 'Villa', 'Garage', 'studio'];
        foreach ($typeNames as $key => $typeName){
            $type = new Type();
            $type->setName($typeName);
            $this->addReference('type-'.$key, $type);
            $manager->persist($type);
        }

        for($i = 1; $i <= 30; $i++){
            $realEstate = new RealEstate();
            $type = $this->getReference('type-'.rand(0,count($typeNames)-1));
            $title = ucfirst($type->getName()).' ';

            $rooms = $faker->numberBetween(1, 5);
            $title .= RealEstate::SIZES[$rooms];


            $realEstate->setTitle($title);
            $realEstate->setSlug($this->slugger->slug($title)->lower());
            $realEstate->setDescription($faker->text(2000));
            $realEstate->setSurface($faker->numberBetween(10, 400));
            $realEstate->setPrice($faker->numberBetween(35000, 600000));
            $realEstate->setRooms($rooms);
            $realEstate->setType($type);
            $realEstate->setSold($faker->boolean(10));
            $realEstate->setImage($faker->randomElement([
                'default.png', 'fixtures/1.jpg', 'fixtures/2.jpg', 'fixtures/3.jpg'
            ]));

            $realEstate->setOwner($this->getReference('user-'.rand(0, 9)));
            $manager->persist($realEstate);

        }
        $manager->flush();
    }
}
