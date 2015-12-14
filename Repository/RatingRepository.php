<?php
namespace Victoire\Widget\AggregateRatingBundle\Repository;

use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\QueryBuilder;
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
            $rating->setValue($this->getRatingValues([
                'businessEntityId' => $criteria['businessEntityId'],
                'entityId' => $criteria['entityId']
            ])['ratingRound']);
        }
        return $rating;
    }

    public function filterByCriteria(QueryBuilder $qb, array $criteria)
    {
        foreach($criteria as $key => $value)
        {
            $qb->andWhere('rating.'.$key.' = :'.$key)
                ->setParameter(':'.$key, $value);

        }
        return $qb;
    }

    public function getRatingValues(array $criteria)
    {
        $qb = $this->createQueryBuilder('rating')
            ->select('avg(rating.value) as ratingRound, count(rating) as ratingNumber');
        $qb = $this->filterByCriteria($qb, $criteria);

        return $qb->getQuery()->getResult()[0];
    }
}