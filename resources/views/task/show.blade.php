@extends('layouts.app')

@section('content')

<h1>id = {{ $tasks->id }} のメッセージ詳細ページ</h1>

    <table class="table table-bordered">
        <tr>
            <th>id</th>
            <td>{{ $tasks->id }}</td>
        </tr>
        <tr>
            <th>メッセージ</th>
            <td>{{ $tasks->content }}</td>
        </tr>
    </table>
{!! link_to_route('task.edit', 'このメッセージを編集', ['tasks' => $tasks->id], ['class' => 'btn btn-light']) !!}
{!! Form::model($tasks, ['route' => ['task.destroy', $task->id], 'method' => 'delete']) !!}
        {!! Form::submit('削除', ['class' => 'btn btn-danger']) !!}
    {!! Form::close() !!}

@endsection