<?php
namespace phpai;

class Apriori
{
    /**
     * An array (dataset) will be used for train
     * @var array
     */
    private $data;

    /** Is given data is sparse matrix
     * @var bool
     */
    private $sparse;

    /** Support tables for apriori algorithm
     * @var array
     */
    private $tables;


    /** Unique items in dataset
     * @var array
     */
    private $uniques;

    /** Minimum support value
     * @var int
     */
    private $min_support;

    /**
     * Class constructor
     * @param bool $sparse
     * @param array $data
     */
    public function __construct(bool $sparse = false, array $data)
    {
      $this->data = $data;
      $this->sparse = $sparse;
      $this->tables = array();
      $this->uniques = array_unique($this->flatten($data));
      $this->min_support = $this->calculate_min_supports();
    }


    /**
     * Fit/Train Given data with Apriori algorithm
     * @param array $data
     */
    public function fit() : array
    {

        $uniques = array_unique(self::flatten($this->data));
        $keep = true;
        $counter = 0;
        while ($keep === true) {
            $tables = $this->tables;
            $items = $this->extract_table_items(count($tables)-1);
            $table = count($this->tables) === 0 ? array($uniques) : array_map(null, ...$items);;

            $set = array_merge($table, array($uniques));
            $cart = $this->cartesian($set);
            $supports = self::support($cart);

            if(count($supports) > 0){
                $this->tables = array_merge($this->tables,
                                            array(
                                                    $counter => $supports
                                            )
                );
            }else{
                $keep = false;
            }
            $counter += 1;
        }

        return $this->tables;
    }

    /**
     * Method for calculating minimum support for
     * given dataset
     * @return array|int
     */
    public function calculate_min_supports(): int
    {
        $flatten = $this->flatten($this->data);
        $counts = array_count_values($flatten);
        return min($counts) > 1 ? min($counts) : 2;
    }

    /**
     * Extract only items from tables wıth given index
     * @param $level index
     * @return array
     */
    private function extract_table_items($index): array
    {
        $result = array();
        foreach ($this->tables[$index] ?: [] as $key => $value){
            $result = array_merge($result, array($value['items']));
        }

        return $result;
    }


    /**
     * Taking cartesian of given array values
     * @param $set
     * @return int
     */
    public function cartesian($set): array
    {
        if (!$set) {
            return array(array());
        }

        $subset = array_shift($set);
        $cartesianSubset = self::cartesian($set);

        $result = array();
        foreach ($subset as $value) {
            foreach ($cartesianSubset as $p) {
                array_unshift($p, $value);
                $result[] = $p;
            }
        }

        return $result;
    }


    /**
     * Support calculation
     * @param array $table
     * @return array
     */
    private function support(array $table): array
    {

        $r_table = array();
         foreach ($table as $key => $value){
             $support = 0;
             foreach ($this->data as $r => $row){
                $intersect = array_intersect($row, $value);
                if(count($intersect) === count($value)){
                    $support += 1;
                }
            }
            $key = implode('-:-',$value);
            $single = array(
                        $key =>array(
                                'items' => $value,
                                'support' => $support
                            )
                    );
            $r_table = array_merge($r_table, $single);
        }
        return $this->remove_less_ms($r_table);
    }

    /**
     * Function that return table items those have support value greater
     * than min support value
     * @param $table
     * @return array
     */
    private function remove_less_ms($table): array
    {
       return array_filter($table , function ($k) {
            return $k['support'] >= $this->min_support;
        });
    }

    /**
     * Function that flats given array
     * @param $array
     * @return array
     */
    private function flatten($array): array
    {

        $result = array();

        foreach ($array as $key => $value) {
            if (is_array($value)) {
                $result = array_merge($result, $this->flatten($value));
            } else {
                $result = array_merge($result, array($key => $value));
            }
        }

        return $result;
    }
}