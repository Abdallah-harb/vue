<?php

namespace App\Http\Controllers\Blog;

use App\Http\Controllers\Controller;
use App\Http\Requests\Blog\BlogRequest;
use App\Http\Resources\Blog\BlogResource;
use App\Interface\Blog\BlogInterface;
use App\Repository\BlogRepository;
use Illuminate\Http\Request;

class BlogController extends Controller
{
    protected BlogInterface $repository;
    public function __construct(BlogInterface $repository){
        $this->repository = $repository;
    }

    /**
     * Display a listing of the resource.
     */
    final public function index()
    {
        return $this->repository->index();
    }

    /**
     * Store a newly created resource in storage.
     */
    final public function store(BlogRequest $request)
    {
        return $this->repository->store($request->validated());
    }

    /**
     * Display the specified resource.
     */
    final public function show(string $slug)
    {
        $blog = $this->repository->show($slug);
        return jsonResponse(['blog' => new BlogResource($blog)]);
    }

    /**
     * Update the specified resource in storage.
     */
    final public function update(BlogRequest $request, string $id)
    {
        return $this->repository->update($request->validated(),$id);
    }

    /**
     * Remove the specified resource from storage.
     */
    final public function destroy(string $id)
    {
        return $this->repository->delete($id);
    }
}
