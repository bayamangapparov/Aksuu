<?php
namespace Info\FeedbackBundle\Model;

use Symfony\Component\DependencyInjection\ContainerInterface;

class FeedbackModel {
    /**
     * @var ContainerInterface
     *
     * @api
     */
    private $container;

    public function __construct( $container ){
        $this->container = $container;
    }


}