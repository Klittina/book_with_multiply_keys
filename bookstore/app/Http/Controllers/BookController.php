<?php

namespace App\Http\Controllers;

use App\Models\Book;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class BookController extends Controller
{
    public function index(){
        $books =  Book::all();
        return $books;
    }
    
    public function show($id)
    {
        $book = Book::find($id);
        return $book;
    }
    public function destroy($id)
    {
        Book::find($id)->delete();
    }
    public function store(Request $request)
    {
        $Book = new Book();
        $Book->author = $request->author;
        $Book->title = $request->title;
        $Book->save();
    }

    public function update(Request $request, $id)
    {
        $Book = Book::find($id);
        $Book->author = $request->author;
        $Book->title = $request->title;
    }

    public function bookCopies($title)
    {	
        $copies = Book::with('copy_c')->where('title','=', $title)->get();
        return $copies;
    }

    public function bookCopyCount($title){
        $copies = DB::table('copies as c')	//egy tábla lehet csak
	  //->select('mezo_neve')		//itt nem szükséges
        ->join('books as b' ,'c.book_id','=','b.book_id') //kapcsolat leírása, akár több join is lehet
        ->where('b.title','=', $title) 	//esetleges szűrés
        ->count();				//esetleges aggregálás; ha select, akkor get() a vége
        return $copies;
    }
    
    public function bookIdk($title){
        $copies = DB::table('copies as c')	//egy tábla lehet csak
          ->join('books as b' ,'c.book_id','=','b.book_id') //kapcsolat leírása, akár több join is lehet
          ->where('c.hardcovered','=', $title) 
          ->get();	//esetleges szűrés
        				//esetleges aggregálás; ha select, akkor get() a vége
          return $copies;
  
    }

    public function bookYear($title){
        $copies = DB::table('copies as c')	//egy tábla lehet csak
          ->join('books as b' ,'c.book_id','=','b.book_id') //kapcsolat leírása, akár több join is lehet
          ->where('c.publication','=', $title) 
          ->get();	//esetleges szűrés
        				//esetleges aggregálás; ha select, akkor get() a vége
          return $copies;
  
    }

    public function bookStatus($title){
        $copies = DB::table('copies as c')	//egy tábla lehet csak
          ->join('books as b' ,'c.book_id','=','b.book_id') //kapcsolat leírása, akár több join is lehet
          ->where('c.status','=', $title)
          ->count('c.book_id') ;	//esetleges szűrés
        				//esetleges aggregálás; ha select, akkor get() a vége
          return $copies;
  
    }

    public function bookDarab($title,$year){
        $copies = DB::table('copies as c')	//egy tábla lehet csak
          ->join('books as b' ,'c.book_id','=','b.book_id') //kapcsolat leírása, akár több join is lehet
          ->where('c.publication','=', $year,'and','c.book_id','=',$title)
          ->count('c.status') ;	//esetleges szűrés
        				//esetleges aggregálás; ha select, akkor get() a vége
          return $copies;
  
    }
}
