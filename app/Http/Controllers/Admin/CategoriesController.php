<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\User;
use App\Notifications\categorycreatednotification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Notification;

class CategoriesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $categories = Category::latest()->get();
        $profile = auth()->user()->profile;
        return view('admin.categories.index', [
            'categories' => $categories,
            'profile'=>$profile
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $profile = auth()->user()->profile;


        return view('admin.categories.create', [ 'profile'=>$profile]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|max:255|unique:categories,name',
            'description' => 'nullable',
            'image' => 'nullable|image',

        ],[
            'name.required' => 'الرجاء ادخال اسم',
            'name.max' => 'عدد الأحرف الأقصى 255',
            'name.unique' => 'الإسم موجود مسبقا',
            // Add more custom messages for other validation rules if needed
        ]);



        if ($request->hasFile('image')) {
            $file = $request->file('image'); //ublodedfile object
            $image_path = $file->store('/', [   //البراميتر الاول هو الباث تاع المجلد داخل الديسك والبراميتر الثاني هو نوع الديسك
                'disk' => 'uploads' //الابلود ديسك هو عبارة عن كستم ديسك بتعملو من الفايل سستم
            ]);
            $request->merge([
                'image_path' => $image_path,
            ]);
        }

        $users = User::all();
        $category = Category::create($request->all());
        $notification = new categorycreatednotification($category);
        Notification::send($users, $notification);

        return redirect(route('categories.index'))
            ->with('success', 'تم انشاء التصنيف');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $category = Category::findOrFail($id);
        $profile = auth()->user()->profile;

        return view('admin.categories.edit', [
            'category' => $category,
            'profile'=>$profile
        ]);
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
        $category = Category::findOrFail($id);

        $request->validate([
            'name' => 'required|max:255',
            'description' => 'nullable',
            'image' => 'nullable|image|',

        ]);



        if ($request->hasFile('image')) {
            $file = $request->file('image'); //ublodedfile object
            $image_path = $file->store('/', [   //البراميتر الاول هو الباث تاع المجلد داخل الديسك والبراميتر الثاني هو نوع الديسك
                'disk' => 'uploads' //الابلود ديسك هو عبارة عن كستم ديسك بتعملو من الفايل سستم
            ]);
            $request->merge([
                'image_path' => $image_path,
            ]);
        }

        $category->update($request->all());

        return redirect(route('categories.index'))
            ->with('success', ' تم تحديث التصنيف');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $category = Category::findOrFail($id);
        $category->delete();




        return redirect(route('categories.index'))
            ->with('success', 'تم حذف التصنيف');
    }
}
