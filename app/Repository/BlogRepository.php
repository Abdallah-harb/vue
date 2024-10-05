<?php

namespace App\Repository;
use App\Http\Resources\Blog\BlogResource;
use App\Http\Resources\User\UserResource;
use App\Interface\Blog\BlogInterface;
use App\Models\Blog;
use App\Trait\MediaTrait;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class BlogRepository implements BlogInterface
{
    use MediaTrait;
    protected $module;
    public function __construct(Blog $module){
        $this->module = $module;
    }

    public function index()
    {
        $blogs = $this->module->paginate(10);
        return JsonResponseData(__('message.paginated Data'),['blogs' => BlogResource::collection($blogs)],'blogs');
    }

    public function show($slug)
    {
        $blog = $this->module->where('slug',$slug)->firstOrFail();
        return $blog;
    }

    public function store(array $data)
    {
        $data['image'] = $this->image($data['image'],'blog/images');
        $data['images'] = $this->uploadMultiImages($data['images'],'blog/images');
        $blog = $this->module->create($data+['user_id' => 1,'slug' => Str::slug($data['title'])]);
        $blog->refresh();
        return jsonResponse(['blog' => new BlogResource($blog)]);
    }

    public function update(array $data,$id)
    {
        $blog = $this->module->findOrFail($id);
        if (isset($data['image']) && $data['image'] !=null){
            $data['image'] = $this->image($data['image'],'blog/images',$blog->image);
        }
        if (isset($data['images']) && $data['images']!=null){
            $data['images'] = $this->uploadMultiImages($data['images'],'blog/images',$blog->images);
        }
        $blog->update($data+['slug' => Str::slug($data['title'])]);
        $blog->refresh();
        return jsonResponse(['blog' => new BlogResource($blog)]);
    }

    public function delete($id)
    {
        $blog = $this->module->findOrFail($id);
        $this->deleteFile($blog->image);
        $this->deleteMulti($blog->images);
        $blog->delete();
        return jsonResponse([],__('message.delete'));
    }

    public function user(){
        return jsonResponse(['user' => new UserResource(Auth::user())]);
    }
}
