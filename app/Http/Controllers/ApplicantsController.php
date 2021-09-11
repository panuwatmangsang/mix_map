<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Applicants;
use App\Models\JobsSearch;
use Illuminate\Support\Facades\Hash;

class ApplicantsController extends Controller
{
    public function applicants_login()
    {
        return view('auth.applicants_login');
    }

    // =====================================================================================================================================
    // =====================================================================================================================================

    public function applicants_register()
    {
        return view('auth.applicants_register');
    }

    // =====================================================================================================================================
    // =====================================================================================================================================

    public function applicants_save(Request $request)
    {
        // register
        // validate requests
        $request->validate([
            'app_name' => 'required',
            'app_email' => 'required|email|unique:applicants',
            'app_password' => 'required|min:5|max:12',
        ]);

        // insert data into database
        $app = new Applicants;
        $app->app_name = $request->app_name;
        $app->app_email = $request->app_email;
        $app->app_password = Hash::make($request->app_password);
        $save = $app->save();

        if ($save) {
            return back()->with('success', 'เพิ่มบัญชีใหม่เรียบร้อยแล้ว');
        } else {
            return back()->with('fail', 'เกิดข้อผิดพลาด ลองอีกครั้ง');
        }
    }

    // =====================================================================================================================================
    // =====================================================================================================================================

    public function applicants_check(Request $request)
    {
        // return $request->input();

        // login
        //validate request
        $request->validate([
            'app_email' => 'required|email',
            'app_password' => 'required|min:5|max:12'
        ]);

        $appInfo = Applicants::where('app_email', '=', $request->app_email)->first();

        if (!$appInfo) {
            return back()->with('fail', 'ไม่รู้จักบัญชีนี้');
        } else {
            // check password
            if (Hash::check($request->app_password, $appInfo->app_password)) {
                $request->session()->put('LoggedApp', $appInfo->app_name);
                return redirect('applicants/applicants_home');
            } else {
                return back()->with('fail', 'รหัสผ่านผิด');
            }
        }
    }

    // =====================================================================================================================================
    // =====================================================================================================================================

    // logout
    public function applicants_logout()
    {
        if (session()->has('LoggedApp')) {
            session()->pull('LoggedApp');
            return redirect('/applicants/applicants_home');
        }
    }

    // =====================================================================================================================================
    // =====================================================================================================================================

    // display index page
    public function applicants_index()
    {
        $data = ['LoggedAppInfo' => Applicants::where('app_id', '=', session('LoggedApp'))->first()];
        return view('applicants.applicants_index', $data);
    }

    // =====================================================================================================================================
    // =====================================================================================================================================

    // display my jobs page
    public function applicants_myjobs()
    {
        $data = ['LoggedAppInfo' => Applicants::where('app_id', '=', session('LoggedApp'))->first()];
        return view('applicants.applicants_myjobs', $data);
    }

    // =====================================================================================================================================
    // =====================================================================================================================================

    // display search/jobs post page
    public function applicants_search()
    {
        $ent_post = JobsSearch::all();
        return view('applicants.applicants_search', compact('ent_post'));
    }
}
