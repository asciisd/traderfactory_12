<?php

use App\Http\Controllers\BookController;
use App\Http\Controllers\CourseController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\GlossaryController;
use App\Http\Controllers\GoalController;
use App\Http\Controllers\LessonController;
use App\Http\Controllers\MagazineController;
use App\Http\Controllers\OrdersController;
use App\Http\Controllers\QuickScanController;
use App\Http\Controllers\QuizController;
use App\Http\Controllers\RevisionController;
use App\Http\Controllers\SectionController;
use App\Http\Controllers\TodoController;
use App\Http\Controllers\VisualController;
use App\Http\Controllers\WelcomeController;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::get('dashboard', DashboardController::class)
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

require __DIR__.'/settings.php';
require __DIR__.'/auth.php';

Route::get('/', [WelcomeController::class, 'index'])->name('welcome');
Route::get('/about-us', [WelcomeController::class, 'about'])->name('about');

// Courses routes
Route::resource('courses', CourseController::class)->only(['index']);
Route::get('courses/{section}', [CourseController::class, 'sections'])->name('courses.sections.section');

// Books routes.
Route::get('/books', [BookController::class, 'index'])->name('books.index');

// Glossary Routes
Route::get('/glossary', [GlossaryController::class, 'index'])->name('glossary.index');
Route::get('/glossary/{glossary}', [GlossaryController::class, 'show'])->name('glossary.show');

/**
 * For registered users.
 */
Route::middleware(['auth', 'verified'])->group(function () {
    // Update progress
    Route::put('goals/progress/{goal}', [GoalController::class, 'updateProgress'])->name('goals.progress');
    Route::put('magazines/progress/{magazine}', [MagazineController::class, 'updateProgress'])->name('magazines.progress');
    Route::put('todos/progress/{todo}', [TodoController::class, 'updateProgress'])->name('todos.progress');
    Route::put('quizzes/progress/{quiz}', [QuizController::class, 'updateProgress'])->name('quizzes.progress');
    Route::put('revisions/progress/{revision}', [RevisionController::class, 'updateProgress'])->name('revisions.progress');
    Route::put('visuals/progress/{visual}', [VisualController::class, 'updateProgress'])->name('visuals.progress');
    Route::put('quickScans/progress/{quickScan}', [QuickScanController::class, 'updateProgress'])->name('quickScans.progress');

    // Update favorites
    Route::put('sections/favorites/{section}', [SectionController::class, 'updateFavorites'])->name('sections.favorites');
    Route::put('goals/favorites/{goal}', [GoalController::class, 'updateFavorites'])->name('goals.favorites');
    Route::put('magazines/favorites/{magazine}', [MagazineController::class, 'updateFavorites'])->name('magazines.favorites');
    Route::put('todos/favorites/{todo}', [TodoController::class, 'updateFavorites'])->name('todos.favorites');
    Route::put('quizzes/favorites/{quiz}', [QuizController::class, 'updateFavorites'])->name('quizzes.favorites');
    Route::put('revisions/favorites/{revision}', [RevisionController::class, 'updateFavorites'])->name('revisions.favorites');
    Route::put('visuals/favorites/{visual}', [VisualController::class, 'updateFavorites'])->name('visuals.favorites');
    Route::put('quickScans/favorites/{quickScan}', [QuickScanController::class, 'updateFavorites'])->name('quickScans.favorites');

    // Update rates
    Route::put('goals/rates/{goal:id}', [GoalController::class, 'updateRate'])->name('goals.rates');
    Route::put('revisions/rates/{revision}', [RevisionController::class, 'updateRate'])->name('revisions.rates');
    Route::put('magazines/rates/{magazine}', [MagazineController::class, 'updateRate'])->name('magazines.rates');
    Route::put('todos/rates/{todo}', [TodoController::class, 'updateRate'])->name('todos.rates');
    Route::put('quizzes/rates/{quiz}', [QuizController::class, 'updateRate'])->name('quizzes.rates');
    Route::put('visuals/rates/{visual}', [VisualController::class, 'updateRate'])->name('visuals.rates');
    Route::put('quickScans/rates/{quickScan}', [QuickScanController::class, 'updateRate'])->name('quickScans.rates');

    // Book download routes
    Route::post('/books/{book}/download', [BookController::class, 'sendDownloadLink'])->name('books.download');
    Route::get('/books/{book}/download-page', [BookController::class, 'downloadPage'])->name('books.download.page');
    Route::get('/books/{book}/direct-download', [BookController::class, 'directDownload'])->name('books.direct.download');

    /*
     |------------------------------------
     | Courses Sections
     |------------------------------------
     */
    Route::resource('sections', SectionController::class)->only(['show']);
    Route::resource('lessons', LessonController::class)->only(['show']);
    Route::resource('goals', GoalController::class)->only(['show']);
    Route::resource('magazines', MagazineController::class)->only(['show']);
    Route::resource('todos', TodoController::class)->only(['show']);
    Route::resource('quizzes', QuizController::class)->only(['show']);
    Route::resource('revisions', RevisionController::class)->only(['show']);
    Route::resource('visuals', VisualController::class)->only(['show']);
    Route::resource('quickScans', QuickScanController::class)->only(['show']);
    Route::post('orders/{type}/{id}', [OrdersController::class, 'order'])->name('orders.create');
});

//Route::middleware(['auth:sanctum', 'verified'])
//    ->group(function () {
//        Route::put('user/generate_referral_token',
//            [UserController::class, 'generateReferralToken'])->name('user.generate-referral-token');
//    });

Route::get('orders/{order:transaction_id}/receipt', [OrdersController::class, 'receipt'])->name('orders.download');
