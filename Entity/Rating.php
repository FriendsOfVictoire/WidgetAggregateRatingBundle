<?php

namespace Victoire\Widget\AggregateRatingBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;


/**
 * Rating
 *
 * @ORM\Table("vic_widget_aggregaterating_rating")
 * @ORM\Entity(repositoryClass="Victoire\Widget\AggregateRatingBundle\Repository\RatingRepository")
 */
class Rating
{
    /**
     * @var integer
     * @ORM\Column(name="value", type="decimal", precision=2, scale=1)
     */
    private $value;

    /**
     * @var integer
     * @ORM\Id
     * @ORM\Column(name="businessEntityId", type="string")
     */
    private $businessEntityId;

    /**
     * @var integer
     * @ORM\Id
     * @ORM\Column(name="entityId", type="integer")
     */
    private $entityId;

    /**
     * @var string
     * @ORM\Id
     * @Gedmo\IpTraceable(on="create")
     * @ORM\Column(name="ipAddress", type="string", length=255)
     */
    private $ipAddress;

    /**
     * Set value
     *
     * @param integer $value
     *
     * @return Rating
     */
    public function setValue($value)
    {
        $this->value = $value;

        return $this;
    }

    /**
     * Get value
     *
     * @return integer
     */
    public function getValue()
    {
        return $this->value;
    }

    /**
     * Set ipAddress
     *
     * @param string $ipAddress
     *
     * @return Rating
     */
    public function setIpAddress($ipAddress)
    {
        $this->ipAddress = $ipAddress;

        return $this;
    }

    /**
     * Get ipAddress
     *
     * @return string
     */
    public function getIpAddress()
    {
        return $this->ipAddress;
    }

    /**
     * Set businessEntityId
     *
     * @param string $businessEntityId
     *
     * @return Rating
     */
    public function setBusinessEntityId($businessEntityId)
    {
        $this->businessEntityId = $businessEntityId;

        return $this;
    }

    /**
     * Get businessEntityId
     *
     * @return string
     */
    public function getBusinessEntityId()
    {
        return $this->businessEntityId;
    }

    /**
     * Set entityId
     *
     * @param integer $entityId
     *
     * @return Rating
     */
    public function setEntityId($entityId)
    {
        $this->entityId = $entityId;

        return $this;
    }

    /**
     * Get entityId
     *
     * @return integer
     */
    public function getEntityId()
    {
        return $this->entityId;
    }
}
