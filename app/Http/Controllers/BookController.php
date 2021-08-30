<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Books;
use Validator;
// use JWTAuth;
// use Exception;
// use Tymon\JWTAuth\Http\Middleware\BaseMiddleware;

class BookController extends Controller
{
   //  protected $user;
   // public function __construct()
   //  {
   //      $this->user = JWTAuth::parseToken()->authenticate();
   //  }

     public function index()
    {
       // if($this->user)
       //  {
            return Books::get(['book_name', 'author', 'cover_image'])->toArray();
        // }
        // else
        // {
        //     return json()->response('Authorization Token not found');
        // }
      
    }
    public function show($id)
    {
       $bookid=Books::where('id',$id)->get();
    
        if (!$bookid) {
            return response()->json([
                'success' => false,
                'message' => 'Sorry, Book not found'
            ], 400);
        }
    
        return $bookid;
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'book_name' => 'required',
            'author' => 'required'
        ]);
        if($validator->fails()){
            return response()->json($validator->errors()->toJson(), 400);
        }
    
        $bookdata = array(
        "book_name" => $request->book_name,
        "author" => $request->author,
        "cover_image" => $request->cover_image);
    $bookexist=Books::where('book_name',$request->book_name)->exists();
   
    if($bookexist==false)
    { 
        if (Books::create($bookdata))
            return response()->json([
                'success' => true,
                 'message' => 'Book added successfully!',
                'books' => $bookdata
            ]);
        else
            return response()->json([
                'success' => false,
                'message' => 'Sorry, Book can not be added'
            ], 500);
    }
    else
    { 
       return response()->json([
                'success' => false,
                'message' => 'Sorry, This Book alredy added'
            ]);
    }
    }
     
     public function testput(Request $request)
     {
        return $request->all();
     }
    public function update(Request $request, $id)
    {
     
        $bookid=Books::find($id);
    
        if (!$bookid) {
            return response()->json([
                'success' => false,
                'message' => 'Sorry, Book not found!'
            ], 400);
        }
          
        $bookupdate =Books::where('id',$id)->update($request->all());
    
        if ($bookupdate) {
            return response()->json([
                'success' => true,
                 'message' => 'Book updated successfully!'
            ]);
        } else {
            return response()->json([
                'success' => false,
                'message' => 'Sorry, Book can not be updated'
            ], 500);
        }
    }

    public function destroy($id)
    {

         $bookid=Books::find($id);
     
        if (!$bookid) {
            return response()->json([
                'success' => false,
                'message' => 'Sorry, Book not found!'
            ], 400);
        }
       if(!empty($bookid))
       {
        if ($bookid->delete()) {
            return response()->json([
                'success' => true,
                'message' => 'Book deleted successfully'
            ]);
        } else {
            return response()->json([
                'success' => false,
                'message' => 'Book can not be deleted'
            ], 500);
        }
    }
    }

    


}
