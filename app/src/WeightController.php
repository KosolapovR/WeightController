<?php

namespace WC;
require_once dirname(dirname(__DIR__)) .'/vendor/autoload.php';
/**
 * selects data from the database and converts it 
 * to JSON format depending on the parameters passed
 */
class WeightController 
{
    const BYDAY = 1;
    const BYWEEK = 2;
    const BYMONTH = 3;
    /**
     * 
     * @var \DateTime
     */
    private $date_start;
    /**
     *
     * @var \DateTime 
     */
    private $date_end;
    /**
     *
     * @var \WC\User  
     */
    private $user;
    /**
     *
     * @var \Envms\FluentPDO\Query 
     */
    private $fpdo;

    /**
     * getting DBconnection, define user
     * @param \WC\User $user
     */
    public function __construct(User $user)
    {
        $this->fpdo = DBconnect::getInstance();
        $this->user = $user;   
    }
    /**
     * Depending on the specified data about the time and detail of the selection, returns a JSON object
     * @example /app/index.php How to use this function
     * @param \DateTime $date_start
     * @param \DateTime $date_end
     * @param int $detalization
     * @return string JSON data
     */
    public function getAvgWeightВetweenDates(\DateTime $date_start, \DateTime $date_end, $detalization = self::BYDAY): String
    {
        $average_weight = [];
        $this->date_start = $date_start;
        $this->date_end = $date_end;
        switch ($detalization){
            case (self::BYDAY):{
                $result = $this->createQuery('date');
                foreach($result as $row){
                    $average_weight[$row[date]] = round($row[avg], 2);
                }
                break;
            }
            case self::BYWEEK:{
                $result = $this->createQuery('week');
                foreach($result as $row){
                    $date = new \DateTime($row[date]);
                    $average_weight[$date->format('W')] = round($row[avg], 2);
                }
                break;
            }
            case self::BYMONTH:{
                $result = $this->createQuery('month');
                foreach($result as $row){
                    $date = new \DateTime($row[date]);
                    $average_weight[$date->format('m')] = round($row[avg], 2);
                }
                break;
            }
        }
        return json_encode($average_weight);
    }
    /**
     * 
     * @param type $detalization
     * @return array
     */
    private function createQuery($detalization): array
    {
        $query = $this->fpdo->from('users')
                     ->innerJoin('weight_data ON weight_data.user_id = users.id')
                     ->select('AVG(weight_data.weight) as avg')
                     ->select ('weight_data.date')
                     ->where('weight_data.date >= ?',  $this->date_start->format('Y-m-d'))
                     ->where('weight_data.date <= ?',  $this->date_end->format('Y-m-d'))
                     ->where('weight_data.user_id = ?', $this->user->getId())
                     ->groupBy($detalization. "(weight_data.date)");
     
        return $query->fetchAll();
    }
}

