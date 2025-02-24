<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\Dashboard\Category\{StoreCategoryRequest,UpdateCategoryRequest};
use App\Models\Category;
use Illuminate\Support\Facades\Session;
use App\Helpers\HandleUpload;

class CategoryController extends Controller
{
    public function index(Request $request)
    {
        $this->authorize('categories-عرض');
        $categories = Category::paginate(10);
        return view('admin.categories.index',compact('categories'));
    }

    public function create()
    {
        $this->authorize('categories-اضافة');
        return view('admin.categories.create');
    }

    public function store(StoreCategoryRequest $storeCategoryRequest)
    {
        $this->authorize('categories-اضافة');
        $data['title'] = ['en' => $storeCategoryRequest->title_en,'ar' => $storeCategoryRequest->title_ar];
        $data['description'] = ['en' => $storeCategoryRequest->description_en,'ar' => $storeCategoryRequest->description_ar];
        $data['image'] = $storeCategoryRequest->hasFile('image') ? HandleUpload::uploadFile($storeCategoryRequest->image , 'categories/images') : NULL;
        Category::create($data);
        Session::flash('message', ['type' => 'success', 'text' => __('Category created successfully')]);
        return redirect()->route('Admin.categories.index');
    }

    public function edit(Category $category)
    {
        $this->authorize('categories-تعديل');
        return view('admin.categories.edit',compact('category'));
    }

    public function update(UpdateCategoryRequest $updateCategoryRequest,Category $category)
    {
        $this->authorize('categories-تعديل');
        $data['title'] = ['en' => $updateCategoryRequest->title_en,'ar' => $updateCategoryRequest->title_ar];
        $data['description'] = ['en' => $updateCategoryRequest->description_en,'ar' => $updateCategoryRequest->description_ar];
        $data['image'] = $updateCategoryRequest->hasFile('image') ? HandleUpload::uploadFile($updateCategoryRequest->image , 'categories/images') : $category->image;
        $category->update($data);
        Session::flash('message', ['type' => 'success', 'text' => __('Category updated successfully')]);
        return redirect()->route('Admin.categories.index');
    }
}