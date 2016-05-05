<?php

namespace Info\FeedbackBundle\Entity;


use Doctrine\ORM\EntityRepository;

class FeedbackRepository extends EntityRepository {

    public function getByParams($params = array())
    {
        $rep = $this->_em->getRepository("InfoFeedbackBundle:Feedback");
        if (isset($params['id']) && intval($params['id']) > 0){
            return $rep->find($params['id']);
        }
        $entities = $rep->createQueryBuilder('m')
            ->orderBy('m.createdAt', 'ASC');
        $p = array();
        $andWeher = false;
        if(isset($params['answered'])){
            $entities->where('m.answered = :a');
            $p['a'] = $params['answered'];
            $andWeher = true;
        }
        if (isset($params['date_from'])){
            $from = new \DateTime();
            $from->setTimestamp(strtotime($params['date_from']));
            if ($andWeher){
                $entities->andWhere('m.createdAt >= :f');
            }else{
                $entities->where('m.createdAt >= :f');
            }
            $p['f'] = $from;
            if (isset($params['date_to'])){
                $to = new \DateTime();
                $to->setTimestamp(strtotime($params['date_to']));
                $to->setTime(23, 59, 59);
                $entities->andWhere('m.createdAt <= :t');
                $p['t'] = $to;
            }
        }
        if (!empty($p)){
            $entities->setParameters($p);
        }

        return $entities->getQuery()->getResult(2);
    }
} 