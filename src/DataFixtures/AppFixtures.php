<?php

namespace App\DataFixtures;

use App\Entity\Ad;
use Faker\Factory;
use App\Entity\Role;
use App\Entity\User;
use App\Entity\Image;
use Cocur\Slugify\Slugify;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class AppFixtures extends Fixture
{
    private $encoder;

    public function __construct(UserPasswordEncoderInterface $encoder)
    {
        $this->encoder = $encoder;
    }
    public function load(ObjectManager $manager)
    {
        
        $faker =  Factory::create('FR-fr');

        $adminRole = new Role();
        $adminRole->setTitle('ROLE_ADMIN');
        $manager->persist($adminRole);

        $adminUser = new User();
        $adminUser->setFirstName('Ayoub')
            ->setLastName('BEN KHADAJ')
            ->setEmail('benkhadajayoub@gmail.com')
            ->setHash($this->encoder->encodePassword($adminUser, 'password'))
            ->setPicture('https://randomuser.me/api/portraits/men/87.jpg')
            ->setIntroduction($faker->sentence())
            ->addUserRole($adminRole);
        $manager->persist($adminUser);

        //Nous gérons les utilisateurs 
        $users = [];
        $genres = ['male','female'];
        for($i=1;$i<=10;$i++)
        {
            $user = new User();
            $genre = $faker->randomElement($genres);

            $picture = 'https://randomuser.me/api/portraits/';
            $pictureId = $faker->numberBetween(1, 99) . '.jpg';

            $picture .= ($genre == 'male' ? 'men/' : 'women/') . $pictureId;
            $hash = $this->encoder->encodePassword($user , 'password');

            $user->setFirstName($faker->firstname($genre))
            ->setLastName($faker->lastname)
            ->setEmail($faker->email)
            ->setIntroduction($faker->sentence())
            ->setHash($hash)
            ->setPicture($picture);


            $manager->persist($user);
            $users[] = $user;
            
        }

        //Nous gérons les annonces 

        $slugify = new Slugify();
        for($i=1;$i<=10;$i++)
        {
            $ad = new Ad();
            $title = $faker->sentence();
            $slug = $slugify->slugify($title);
            $coverImage = $faker->imageUrl(1000,350);
            $introduction = $faker->paragraph(2);
            $date_pub =$faker->dateTime();
            $content = '<p>' . join('</p><p>', $faker->paragraphs(5)) . '</p>' ;

            $user = $users[mt_rand(0,count($users)-1)];

            $ad->setTitle($title)
               ->setSlug($slug)
               ->setCoverImage($coverImage)
               ->setIntroduction($introduction)
               ->setDate_pub($date_pub)
               ->setContent($content)
               ->setAuthor($user);

               for($j=1;$j<=mt_rand(2,5);$j++)
               {
                $image = new Image();
                $image->setUrl($faker->imageUrl())
                      ->setCaption($faker->sentence())
                      ->setAd($ad);
                $manager->persist($image);

               
               }
             $manager->persist($ad);
        }
        
        $manager->flush();
    }

}
