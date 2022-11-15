<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\Copy;
use App\Models\Lending;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;


class LendingController extends Controller
{
    //
    public function index(){
        $lendings =  Lending::all();
        return $lendings;
    }

    public function show ($user_id, $copy_id, $start)
    {
        $lending = Lending::where('user_id', $user_id)->where('copy_id', $copy_id)->where('start', $start)->get();
        return $lending[0];
    }
    public function destroy($user_id, $copy_id, $start)
    {
        LendingController::show($user_id, $copy_id, $start)->delete();
    }

    public function store(Request $request)
    {
        $lending = new Lending();
        $lending->user_id = $request->user_id;
        $lending->copy_id = $request->copy_id;
        $lending->start = $request->start;
        $lending->save();
    }

    public function update(Request $request, $user_id, $copy_id, $start)
    {
        $lending = LendingController::show($user_id, $copy_id, $start);
        $lending->user_id = $request->user_id;
        $lending->copy_id = $request->copy_id;
        $lending->start = $request->start;
        $lending->save();
    }

    public function userLendingsList()
    {
        $user = Auth::user();	//bejelentkezett felhasználó
        $lendings = Lending::with('user_c')->where('user_id','=', $user->id)->get();
        return $lendings;
    }

    public function userLendingsCount()
    {
        $user = Auth::user();	//bejelentkezett felhasználó
        $lendings = Lending::with('user_c')->where('user_id','=', $user->id)->distinct('copy_id')->count();
        return $lendings;
    }

    //view-k:
    public function newView()
    {
        //új rekord(ok) rögzítése
        $users = User::all();
        $copies = Copy::all();
        return view('lending.new', ['users' => $users, 'copies' => $copies]);
    }



    

    //Az eddig kikölcsönzött könyvek listája a bejelentkezett felhasználó által - nemkellett
    public function bejelentkezettkonyv(){
        $user = Auth::user();
        $konyv = Book::with('user')->where('user_id','=',$user->id)->get();
        return $konyv;
    }

    public function bookUserCount(){
        $user = Auth::user();
        $copies = DB::table('lendings as l')	//egy tábla lehet csak
	  //->select('mezo_neve')		//itt nem szükséges
        //->join('users as u' ,'c.book_id','=','b.book_id') //kapcsolat leírása, akár több join is lehet
        ->where('l.user_id','=', Auth::user()) ;	//esetleges szűrés
        	//esetleges aggregálás; ha select, akkor get() a vége
        return $copies;
    }


    public function bookData($title){
        $copies = DB::table('lendings as l')	//egy tábla lehet csak
          ->join('copies as c' ,'c.book_id','=','l.copy_id') //kapcsolat leírása, akár több join is lehet
          ->where('l.copy_id','=',$title)
          ->get() ;	//esetleges szűrés
        				//esetleges aggregálás; ha select, akkor get() a vége
          return $copies;
  
    }

}
