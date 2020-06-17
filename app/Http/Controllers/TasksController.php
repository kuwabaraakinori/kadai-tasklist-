<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Task;

class TasksController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        
        $data = [];
        if (\Auth::check()) { // 認証済みの場合
            // 認証済みユーザを取得
            $user = \Auth::user();
            // ユーザの投稿の一覧を作成日時の降順で取得
            $tasks = $user->tasks()->orderBy('created_at', 'desc')->paginate(10);

            $data = [
                'user' => $user,
                'tasks' => $tasks,
            ];
            return view('task.index', $data);
        }

        // Welcomeビューでそれらを表示
        return view('welcome', $data);
        
       
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $tasks= new Task;
        
        return view('task.create' , [
          'tasks' =>$tasks,
            ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        
         $this->validate($request, [
             'content' =>'required|max:10',
            'status' => 'required|max:10',   
        ]);
        
        $tasks=new Task;
        $tasks->content=$request->content;
        $tasks->status=$request->status;
        $tasks->user_id = $request->user()->id;
        $tasks->save();
        
        return redirect('/');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $tasks = \App\Task::find($id);
        
        if (\Auth::id() === $tasks->user_id) {
            return view('task.show', [
            'tasks' => $tasks,
        ]);
        }
        return redirect('/');
        
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $tasks = \App\Task::find($id);
        
        if (\Auth::id() === $tasks->user_id){
            return view('task.edit', [
            'tasks' => $tasks,
        ]);
        }
        return redirect('/');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'content' =>'required|max:100',
            'status' => 'required|max:10',   
        ]);
        
        $tasks = \App\Task::find($id);
        
        if (\Auth::id() === $tasks->user_id) {
            $tasks->content = $request->content;
            $tasks->status=$request->status;
            $tasks->save();
        }
        
        return redirect('/');
        
        /*
        $tasks=Task::findOrFail($id);
        
        $tasks->content = $request->content;
        $tasks->status=$request->status;
        $tasks->save();
        
        return redirect('/');
        */
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        
        $tasks = \App\Task::find($id);
        
        if (\Auth::id() === $tasks->user_id) {
            $tasks->delete();
        }
        
        return redirect('/');
    }
}
