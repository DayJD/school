<?php

namespace App\Http\Controllers;

use App\Models\SettingModel;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class UserController extends Controller
{

    public function MyAccount()
    {
        $data['getRecord'] = User::getSingle(Auth::user()->id);
        $data['header_title'] = "My Account";
        if (Auth::user()->user_type == 1) {
            return view('admin.my_account', $data);
        } elseif (Auth::user()->user_type == 2) {
            return view('teacher.my_account', $data);
        } elseif (Auth::user()->user_type == 3) {
            return view('student.my_account', $data);
        } elseif (Auth::user()->user_type == 4) {
            return view('parent.my_account', $data);
        }
    }
    public function UpdateMyAccountAdmin(Request $request)
    {

        $id = Auth::user()->id;
        $request->validate([
            'email' => 'required|email|unique:users,email,' . $id,
        ]);

        $account = User::getSingle($id);

        $account->name = trim($request->name);
        $account->email = trim($request->email);
        if (!empty($request->file('profile_pic'))) {

            if (!empty($account->getProfile())) {
                unlink('upload/profile/' . $account->profile_pic);
            }
            $ext = $request->file('profile_pic')->getClientOriginalExtension();
            $file = $request->file('profile_pic');
            $randomStr = date('Ymdhis') . Str::random(20);
            $filename = strtolower($randomStr) . '.' . $ext;
            $file->move('upload/profile', $filename);

            $account->profile_pic = $filename;
         
        }
        $account->save();

        return redirect()->back()->with('success', "Account Successfully Updeted");
    }
    public function Setting(Request $request)
    {
        $data['getRecord'] = SettingModel::getSingle();
        $data['header_title'] = "Setting";
        return view('admin.setting' , $data);
    }
    public function UpdateSetting(Request $request)
    {
      
        $setting = SettingModel::getSingle();
        $setting->paypal_email = trim($request->paypal_email);
        $setting->stripe_key = trim($request->stripe_key);
        $setting->stripe_secret = trim($request->stripe_secret);
        $setting->school_name = trim($request->school_name);
        $setting->exam_description = trim($request->exam_description);
        if (!empty($request->file('logo'))) {

            if (!empty($setting->getLogo())) {
                unlink('upload/setting/' . $setting->logo);
            }
            $ext = $request->file('logo')->getClientOriginalExtension();
            $file = $request->file('logo');
            $randomStr = date('Ymdhis') . Str::random(20);
            $filename = strtolower($randomStr) . '.' . $ext;
            $file->move('upload/setting', $filename);
            // dd($request->all());
            $setting->logo = $filename;
         
        }
        if (!empty($request->file('fevicon_icon'))) {

            if (!empty($setting->getFevicon())) {
                unlink('upload/setting/' . $setting->fevicon_icon);
            }
            $ext = $request->file('fevicon_icon')->getClientOriginalExtension();
            $file = $request->file('fevicon_icon');
            $randomStr = date('Ymdhis') . Str::random(20);
            $filename = strtolower($randomStr) . '.' . $ext;
            $file->move('upload/setting', $filename);
            $setting->fevicon_icon = $filename;
        }
        $setting->save();
        return redirect()->back()->with('success', "Setting Successfully Updeted");

    }


    public function UpdateMyAccountTeacher(Request $request)
    {
        $id = Auth::user()->id;
        $request->validate([
            'email' => 'required|email|unique:users,email,' . $id,
            'mobile_number' => 'max:15|min:8',
            'marital_status' => 'max:50',
        ]);

        $account = User::getSingle($id);

        $account->name = trim($request->name);
        $account->last_name = trim($request->last_name);
        $account->gender = trim($request->gender);
        $account->mobile_number = trim($request->mobile_number);

        if (!empty($request->date_of_birth)) {
            $account->date_of_birth = trim($request->date_of_birth);
        }

        if (!empty($request->file('profile_pic'))) {

            if (!empty($account->getProfile())) {
                unlink('upload/profile/' . $account->profile_pic);
            }
            $ext = $request->file('profile_pic')->getClientOriginalExtension();
            $file = $request->file('profile_pic');
            $randomStr = date('Ymdhis') . Str::random(20);
            $filename = strtolower($randomStr) . '.' . $ext;
            $file->move('upload/profile', $filename);

            $account->profile_pic = $filename;
        }
        $account->marital_status = trim($request->marital_status);
        $account->address = trim($request->address);
        $account->permanent_address = trim($request->permanent_address);
        $account->qualification = trim($request->qualification);
        $account->work_experience = trim($request->work_experience);

        $account->email = trim($request->email);
        $account->save();

        return redirect()->back()->with('success', "Account Successfully Updeted");
    }
    public function UpdateMyAccountStudent(Request $request)
    {

        $id = Auth::user()->id;
        $request->validate([
            'email' => 'required|email|unique:users,email,' . $id,
            'mobile_number' => 'max:15|min:8',
            'blood_group' => 'max:10',
            'religion' => 'max:50',
            'roll_number' => 'max:50',
            'caste' => 'max:50',
            'weight' => 'max:10',
            'height' => 'max:10',
        ]);

        $account = User::getSingle($id);

        $account->name = trim($request->name);
        $account->last_name = trim($request->last_name);
        $account->gender = trim($request->gender);
        $account->caste = trim($request->caste);
        $account->religion = trim($request->religion);
        $account->mobile_number = trim($request->mobile_number);
        $account->blood_group = trim($request->blood_group);
        $account->height = trim($request->height);
        $account->weight = trim($request->weight);

        if (!empty($request->date_of_birth)) {
            $account->date_of_birth = trim($request->date_of_birth);
        }

        if (!empty($request->file('profile_pic'))) {

            if (!empty($account->getProfile())) {
                unlink('upload/profile/' . $account->profile_pic);
            }
            $ext = $request->file('profile_pic')->getClientOriginalExtension();
            $file = $request->file('profile_pic');
            $randomStr = date('Ymdhis') . Str::random(20);
            $filename = strtolower($randomStr) . '.' . $ext;
            $file->move('upload/profile', $filename);

            $account->profile_pic = $filename;
        }


        $account->email = trim($request->email);
        $account->save();

        return redirect()->back()->with('success', "Account Successfully Updeted");
    }
    public function UpdateMyAccountParent(Request $request)
    {
        // dd($request->all());
        $id = Auth::user()->id;
        $request->validate([
            'email' => 'required|email|unique:users,email,' . $id,
            'mobile_number' => 'max:15|min:8',
            'occupation' => 'max:255',
            'address' => 'max:255',
        ]);

        $account = User::getSingle($id);

        $account->name = trim($request->name);
        $account->last_name = trim($request->last_name);
        $account->gender = trim($request->gender);
        $account->occupation = trim($request->occupation);
        $account->mobile_number = trim($request->mobile_number);
        $account->address = trim($request->address);

        if (!empty($request->date_of_birth)) {
            $account->date_of_birth = trim($request->date_of_birth);
        }

        if (!empty($request->file('profile_pic'))) {

            if (!empty($account->getProfile())) {
                unlink('upload/profile/' . $account->profile_pic);
            }
            $ext = $request->file('profile_pic')->getClientOriginalExtension();
            $file = $request->file('profile_pic');
            $randomStr = date('Ymdhis') . Str::random(20);
            $filename = strtolower($randomStr) . '.' . $ext;
            $file->move('upload/profile', $filename);

            $account->profile_pic = $filename;
        }


        $account->email = trim($request->email);
        $account->save();

        return redirect()->back()->with('success', "Account Successfully Updeted");
    }

    public function change_password()
    {
        $data['header_title'] = "Change Password";
        return view('profile.change_password', $data);
    }


    public function update_change_password(Request $request)
    {
        $user = User::getSingle(Auth::user()->id);
        if (Hash::check($request->old_password, $user->password)) {
            $user->password = Hash::make($request->new_password);
            $user->save();
            return redirect()->back()->with('success', "Password Successfully Updated");
        } else {
            return redirect()->back()->with('error', "Old Password is not Currect");
        }
    }
}
