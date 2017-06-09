<?php

namespace honeysec\Http\Controllers;

use Illuminate\Http\Request;
use honeysec\Honey_Game;
use honeysec\Honey_Node;

class DefenderController extends Controller
{
    
    
    private function uniRand($gid){
        $game = Honey_Game::find($gid);
        
        $honey_nodes = Honey_Node::inGameID($gid)->get();
        echo $honey_nodes[3]['x_axis']."    ";
        foreach($honey_nodes as $key => $i){
            echo "($key,".$i['gid'].")   ";
        }
        //echo "<script type='text/javascript'>alert('Hello World');</script>";
    }
    
    public function __invoke(Request $request, $dtype, $gid)
    {
        if($dtype === "uni"){
            $this->uniRand($gid);
        }
        //echo "<script type='text/javascript'>alert('Hello World');</script>";
        $data = [
            "name" => "Hello World",
            "details" => "If you can see this, it works!"
        ];
        return response()->json($data);
    }
    
    private function remainingNodes($budget, $nodes){
        $remaining_nodes = array();
        foreach($nodes as $i){
            if($i['def_cost'] <= $budget){
                $remaining_nodes[] = $i;
            }
        }
        return $remaining_nodes;
    }
    
}
