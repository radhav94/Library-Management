<?php

namespace App\Http\Controllers;

use App\Transactions;
use App\Books;
use Illuminate\Http\Request;
use Validator;

class RentBookController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'user_id' => 'required',
            'book_id' => 'required'           
        ]);

          if($validator->fails()){
            return response()->json($validator->errors()->toJson(), 400);
        }

      
     if(Books::where('id',$request->book_id)->exists())
     {
        
        $bookrentdata = array(
        "user_id" => $request->user_id,
        "book_id" => $request->book_id,
        'status' =>0,
        "rent_date" => now());
     
        if (Transactions::create($bookrentdata))
            return response()->json([
                'success' => true,
                 'message' => 'Book is rented successfully!',
                'book-rent' => $bookrentdata
            ]);
        else
            return response()->json([
                'success' => false,
                'message' => 'Sorry, User can not be rent this book!'
            ], 500);
       }
       else
       {
        
        return response()->json([
                'success' => false,
                'message' => 'Sorry, book not found!'
            ]);
       }

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\RentBook  $rentBook
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $transid=Transactions::where('user_id',$id)->with('book')->get();
    
        if (!$transid) {
            return response()->json([
                'success' => false,
                'message' => 'Sorry, '
            ], 400);
        }
    
        return $transid;
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\RentBook  $rentBook
     * @return \Illuminate\Http\Response
     */
    public function edit(RentBook $rentBook)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\RentBook  $rentBook
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    { 
      
        $validator = Validator::make($request->all(), [
            'user_id' => 'required',
            'book_id' => 'required'           
        ]);

          if($validator->fails()){
            return response()->json($validator->errors()->toJson(), 400);
        }

         $transid=Transactions::where('user_id',$request->user_id)->where('book_id',$request->book_id)->exists();
        if ($transid==false) {
            return response()->json([
                'success' => false,
                'message' => 'Sorry, This book with user is not found'
            ], 400);
        }
         $bookrentdata = array(
        "user_id" => $request->user_id,
        "book_id" => $request->book_id,
        'status' =>1,
        "return_date" => now());

        $transdata =Transactions::where('id',$id)->update($bookrentdata);
    
        if ($transdata) {
            return response()->json([
                'success' => true,
                 'message' => 'Book returned successfully!'
            ]);
        } else {
            return response()->json([
                'success' => false,
                'message' => 'Sorry,  Book can not be return!'
            ], 500);
        }
          
          
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\RentBook  $rentBook
     * @return \Illuminate\Http\Response
     */
    public function destroy(RentBook $rentBook)
    {
        //
    }
}
