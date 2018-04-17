<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;

class PartidaController extends Controller
{

	public function disponible($token){
		$disponibles = DB::table('users')->where([
		    ['remember_token', '<>', ''],
		    ['remember_token', '<>', $token],
		])->get();

		echo "<ul>";
		foreach ($disponibles as $disponible) {
 		   	echo "<li>".$disponible->name."</li>";
		}
		echo "</ul>";
	}

	public function jugar($name,$token){

		if(
		DB::table('users')->where([
		    ['name', '=', $name],
		    ['remember_token', '<>', ''],
		    ['remember_token', '<>', $token],
		])->exists()){
			
			echo "La partida ha sido creada!";

			$j1 = DB::table('users')->where('remember_token', $token)->first();
			$j2 = DB::table('users')->where('name', $name)->first();

			DB::table('partidas')->insert(
   				['jugador1' => $j1->id, 'jugador2' => $j2->id]
			);

		}else{
			echo "Ningun usuario disponible con ese nombre.";
		}
	}
}