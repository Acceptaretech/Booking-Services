<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Addon;
use App\Models\Service;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class AddonController extends Controller
{
    public function index()
    {
        $addons = Addon::with(['service','provider'])
            ->latest()
            ->paginate(15);

        return view('admin.addons.index', compact('addons'));
    }

    public function create()
    {
        $services = Service::all();
        $providers = User::where('role','provider')->get();

        return view('admin.addons.create', compact(
            'services',
            'providers'
        ));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'service_id'=>'required',
            'user_id'=>'required',
            'name'=>'required',
            'description'=>'nullable',
            'price'=>'required|numeric',
            'status'=>'required',
            'image'=>'nullable|image|max:2048',
        ]);

        if($request->hasFile('image')){
            $data['image'] = $request->file('image')
                ->store('addons','public');
        }

        Addon::create($data);

        return redirect()
            ->route('admin.addons.index')
            ->with('success','Addon created successfully');
    }

    public function edit(Addon $addon)
    {
        $services = Service::all();
        $providers = User::where('role','provider')->get();

        return view('admin.addons.edit', compact(
            'addon',
            'services',
            'providers'
        ));
    }

    public function update(Request $request, Addon $addon)
    {
        $data = $request->all();

        if($request->hasFile('image')){

            if($addon->image){
                Storage::disk('public')
                    ->delete($addon->image);
            }

            $data['image'] = $request->file('image')
                ->store('addons','public');
        }

        $addon->update($data);

        return redirect()
            ->route('admin.addons.index')
            ->with('success','Addon updated');
    }

    public function destroy(Addon $addon)
    {
        if($addon->image){
            Storage::disk('public')
                ->delete($addon->image);
        }

        $addon->delete();

        return back()->with('success','Addon deleted');
    }
}