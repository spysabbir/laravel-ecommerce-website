<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Default_setting;
use App\Models\Mail_setting;
use App\Models\Payment_setting;
use App\Models\Seo_setting;
use App\Models\SmsSetting;
use App\Models\Social_login_setting;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Intervention\Image\Facades\Image;

class SettingController extends Controller
{
    // Change Env Function
    public function changeEnv($envKey, $envValue)
    {
        $envFilePath = app()->environmentFilePath();
        $strEnv = file_get_contents($envFilePath);
        $strEnv.="\n";
        $keyStartPosition = strpos($strEnv, "{$envKey}=");
        $keyEndPosition = strpos($strEnv, "\n",$keyStartPosition);
        $oldLine = substr($strEnv, $keyStartPosition, $keyEndPosition-$keyStartPosition);

        if(!$keyStartPosition || !$keyEndPosition || !$oldLine){
            $strEnv.="{$envKey}={$envValue}\n";
        }else{
            $strEnv=str_replace($oldLine, "{$envKey}={$envValue}",$strEnv);
        }
        $strEnv=substr($strEnv, 0, -1);
        file_put_contents($envFilePath, $strEnv);
    }

    public function defaultSetting(){
        $default_setting = Default_setting::first();
        return view('admin.setting.default', compact('default_setting'));
    }

    public function defaultSettingUpdate(Request $request, $id){
        $request->validate([
            '*' => 'required',
            'logo_photo' => 'nullable|image|mimes:png,jpg,jpeg,webp',
            'favicon' => 'nullable|image|mimes:png,jpg,jpeg,webp',
        ]);
        $this->changeEnv("APP_NAME", "'$request->app_name'");
        $this->changeEnv("APP_URL", "'$request->app_url'");
        $this->changeEnv("TIME_ZONE", "'$request->time_zone'");
        $default_setting = Default_setting::where('id', $id)->first();
        Default_setting::where('id', $id)->update([
            'app_name' => $request->app_name,
            'app_url' => $request->app_url,
            'time_zone' => $request->time_zone,
            'main_phone' => $request->main_phone,
            'support_phone' => $request->support_phone,
            'main_email' => $request->main_email,
            'support_email' => $request->support_email,
            'address' => $request->address,
            'google_map_link' => $request->google_map_link,
            'facebook_link' => $request->facebook_link,
            'twitter_link' => $request->twitter_link,
            'instagram_link' => $request->instagram_link,
            'linkedin_link' => $request->linkedin_link,
            'youtube_link' => $request->youtube_link,
            'updated_by' => Auth::guard('admin')->user()->id,
            'updated_at' => Carbon::now(),
        ]);

        // Logo Photo Upload
        if($request->hasFile('logo_photo')){
            if($default_setting->logo_photo != NULL){
                unlink(base_path("public/uploads/default_photo/").$default_setting->logo_photo);
            }
            $logo_photo_name = "Logo-Photo".".". $request->file('logo_photo')->getClientOriginalExtension();
            $upload_link = base_path("public/uploads/default_photo/").$logo_photo_name;
            Image::make($request->file('logo_photo'))->resize(192, 40)->save($upload_link);
            Default_setting::where('id', $id)->update([
                'logo_photo' => $logo_photo_name
            ]);
        }

        // Favicon Upload
        if($request->hasFile('favicon')){
            if($default_setting->favicon != NULL){
                unlink(base_path("public/uploads/default_photo/").$default_setting->favicon);
            }
            $favicon_name = "Favicon".".". $request->file('favicon')->getClientOriginalExtension();
            $upload_link = base_path("public/uploads/default_photo/").$favicon_name;
            Image::make($request->file('favicon'))->resize(70, 70)->save($upload_link);
            Default_setting::where('id', $id)->update([
                'favicon' => $favicon_name
            ]);
        }

        $notification = array(
            'message' => 'Default setting details updated successfully.',
            'alert-type' => 'success'
        );

        return back()->with($notification);

    }

    public function mailSetting(){
        $mail_setting = Mail_setting::first();
        return view('admin.setting.mail', compact('mail_setting'));
    }

    public function mailSettingUpdate(Request $request, $id){
        $request->validate([
            '*' => 'required',
        ]);
        $this->changeEnv("MAIL_MAILER", $request->mailer);
        $this->changeEnv("MAIL_HOST", $request->host);
        $this->changeEnv("MAIL_PORT", $request->port);
        $this->changeEnv("MAIL_USERNAME", $request->username);
        $this->changeEnv("MAIL_PASSWORD", $request->password);
        $this->changeEnv("MAIL_ENCRYPTION", $request->encryption);
        $this->changeEnv("MAIL_FROM_ADDRESS", $request->from_address);
        Mail_setting::where('id', $id)->update([
            'mailer' => $request->mailer,
            'host' => $request->host,
            'port' => $request->port,
            'username' => $request->username,
            'password' => $request->password,
            'encryption' => $request->encryption,
            'from_address' => $request->from_address,
            'updated_by' => Auth::guard('admin')->user()->id,
            'updated_at' => Carbon::now(),
        ]);

        $notification = array(
            'message' => 'Mail details updated successfully.',
            'alert-type' => 'success'
        );

        return back()->with($notification);
    }

    public function paymentSetting(){
        $payment_setting = Payment_setting::first();
        return view('admin.setting.payment', compact('payment_setting'));
    }

    public function paymentSettingUpdate(Request $request, $id){
        $request->validate([
            '*' => 'required',
        ]);
        $this->changeEnv("STORE_ID", $request->store_id);
        $this->changeEnv("STORE_PASSWORD", $request->store_password);
        Payment_setting::where('id', $id)->update([
            'store_id' => $request->store_id,
            'store_password' => $request->store_password,
            'updated_by' => Auth::guard('admin')->user()->id,
            'updated_at' => Carbon::now(),
        ]);

        $notification = array(
            'message' => 'SSL Payment details updated successfully.',
            'alert-type' => 'success'
        );

        return back()->with($notification);
    }

    public function socialLoginSetting(){
        $social_login_setting = Social_login_setting::first();
        return view('admin.setting.social-login', compact('social_login_setting'));
    }

    public function socialLoginSettingUpdate(Request $request, $id){
        $request->validate([
            '*' => 'required',
            'google_auth_status' => 'nullable',
            'facebook_auth_status' => 'nullable',
        ]);

        $this->changeEnv("GOOGLE_CLIENT_ID", $request->google_client_id);
        $this->changeEnv("GOOGLE_CLIENT_SECRET", $request->google_client_secret);
        $this->changeEnv("GOOGLE_REDIRECT_URI", $request->google_redirect_url);
        $this->changeEnv("FACEBOOK_CLIENT_ID", $request->facebook_client_id);
        $this->changeEnv("FACEBOOK_CLIENT_SECRET", $request->facebook_client_secret);
        $this->changeEnv("FACEBOOK_REDIRECT_URI", $request->facebook_redirect_url);

        if ($request->google_auth_status == NULL) {
            $google_auth_status = "No";
        } else {
            $google_auth_status = $request->google_auth_status;
        }

        if ($request->facebook_auth_status == NULL) {
            $facebook_auth_status = "No";
        } else {
            $facebook_auth_status = $request->facebook_auth_status;
        }

        Social_login_setting::where('id', $id)->update([
            'google_auth_status' => $google_auth_status,
            'google_client_id' => $request->google_client_id,
            'google_client_secret' => $request->google_client_secret,
            'google_redirect_url' => $request->google_redirect_url,
            'facebook_auth_status' => $facebook_auth_status,
            'facebook_client_id' => $request->facebook_client_id,
            'facebook_client_secret' => $request->facebook_client_secret,
            'facebook_redirect_url' => $request->facebook_redirect_url,
            'updated_by' => Auth::guard('admin')->user()->id,
            'updated_at' => Carbon::now(),
        ]);

        $notification = array(
            'message' => 'Social login details updated successfully.',
            'alert-type' => 'success'
        );

        return back()->with($notification);
    }

    public function seoSetting(){
        $seo_setting = Seo_setting::first();
        return view('admin.setting.seo', compact('seo_setting'));
    }

    public function seoSettingUpdate(Request $request, $id){
        $request->validate([
            '*' => 'required',
            'seo_image' => 'nullable|image|mimes:png,jpg,jpeg,webp',
        ]);
        $seo_setting = Seo_setting::where('id', $id)->first();

        Seo_setting::where('id', $id)->update([
            'title' => $request->title,
            'keywords' => $request->keywords,
            'description' => $request->description,
            'updated_by' => Auth::guard('admin')->user()->id,
            'updated_at' => Carbon::now(),
        ]);

         // SEO Photo Upload
         if($request->hasFile('seo_image')){
            if($seo_setting->seo_image != NULL){
                unlink(base_path("public/uploads/default_photo/").$seo_setting->seo_image);
            }
            $seo_image_name = "Seo-Image".".". $request->file('seo_image')->getClientOriginalExtension();
            $upload_link = base_path("public/uploads/default_photo/").$seo_image_name;
            Image::make($request->file('seo_image'))->resize(70, 70)->save($upload_link);
            Seo_setting::where('id', $id)->update([
                'seo_image' => $seo_image_name
            ]);
        }

        $notification = array(
            'message' => 'Seo details updated successfully.',
            'alert-type' => 'success'
        );

        return back()->with($notification);
    }

    public function smsSetting(){
        $sms_setting = SmsSetting::first();
        return view('admin.setting.sms', compact('sms_setting'));
    }

    public function smsSettingUpdate(Request $request, $id){
        $request->validate([
            '*' => 'required',
        ]);

        SmsSetting::where('id', $id)->update([
            'api_key' => $request->api_key,
            'sender_id' => $request->sender_id,
            'updated_by' => Auth::guard('admin')->user()->id,
            'updated_at' => Carbon::now(),
        ]);

        $notification = array(
            'message' => 'Sms details updated successfully.',
            'alert-type' => 'success'
        );

        return back()->with($notification);
    }
}
