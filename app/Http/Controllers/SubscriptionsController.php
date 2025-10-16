<?php

namespace App\Http\Controllers;

use App\Models\Subscription;
use Illuminate\Http\Request;


class SubscriptionsController extends Controller
{
    public function index()
    {
        $subscriptions = Subscription::with(['user', 'plan'])
            ->orderByDesc('created_at')
            ->paginate(10);

        return view('subscription.index', compact('subscriptions'));
    }
}

