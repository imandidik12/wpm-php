<?php


namespace Rumus;
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

use stdClass;
use Tightenco\Collect\Support\Collection;
class Rumus
{
    public $preferences;
    public $alternatives;
    public $benefical_index;

    public $s_vector;
    public $s_total;

    public $v_vector;

    public $formatted_v;
    public $formatted_s;


    public function __construct(array $alternatif, array $preferences, array $benefical_index = [])
    {
        $alternatif = collect($alternatif)->map(static function( array $entry, $index) use ($preferences){
            if (count($entry)!== count($preferences)){
                dd('Preferences must be same as entry criterias at alternative : '.$index);
            }
            $obj = new stdClass();
            $obj->criterias = $entry;
            return $obj;
        });


        $this->alternatives = $alternatif;
        $this->benefical_index = $benefical_index;
        $this->formatted_s = new stdClass();
        $this->formatted_v = new stdClass();

        $this->set_normalize_preferences(collect($preferences));
        $this->set_s_vector();
        $this->set_v_vector();


    }

    final public function set_normalize_preferences( $collection ):void{
        $total = $collection->reduce(static function($reducer, $entry){
            return $entry + $reducer;
        },0);

        $preferences = new stdClass();
        $preferences->normalized = $collection->map(static function ($entry) use ($total){
            return $entry / $total;
        });
        $preferences->unormalized = $collection;
        $this->preferences = $preferences;
    }

    final public function set_s_vector(): void {
        $preferences = $this->preferences->normalized;
        $benefical =collect($this->benefical_index);
        $vector = [];
        foreach ($this->alternatives as $name=> $alternative){
            $arr = [];
            $this->formatted_s->$name = new stdClass();
            foreach ($preferences as $index=>$value){
                $check = $benefical->first(static function($item) use ($index) {return $index === $item-1; });
                $val = ($alternative->criterias[$index]) ** ($check?'-'.$value:$value);
                $arr [] = $val;
                $Sname = 'S'.($index+1);
                $this->formatted_s->$name->$Sname = $val;
            }
            $vector[]= $arr;
        }
        $this->s_vector = $vector;
    }

    final public function set_v_vector(): void {
        $s_vector = $this->formatted_s;
        $vectors = [];
        $total = 0;

        foreach ($this->alternatives as $name=>$value){
            $s_vector_total = collect($s_vector->$name)->reduce( static function($reducer, $item){return $item*$reducer;} ,1);
            $vectors[$name] = $s_vector_total;
            $total +=$s_vector_total;
        }

        $this->s_total = $total;

        foreach ($vectors as $index=>$vector){
            $this->v_vector[$index]['s_score'] = $vector;
            $this->v_vector[$index]['v_score'] = $vector / $total;
        }
    }

    final public function get_formatted(){

        $s = $this->formatted_s;
        $toreturn = [];

        foreach ($this->alternatives as $name=>$value){
            $toreturn[$name]['criterias'] = [];
            foreach ($value->criterias as $index=>$_value ){
                $string = 'C'.($index+1);
                $toreturn[$name]['criterias'][$string] = $_value;
            }
            $toreturn[$name]['normalized'] = (array) $s->$name;
            $toreturn[$name]['score'] = $this->v_vector[$name];

        }

        $toreturn = collect($toreturn);
        Collection::macro('sortbybest', function() use ($toreturn){
           return $toreturn->sortByDesc(static function($item){
              return $item['score']['v_score'];
           });
        });
        Collection::macro('sortbyleast', function() use ($toreturn){
            return $toreturn->sortbybest()->reverse();
        });

        return $toreturn;
    }
}