<?php

namespace App\Http\Controllers;

use App\Models\Repost;
use App\Http\Requests\StoreRepostRequest;
use App\Http\Requests\UpdateRepostRequest;

class RepostController extends Controller
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
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreRepostRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreRepostRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Repost  $repost
     * @return \Illuminate\Http\Response
     */
    public function show(Repost $repost)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Repost  $repost
     * @return \Illuminate\Http\Response
     */
    public function edit(Repost $repost)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateRepostRequest  $request
     * @param  \App\Models\Repost  $repost
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateRepostRequest $request, Repost $repost)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Repost  $repost
     * @return \Illuminate\Http\Response
     */
    public function destroy(Repost $repost)
    {
        //
    }
}
