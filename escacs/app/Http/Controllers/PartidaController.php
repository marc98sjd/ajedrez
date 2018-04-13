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
 		   echo "<li>'".$disponible->name."'</li>";
		}
		echo "</ul>";
	}
}
