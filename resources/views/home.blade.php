<!-- resources/views/home.blade.php -->
@extends('layouts.app')

@section('title', 'Home')

@section('content')
<h1 class="mt-4">CRUD - Gerenciador de Tarefas</h1>

<!-- Formulário para adicionar uma nova tarefa -->
<form action="{{ route('task_register') }}" method="POST" class="mb-4">
    @csrf
    <div class="form-group">
        <label for="title">Título da Tarefa</label>
        <input type="text" class="form-control" id="title" name="title" required>
    </div>
    <div class="form-group">
        <label for="description">Descrição</label>
        <textarea class="form-control" id="description" name="description" rows="3" required></textarea>
    </div>
    <div class="form-group">
        <label for="category">Categoria</label>
        <input type="text" class="form-control" id="category" name="category" required>
    </div>
    <button type="submit" class="btn btn-primary">Adicionar Tarefa</button>
</form>

<div class="mt-4">
    <!-- Exiba a lista de tarefas aqui -->
    @if($tasks->isEmpty())
    <p>Não há tarefas.</p>
    @else
    <ul class="list-group">
        @foreach($tasks as $task)
        <li class="list-group-item">
            <strong>{{ $task->title }}</strong>
            <p>{{ $task->description }}</p>
            <small>Categoria: {{ $task->category }}</small>

            <!-- Botão para exibir o formulário de edição -->
            <a href="#edit-form-{{ $task->id }}" class="btn btn-secondary btn-sm" data-toggle="collapse" aria-expanded="false" aria-controls="edit-form-{{ $task->id }}">Editar</a>

            <!-- Formulário para edição de tarefa -->
            <div class="collapse" id="edit-form-{{ $task->id }}">
                <form action="{{ route('task_update', $task->id) }}" method="POST" class="mt-2">
                    @csrf
                    @method('PUT')
                    <div class="form-group">
                        <label for="edit-title-{{ $task->id }}">Título</label>
                        <input type="text" class="form-control" id="edit-title-{{ $task->id }}" name="title" value="{{ old('title', $task->title) }}" required>
                    </div>
                    <div class="form-group">
                        <label for="edit-description-{{ $task->id }}">Descrição</label>
                        <textarea class="form-control" id="edit-description-{{ $task->id }}" name="description" rows="3" required>{{ old('description', $task->description) }}</textarea>
                    </div>
                    <div class="form-group">
                        <label for="edit-category-{{ $task->id }}">Categoria</label>
                        <input type="text" class="form-control" id="edit-category-{{ $task->id }}" name="category" value="{{ old('category', $task->category) }}" required>
                    </div>
                    <button type="submit" class="btn btn-primary">Atualizar</button>
                </form>
            </div>

            <!-- Formulário para deletar a tarefa -->
            <form action="{{ route('tasks.destroy', $task->id) }}" method="POST" style="display:inline;">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Tem certeza que deseja excluir?')">Excluir</button>
            </form>
        </li>
        @endforeach
    </ul>
    @endif
</div>
@endsection
