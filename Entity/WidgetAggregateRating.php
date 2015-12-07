<?php
namespace Victoire\Widget\AggregateRatingBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Victoire\Bundle\WidgetBundle\Entity\Widget;

/**
 * WidgetAggregateRating
 *
 * @ORM\Table("vic_widget_aggregaterating")
 * @ORM\Entity
 */
class WidgetAggregateRating extends Widget
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    private $sizesAvailable = array("xl" => "xl", "lg" => "lg", "md" => "md", "sm" => "sm", "xs" => "xs");

    private $messagesAvailable = array(
        "widget_aggregaterating.form.message0.label",
        "widget_aggregaterating.form.message1.label",
        "widget_aggregaterating.form.message2.label",
        "widget_aggregaterating.form.message3.label",
    );

    private $defaultOptions = array(
        'language' => 'fr',
        'stars' => 5,
        'glyphicon' => false,
        'symbol' => '\f005',
        'ratingClass' => 'rating-fa',
        'disabled' => false,
        'readonly' => false,
        'rtl' => false,
        'size' => 'md',
        'showClear' => false,
        'showCaption' => false,
        'starCaptionClasses' => array(
            0.5 => 'label label-danger',
            1 => 'label label-danger',
            1.5 => 'label label-warning',
            2 => 'label label-warning',
            2.5 => 'label label-info',
            3 => 'label label-info',
            3.5 => 'label label-primary',
            4 => 'label label-primary',
            4.5 => 'label label-success',
            5 => 'label label-success'
        ),
        'clearButton' => '<i class="fa fa-minus"></i>',
        'clearButtonBaseClass' => 'clear-rating',
        'clearButtonActiveClass' => 'clear-rating-active',
        'clearCaptionClass' => 'label label-default',
        'clearValue' => null,
        'captionElement' => null,
        'clearElement' => null,
        'containerClass' => null,
        'hoverEnabled' => true,
        'hoverChangeCaption' => true,
        'hoverChangeStars' => true,
        'hoverOnClear' => true,
        'defaultCaption' => '{rating} Stars',
        'starCaptions' => array(
            0.5 => 'Half Star',
            1 => 'One Star',
            1.5 => 'One & Half Star',
            2 => 'Two Stars',
            2.5 => 'Two & Half Stars',
            3 => 'Three Stars',
            3.5 => 'Three & Half Stars',
            4 => 'Four Stars',
            4.5 => 'Four & Half Stars',
            5 => 'Five Stars'
        ),
        'clearButtonTitle' => 'Clear',
        'clearCaption' => 'Not Rated',
    );
    /**
     * @var integer
     *
     * @ORM\Column(name="bestRating", type="integer")
     */
    private $worstRating = 1;

    /**
     * @var integer
     *
     * @ORM\Column(name="worstRating", type="integer")
     */
    private $bestRating = 5;

    /**
     * @var integer
     *
     * @ORM\Column(name="message", type="integer")
     */
    private $message = 1;

    /**
     * @var array
     *
     * @ORM\Column(name="options", type="array")
     */
    private $options = array();

    /**
     * To String function
     * Used in render choices type (Especially in VictoireWidgetRenderBundle)
     * //TODO Check the generated value and make it more consistent
     *
     * @return String
     */
    public function __toString()
    {
        return 'AggregateRating #'.$this->id;
    }

    /**
     * Get id
     *
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }


    /**
     * Get asynchronous
     *
     * @return boolean
     */
    public function getAsynchronous()
    {
        return $this->asynchronous;
    }

    /**
     * Set bestRating
     *
     * @param integer $bestRating
     *
     * @return WidgetAggregateRating
     */
    public function setBestRating($bestRating)
    {
        $this->bestRating = $bestRating;

        return $this;
    }

    /**
     * Get bestRating
     *
     * @return integer
     */
    public function getBestRating()
    {
        return $this->bestRating;
    }

    /**
     * Set message
     *
     * @param integer $message
     *
     * @return WidgetAggregateRating
     */
    public function setMessage($message)
    {
        $this->message = $message;

        return $this;
    }

    /**
     * Get message
     *
     * @return integer
     */
    public function getMessage()
    {
        return $this->message;
    }

    /**
     * Set worstRating
     *
     * @param integer $worstRating
     *
     * @return WidgetAggregateRating
     */
    public function setWorstRating($worstRating)
    {
        $this->worstRating = $worstRating;

        return $this;
    }

    /**
     * Get worstRating
     *
     * @return integer
     */
    public function getWorstRating()
    {
        return $this->worstRating;
    }

    /**
     * Get defaultOptions
     *
     * @return integer
     */
    public function getDefaultOptions()
    {
        return $this->defaultOptions;
    }

    public function getSizesAvailable()
    {
        return $this->sizesAvailable;
    }

    public function getMessagesAvailable()
    {
        return $this->messagesAvailable;
    }

    /**
     * Set options
     *
     * @param array $options
     *
     * @return WidgetAggregateRating
     */
    public function setOptions($options)
    {
        $this->options = $options;

        return $this;
    }

    /**
     * Get options
     *
     * @return array
     */
    public function getOptions()
    {
        return array_merge($this->getDefaultOptions(), $this->options);
    }
}
