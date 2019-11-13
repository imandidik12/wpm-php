<?php


namespace Rumus;

use function _\sortBy;
use function _\map;
use function _\reduce;
class Rumus
{
    private $alternatif;
    private $referensiproduk;
    private $criterias;

    public function __construct(array $alternatif, array $referensiproduk)
    {
        $this->alternatif = $alternatif;
        $this->referensiproduk = $referensiproduk;
        $this->set_criterias();
        $this->findminmax();
        $this->findNormalization();
        $this->findwpm();
        $this->get_formatted();
    }
    final public function set_criterias() : void {

        foreach ($this->referensiproduk as $index =>$value){
            foreach ($this->alternatif as $index1=> $alternatif){
                $this->criterias[$index]['values'][] = $alternatif[$index]['value'];
                $this->criterias[$index]['benefical'] = $alternatif[$index]['benefical'];
            }
        }
    }
    final public function findminmax() : void {
        foreach ($this->criterias as $index => $criteria){
            $sorted = sortBy($criteria['values'],[
                static function ($item){
                    return $item;
                }
            ]);
            $this->criterias[$index]['min'] = $sorted[0];
            $this->criterias[$index]['max'] = $sorted[count($sorted)-1];
        }
    }
    final public function findNormalization():void{
        $this->criterias = map($this->criterias,
            static function ($item){
                $operations = $item['benefical'] ?  $item['max'] : $item['min'];
                $benefical = $item['benefical'];
                $item['normalization'] = map($item['values'], static function ($item) use ($operations, $benefical){
                    if ($item<= 1){
                        return (float) number_format((float)$item, 4, '.', '');
                    }
                    if ($benefical){
                        return (float) number_format((float)($item / $operations), 4, '.', '');

                    }
                    return(float) number_format(($operations / $item), 4, '.', '');
                });
                $values = $item['values'];
                $item['values'] = $values;
                return $item;
            }
        );
    }
    final public function findwpm():void{
        $newarr = [];
        foreach ($this->alternatif as $index=> $alternative){
            $this->alternatif[$index]['value'] = map($alternative, static function($item){
                return $item['value'];
            });
            foreach ($this->referensiproduk as $index1=>$value){
                $this->alternatif[$index]['normalization'][] = ($this->criterias[$index1]['normalization'][$index] );
                $this->alternatif[$index]['wpm'][] =
                    (float) number_format((($this->criterias[$index1]['normalization'][$index] ** $value)), 4, '.', '');

            }
            $this->alternatif[$index]['score'] = reduce($this->alternatif[$index]['wpm'],
            static function($result , $item){
                return $result * $item;
            },1);
            $newarr[$index] = [
                'normalization'=>$this->alternatif[$index]['normalization'],
                'values'=>$this->alternatif[$index]['value'],
                'wpm'=>$this->alternatif[$index]['wpm'],
                'score'=>$this->alternatif[$index]['score']
            ];
        }
        $this->alternatif = $newarr;
    }
    final public function get_formatted() : array {
        $c = [];
        foreach ($this->alternatif as $index=> $alternative){
            $string = 'C'.($index+1);
            $c[$string] = $alternative;
        }
        return $c;
    }
}