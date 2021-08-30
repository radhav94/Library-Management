<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use Validator;

class UserController extends Controller
{
       public function update(Request $request, $id)
    {
       
        $userid=User::find($id);
   
        if (!$userid) {
            return response()->json([
                'success' => false,
                'message' => 'Sorry, User not found'
            ], 400);
        }
          
        $userupdate =User::where('id',$id)->update($request->all());
    
        if ($userupdate) {
            return response()->json([
                'success' => true,
                'message' => 'User updated successfully!'
            ]);
        } else {
            return response()->json([
                'success' => false,
                'message' => 'Sorry, User not updated'
            ], 500);
        }
    }


      public function destroy($id)
    {
         $userid=User::find($id);
        
        if (!$userid) {
            return response()->json([
                'success' => false,
                'message' => 'Sorry, User with id ' . $id . ' cannot be found'
            ], 400);
        }
       if(!empty($userid))
       {
        if ($userid->delete()) {
            return response()->json([
                'success' => true,
                 'message' => 'User deleted successfully!'
            ]);
        } else {
            return response()->json([
                'success' => false,
                'message' => 'User not deleted'
            ], 500);
        }
    }
    }
}
