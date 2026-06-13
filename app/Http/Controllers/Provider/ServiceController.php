<?php

namespace App\Http\Controllers\Provider;

use App\Http\Controllers\Controller;
use App\Models\{Addon, Category, Package, Service, ServiceFaq, Shop, SubCategory};
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ServiceController extends Controller
{
    public function index(Request $request)
    {
        $services = Service::with(['category','shop'])
            ->where('user_id',auth()->id())
            ->when($request->search,fn($q,$s)=>$q->where('name','like',"%$s%"))
            ->when($request->status,fn($q,$s)=>$q->where('status',$s))
            ->latest()->paginate(10);
        return view('provider.services.index',compact('services'));
    }

    public function create()
    {
        $categories = Category::active()->get();
        $shops      = Shop::where('user_id',auth()->id())->active()->get();
        return view('provider.services.create',compact('categories','shops'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name'         => 'required|string|max:150',
            'category_id'  => 'required|exists:categories,id',
            'description'  => 'nullable|string',
            'price'        => 'required|numeric|min:0',
            'discount'     => 'nullable|numeric|min:0|max:100',
            'price_type'   => 'required|in:fixed,hourly',
            'duration'     => 'nullable|integer',
            'type'         => 'required|in:fixed,online,both',
            'image'        => 'required|image|max:2048',
            'shop_id'      => 'nullable|exists:shops,id',
            'status'       => 'required|in:active,inactive',
        ]);

        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('services','public');
        }
        $data['user_id'] = auth()->id();
        Service::create($data);
        return redirect()->route('provider.services.index')->with('success','Service created.');
    }

    public function edit(Service $service)
    {
        abort_unless($service->user_id === auth()->id(), 403);
        $categories = Category::active()->get();
        $shops      = Shop::where('user_id',auth()->id())->get();
        return view('provider.services.edit',compact('service','categories','shops'));
    }

    public function update(Request $request, Service $service)
    {
        abort_unless($service->user_id === auth()->id(), 403);
        $data = $request->validate([
            'name'        => 'required|string|max:150',
            'category_id' => 'required|exists:categories,id',
            'description' => 'nullable|string',
            'price'       => 'required|numeric|min:0',
            'discount'    => 'nullable|numeric|min:0|max:100',
            'price_type'  => 'required|in:fixed,hourly',
            'duration'    => 'nullable|integer',
            'type'        => 'required|in:fixed,online,both',
            'image'       => 'nullable|image|max:2048',
            'status'      => 'required|in:active,inactive',
        ]);
        if ($request->hasFile('image')) {
            Storage::disk('public')->delete($service->image);
            $data['image'] = $request->file('image')->store('services','public');
        }
        $service->update($data);
        return redirect()->route('provider.services.index')->with('success','Service updated.');
    }

    public function destroy(Service $service)
    {
        abort_unless($service->user_id === auth()->id(), 403);
        Storage::disk('public')->delete($service->image);
        $service->delete();
        return back()->with('success','Service deleted.');
    }

    public function toggleStatus(Service $service)
    {
        abort_unless($service->user_id === auth()->id(), 403);
        $service->update(['status' => $service->status === 'active' ? 'inactive' : 'active']);
        return response()->json(['status' => $service->status]);
    }

    // FAQ management
    public function faqs(Service $service)
    {
        abort_unless($service->user_id === auth()->id(), 403);
        $faqs = ServiceFaq::where('service_id',$service->id)->get();
        return view('provider.services.faqs',compact('service','faqs'));
    }

    public function storeFaq(Request $request, Service $service)
    {
        $request->validate(['title'=>'required|string','description'=>'nullable|string','status'=>'required']);
        ServiceFaq::create(['service_id'=>$service->id]+$request->all());
        return back()->with('success','FAQ added.');
    }
    // public function edit(Service $service)
    // {
    //     abort_unless($service->user_id === auth()->id(), 403);
    //     $categories = \App\Models\Category::active()->get();
    //     $shops      = \App\Models\Shop::where('user_id', auth()->id())->get();
    //     return view('provider.services.edit', compact('service', 'categories', 'shops'));
    // }

    public function requestList(Request $request)
    {
        $services = Service::where('user_id', auth()->id())
            ->when($request->search, fn($q) => $q->where('name', 'like', '%'.$request->search.'%'))
            ->with('category')
            ->latest()->paginate(10);
        return view('provider.services.index', compact('services'));
    }
}
