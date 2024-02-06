<?php

namespace App\Http\Controllers\api\v1;

use App\Models\News;

use App\Models\User;
use App\Models\Report;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use App\Http\Controllers\Controller;
use App\Http\Resources\NewsResource;
use Illuminate\Support\Facades\Mail;
use App\Mail\ServiceProviderApprovedMail;
use App\Mail\ServiceProviderRejectedMail;

class AdminController extends Controller
{
    // show pet service providers where their status are pending
    public function show_service_provider()
    {
        $user = User::where('user_status', 'pending')->get();
        
        return response()->json([
            'users' => $user
        ]);
    }

    // show specific service provider
    public function show_specifc_service_provider(string $id)
    {
        $user = User::with('certificate')->findOrFail($id);

        return response()->json([
            'user' => $user
        ]);
    }

    // determine if service provider application is approved or rejected
    public function service_provider_application(Request $request, String $id)
    {
        $validated = $request->validate([
            'user_status' => ['required', Rule::in(['approved', 'rejected'])]
        ]);

        $user = User::findorFail($id);

        if($validated['user_status'] === 'approved') {
            Mail::to($user->email)->send(new ServiceProviderApprovedMail($user));
        } else {
            Mail::to($user->email)->send(new ServiceProviderRejectedMail($user));
        }

        $user->update(['user_status' => $validated['user_status']]);

        return response()->json(['message' => "Successfully updated status!"]);
    }

    // show pet news where their status are pending and who made them
    public function show_news()
    {
        $news = News::where('news_status', 'pending')
            ->with('user', 'categories')
            ->get();

        return response()->json([
            'news' => NewsResource::collection($news)
        ]);
    }

    // show specific pet news where their status are pending and who made them
    public function show_specific_news(string $id)
    {
        $news = News::with('user', 'categories')
            ->findorFail($id);
        
        return response()->json([
            'news' => new NewsResource($news)]);
    }

    // determine if news is approved or rejected
    public function news_application(Request $request, String $id)
    {
        $validated = $request->validate([
            'news_status' => ['required', Rule::in(['approved', 'rejected'])]
        ]);

        $news = News::findorFail($id);

        $news->update(['news_status' => $validated['news_status']]);

        return response()->json(['message' => "Successfully updated news status!"]);
    }

    // display all reports
    public function show_reports()
    {
        $report = Report::with('user')->get();
        
        return response()->json(['report' => $report]);
    }
    
    // display a specific report.
    public function show_specific_report(string $id)
    {
        $report = Report::with('user')->findorFail($id) ?? null;
        
        return response()->json(['report' => $report]);
    }

    // show all the users
    public function show_all_users()
    {
        $user = User::where('user_status', 'approved')->get();

        return response()->json(['user' => $user]);
    }

    // show specifc user details
    public function show_specific_user(string $id)
    {
        $user = User::find($id);

        return response()->json(['user' => $user]);
    }

    // delete the user
    public function delete_user(string $id)
    {
        $user = User::findOrFail($id);

        $user->update([
            'user_status' => 'rejected'
        ]);

        return response()->json(['message' => "User successfully deleted!"]);
    }
}
