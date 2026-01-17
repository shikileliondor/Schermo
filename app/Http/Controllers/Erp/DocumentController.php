<?php

namespace App\Http\Controllers\Erp;

use App\Http\Controllers\Controller;
use App\Models\Document;
use App\Models\Staff;
use App\Models\Student;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

class DocumentController extends Controller
{
    public function index(): View
    {
        return view('erp.documents.index', [
            'documents' => Document::with(['student', 'staff'])->latest()->paginate(15),
        ]);
    }

    public function create(): View
    {
        return view('erp.documents.create', [
            'students' => Student::orderBy('last_name')->get(),
            'staff' => Staff::orderBy('last_name')->get(),
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'student_id' => ['nullable', 'exists:students,id'],
            'staff_id' => ['nullable', 'exists:staff,id'],
            'title' => ['required', 'string', 'max:255'],
            'type' => ['required', 'string', 'max:100'],
            'file' => ['required', 'file', 'max:5120'],
        ]);

        $file = $request->file('file');
        $path = $file->store('documents');

        Document::create([
            'student_id' => $validated['student_id'] ?? null,
            'staff_id' => $validated['staff_id'] ?? null,
            'user_id' => $request->user()?->id,
            'title' => $validated['title'],
            'type' => $validated['type'],
            'file_path' => $path,
            'original_name' => $file->getClientOriginalName(),
            'mime_type' => $file->getClientMimeType(),
            'file_size' => $file->getSize(),
        ]);

        return redirect()->route('erp.documents.index')->with('status', 'Document ajouté.');
    }

    public function edit(Document $document): View
    {
        return view('erp.documents.edit', [
            'document' => $document,
            'students' => Student::orderBy('last_name')->get(),
            'staff' => Staff::orderBy('last_name')->get(),
        ]);
    }

    public function update(Request $request, Document $document): RedirectResponse
    {
        $validated = $request->validate([
            'student_id' => ['nullable', 'exists:students,id'],
            'staff_id' => ['nullable', 'exists:staff,id'],
            'title' => ['required', 'string', 'max:255'],
            'type' => ['required', 'string', 'max:100'],
            'file' => ['nullable', 'file', 'max:5120'],
        ]);

        if ($request->hasFile('file')) {
            Storage::delete($document->file_path);
            $file = $request->file('file');
            $document->file_path = $file->store('documents');
            $document->original_name = $file->getClientOriginalName();
            $document->mime_type = $file->getClientMimeType();
            $document->file_size = $file->getSize();
        }

        $document->fill([
            'student_id' => $validated['student_id'] ?? null,
            'staff_id' => $validated['staff_id'] ?? null,
            'title' => $validated['title'],
            'type' => $validated['type'],
        ]);

        $document->save();

        return redirect()->route('erp.documents.index')->with('status', 'Document mis à jour.');
    }

    public function destroy(Document $document): RedirectResponse
    {
        Storage::delete($document->file_path);
        $document->delete();

        return redirect()->route('erp.documents.index')->with('status', 'Document supprimé.');
    }

    public function download(Document $document)
    {
        if (! Storage::exists($document->file_path)) {
            abort(404);
        }

        return Storage::download($document->file_path, $document->original_name);
    }
}
