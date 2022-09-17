<?php

namespace App\DataFixtures;

use App\Entity\Article;
use App\Entity\Category;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;

class ArticleFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        for ($i=1; $i <5 ; $i++) { 
            $category = new Category();
            $category->setTitre("sport $i")
                     ->setContent("content $i");
            $manager->persist($category);
    
    
            for ($j=0; $j < 4; $j++) { 
               $article = new Article();
               $article->setTitre(" Article $j")
                       ->setImage("https://picsum.photos/500/200?grayscale") 
                       ->setDescription("L’industrie du sport est un vaste secteur qui s’étend de
                       la vente de produits alimentaires aux souvenirs en passant
                        par la cession de droits aux médias et les partenariats.
                         De nombreux acteurs sont concernés : les clubs, les ligues, 
                         les partenaires, les radiodiffuseurs et bien sûr les entreprises
                          qui fabriquent tous 
                      les équipements qui permettent aux athlètes de pratiquer des sports 
                      de haut niveau ")
                      ->setCategory($category);
                      $manager->persist($article);         
    
    
            }
            
           }
        $manager->flush();
    }
}
