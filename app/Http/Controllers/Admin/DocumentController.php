<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Document;
use Illuminate\Http\Request;

class DocumentController extends Controller
{
    public function index(Request $request)
    {
        $documents = Document::query()
            ->when($request->filled('search'), function ($q) use ($request) {
                $q->where('name', 'like', '%' . $request->search . '%');
            })
            ->when($request->filled('type') && $request->type !== 'all', function ($q) use ($request) {
                $q->where('document_type', $request->type);
            })
            ->latest()
            ->paginate(10)
            ->withQueryString();

        return view('admin.documents.index', compact('documents'));
    }

    public function create()
    {
        return view('admin.documents.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'document_type' => 'required|in:provider,shop',
            'status' => 'required|in:active,inactive',
        ]);

        Document::create([
            'name' => $request->name,
            'document_type' => $request->document_type,
            'status' => $request->status,
            'is_required' => $request->has('is_required'),
        ]);

        return redirect()->route('admin.documents.index')->with('success', 'Document created successfully.');
    }

    public function edit(Document $document)
    {
        return view('admin.documents.edit', compact('document'));
    }

    public function update(Request $request, Document $document)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'document_type' => 'required|in:provider,shop',
            'status' => 'required|in:active,inactive',
        ]);

        $document->update([
            'name' => $request->name,
            'document_type' => $request->document_type,
            'status' => $request->status,
            'is_required' => $request->has('is_required'),
        ]);

        return redirect()->route('admin.documents.index')->with('success', 'Document updated successfully.');
    }

    public function destroy(Document $document)
    {
        $document->delete();

        return back()->with('success', 'Document deleted successfully.');
    }

    public function toggleRequired(Document $document)
    {
        $document->update([
            'is_required' => !$document->is_required,
        ]);

        return back();
    }

    public function toggleStatus(Document $document)
    {
        $document->update([
            'status' => $document->status === 'active' ? 'inactive' : 'active',
        ]);

        return back();
    }
}