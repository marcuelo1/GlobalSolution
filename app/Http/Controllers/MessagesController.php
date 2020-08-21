<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\User;
use App\Message;

class MessagesController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(){
        $user = User::find(auth()->user()->id);
        $chatlist = [];
        if($user->user_pos == 'Buyer'){
            $people = DB::table('messages')->where('Buyer', '=', $user->id)->groupBy('Seller')->get();

            foreach($people as $person){
                array_push($chatlist, User::find($person->Seller));
            }

        }else{
            $people = DB::table('messages')->where('Seller', '=', $user->id)->groupBy('Buyer')->get();

            foreach($people as $person){
                $data = User::find($person->Buyer);
                array_push($chatlist, $data);
            }
            
        }

        $data = [
            'chatlist' => $chatlist,
            'user_pos' => auth()->user()->user_pos,
        ];
        
        return view('pages.chatlist')->with($data);
    }

    public function chat($id){
        $user = User::find(auth()->user()->id);
        $username2 = User::find($id);

        $data = [
            'user' => $user,
            'user2' => $id,
            'name' => $username2->name,
            'user_pos' => auth()->user()->user_pos,
        ];

        return view('pages.chat')->with($data);
    }

    public function chatMessages(Request $request){
        $message = new Message();

        //info of the first user
        $user1 = User::find($request->user1);
        $message->From = $user1->id;

        //info of the second user
        $user2 = User::find($request->user2);

        if($user1->user_pos == 'Buyer'){
            $users = [$user1, $user2];
        }else{
            $users = [$user2, $user1];
        }

        if($request->message != ''){
            $message->message = $request->message;
            $message->Buyer = $users[0]->id;
            $message->Seller = $users[1]->id;
            $message->save();
        }else{
            $message = null;
        }
    }

    public function retrieveMessages(Request $request){
        //info of the first user
        $user1 = User::find($request->user1);

        //info of the second user
        $user2 = User::find($request->user2);

        if($user1->user_pos == 'Buyer'){
            $users = [$user1, $user2];
        }else{
            $users = [$user2, $user1];
        }

        $messages = DB::table('messages')->where('Buyer', '=', $users[0]->id)->where('Seller', '=', $users[1]->id)->get();
        $data = [];
        foreach($messages as $message){
            if($message->id > $request->start){
                array_push($data, $message);
            }
        }

        return $data;
    }
        
}
