<?php

namespace App\Http\Controllers;

use App\Http\Resources\BookResource;
use App\Models\Book;
use App\Models\Order;
use App\Notifications\BookInvoice;
use App\Notifications\SendBookLink;
use Illuminate\Support\Facades\Storage;
use Inertia\Inertia;

class BookController extends Controller
{
    public function index()
    {
        return Inertia::render('books/Index', [
            'books' => BookResource::collection(Book::all())
        ])->with('success', 'تم إرسال رابط التحميل على البريد الإلكتروني');
    }
    /**
     * Send download link to user's email
     */
    public function sendDownloadLink(Book $book)
    {
        $user = auth()->user();
        $user->notify(new SendBookLink($book));

        return redirect()->back()->with('success', 'تم إرسال رابط التحميل على البريد الإلكتروني');
    }

    /**
     * Display download page for a book
     */
    public function downloadPage(Book $book)
    {
        // Check if the user owns the book
        if (! $book->purchased()) {
            return redirect()->route('books.index')->with('error', 'لا يمكنك تحميل هذا الكتاب لأنك لم تشتريه بعد');
        }

        // Get the latest order for this book
        $order = Order::where([
            'user_id' => auth()->id(),
            'orderable_type' => Book::class,
            'orderable_id' => $book->id,
            'status' => 'SUCCESS',
        ])->latest()->first();

        // Send invoice email if it's a new purchase
        if ($order && $order->created_at->diffInMinutes(now()) < 5) {
            auth()->user()->notify(new BookInvoice($book, $order));
        }

        // Generate temporary download URL
        $url = null;
        if ($book->file_src) {
            $path = json_decode($book->file_src)->path;
            $url = Storage::disk('s3_public')->temporaryUrl($path, now()->addMinutes(30));
        }

        return Inertia::render('Books/Download', [
            'book' => BookResource::make($book),
            'downloadUrl' => $url,
        ]);
    }

    /**
     * Direct download of the book file
     */
    public function directDownload(Book $book)
    {
        // Check if the user owns the book
        if (! $book->purchased()) {
            return redirect()->route('books.index')->with('error', 'لا يمكنك تحميل هذا الكتاب لأنك لم تشتريه بعد');
        }

        if (! $book->file_src) {
            return redirect()->back()->with('error', 'ملف الكتاب غير متوفر');
        }

        $path = json_decode($book->file_src)->path;

        return redirect(Storage::disk('s3_public')->temporaryUrl($path, now()->addMinutes(5)));
    }
}
