<?php

namespace App\Http\Controllers;

use App\Models\Notice;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Validator;

class NoticeController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api', []);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function posts(Request $request)
    {
        if (empty($request->tag)) {
            $notice = Notice::all();
        } else {
            $notice = Notice::where('tags', 'like', '%'.$request->tag.'%')->get();
        }

        return $notice->toJson();
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $validator = Validator::make($request->all(), [
                    'title' => 'required|string|min:2',
                    'authot' => 'required|string|min:6',
                    'content' => 'required|string|min:6',
                    'tags' => 'required|array',
                ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $notice= new Notice();
        $notice->title = $request->title;
        $notice->author = $request->authot;
        $notice->content= $request->content;
        $notice->tags = $request->tags;
        $notice->save();
        $notice->id;

        $dados = Notice::find($notice->id);

        return response()->json($dados, 201)->header('Content-Type', 'application/json');
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
     * @param  \App\Models\Notice  $notice
     * @return \Illuminate\Http\Response
     */
    public function show(Notice $notice)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Notice  $notice
     * @return \Illuminate\Http\Response
     */
    public function edit(Notice $notice)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Notice  $notice
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Notice $notice)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Notice  $notice
     * @return \Illuminate\Http\Response
     */
    public function destroy(Notice $notice)
    {
        //
    }
}
