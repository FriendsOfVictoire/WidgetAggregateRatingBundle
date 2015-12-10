<?php
namespace Victoire\Widget\AggregateRatingBundle\Repository;

use Doctrine\ORM\EntityRepository;
use Victoire\Widget\AggregateRatingBundle\Entity\Rating;

class RatingRepository extends EntityRepository
{
    public function findOneOrCreate(array $criteria)
    {
        $rating = $this->findOneBy($criteria);
        if(!$rating)
        {
            $rating = new Rating();
            foreach($criteria as $key => $value)
            {
                $setter = 'set'.ucfirst($key);
                $rating->$setter($value);
            }
        }
        return $rating;
    }
}