<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\Task;
use Illuminate\Support\Facades\DB;
class TaskController extends Controller
{
    public function store(Request $request){
        //dd($request);
        $validated = $request->validate([
            'title' => ['required', 'min:3', 'max:50'],
            'description' => ['required', 'min:3','max:255'],
            'category' => ['required', 'min:3','max:50'],
        ]);
        //dd(Auth::id());
        Task::create([
            'user_id' => Auth::id(),
            'title' => $validated['title'],
            'description' => $validated['description'],
            'category' => $validated['category'],
            'status' => false,
        ]);
        
        return redirect()->route('home');
    }
    public function getAllTasksByUserId(){
        $user_id = Auth::id();
        $tasks = DB::table('tasks')
            ->select()
            ->where('user_id', '=', $user_id)
            ->get();
        dd($tasks);
    }
    public function getAllTasks(): array {
        //dd(Auth::id());
        dd(Task::where('user_id', '=', Auth::id())->get());
        return Task::find();
    }
}
