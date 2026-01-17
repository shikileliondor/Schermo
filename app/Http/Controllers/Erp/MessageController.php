<?php

namespace App\Http\Controllers\Erp;

use App\Http\Controllers\Controller;
use App\Models\Message;
use App\Models\Student;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class MessageController extends Controller
{
    public function index(): View
    {
        return view('erp.messages.index', [
            'messages' => Message::with('student')->latest()->paginate(15),
        ]);
    }

    public function create(): View
    {
        return view('erp.messages.create', [
            'students' => Student::orderBy('last_name')->get(),
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'student_id' => ['nullable', 'exists:students,id'],
            'channel' => ['required', 'string', 'max:50'],
            'subject' => ['nullable', 'string', 'max:255'],
            'content' => ['required', 'string'],
            'status' => ['required', 'string', 'max:50'],
        ]);

        Message::create($validated);

        return redirect()->route('erp.messages.index')->with('status', 'Message enregistré.');
    }

    public function edit(Message $message): View
    {
        return view('erp.messages.edit', [
            'message' => $message,
            'students' => Student::orderBy('last_name')->get(),
        ]);
    }

    public function update(Request $request, Message $message): RedirectResponse
    {
        $validated = $request->validate([
            'student_id' => ['nullable', 'exists:students,id'],
            'channel' => ['required', 'string', 'max:50'],
            'subject' => ['nullable', 'string', 'max:255'],
            'content' => ['required', 'string'],
            'status' => ['required', 'string', 'max:50'],
        ]);

        $message->update($validated);

        return redirect()->route('erp.messages.index')->with('status', 'Message mis à jour.');
    }

    public function destroy(Message $message): RedirectResponse
    {
        $message->delete();

        return redirect()->route('erp.messages.index')->with('status', 'Message supprimé.');
    }
}
