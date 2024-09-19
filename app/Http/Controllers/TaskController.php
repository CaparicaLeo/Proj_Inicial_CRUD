<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\models\User;
use App\Models\Task;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class TaskController extends Controller
{
    public function index()
    {
        $tasks = $this->getAllTasksByUserId();

        if ($tasks->isEmpty()) {
            return view('home', ['tasks' => collect()]); // Use collect() para criar uma coleção vazia
        }

        return view('home', ['tasks' => $tasks]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => ['required', 'min:3', 'max:50'],
            'description' => ['required', 'min:3', 'max:255'],
            'category' => ['required', 'min:3', 'max:50'],
        ]);
        Task::create([
            'user_id' => Auth::id(),
            'title' => $validated['title'],
            'description' => $validated['description'],
            'category' => $validated['category'],
            'status' => false,
        ]);

        return redirect()->route('home');
    }

    private function getAllTasksByUserId()
    {
        $user_id = Auth::id();
        return Task::where('user_id', $user_id)->get();
    }

    public function getAllTasks()
    {
        return User::find(Auth::id())->tasks;
    }

    public function edit($id)
    {
        $task = Task::findOrFail($id); // Busca a task pelo ID
        return view('tasks.edit', compact('task')); // Passa a task para a view de edição
    }

    public function update(Request $request, $id)
    {
        // Validação dos dados
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'category' => 'required|string'
        ]);

        // Busca a task pelo ID e atualiza seus dados
        $task = Task::findOrFail($id);
        $task->title = $request->input('title');
        $task->description = $request->input('description');
        $task->category = $request->input('category');
        $task->save(); // Salva as mudanças no banco de dados

        return redirect()->route('home')->with('success', 'Task updated successfully!');
    }
    public function destroy($id)
    {
        $task = Task::find($id);

        if (!$task) {
            return redirect()->route('home')->with('error', 'Task não encontrada!');
        }

        $task->delete();

        return redirect()->route('home')->with('success', 'Task deletada com sucesso!');
    }
}
