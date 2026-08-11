<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Article;
use App\Models\Company;
use App\Models\ContactMessage;
use App\Models\Product;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function index(): View
    {
        return view('admin.dashboard', [
            'companiesCount' => Company::count(),
            'productsCount' => Product::count(),
            'articlesCount' => Article::count(),
            'unreadMessagesCount' => ContactMessage::where('is_read', false)->count(),
        ]);
    }
}
