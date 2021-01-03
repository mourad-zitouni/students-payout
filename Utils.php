<?php
namespace Payout;

trait Utils {
    public function computeDistance($first, $second) {
        $firstParams = $this->getLocationParams($first);
        $secondParams = $this->getLocationParams($second);

        $x = $firstParams[0] - $secondParams[0];
        $y = $firstParams[1] - $secondParams[1];

        return sqrt($x * $x + $y * $y);

    }

    private function getLocationParams($text) {
        return explode(',', (int)strtr($text, array('(' => '', ')' => '')));
    }

    public function getDayPayout($status, $params) {
        $payout = 0;

        switch ($status) {
          case 'AT':
            $payout = $params['basicRate'] + $params['meal'];
            if($params['distance'] > 5) {
              $payout += $params['travel'];
            }
            break;
          case 'AL':
          case 'CSL':
            $payout = $params['basicRate'];
            break;
          case 'USL':
            $payout = 0;
            break;
          
        }
      
        return $payout;
      }
}