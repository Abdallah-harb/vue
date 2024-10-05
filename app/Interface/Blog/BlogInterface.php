<?php

namespace App\Interface\Blog;

interface BlogInterface
{
    public function index();
    public function show($slug);
    public function store(array $data);
    public function update(array $data,$id);
    public function delete($id);
}
