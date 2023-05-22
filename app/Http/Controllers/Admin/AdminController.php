<?php

namespace App\Http\Controllers\Admin;

use App\Models\Brand;
use App\Models\Category;
use App\Models\Childcategory;
use App\Models\Contact_message;
use App\Models\Order_summery;
use App\Models\Product;
use App\Models\Subcategory;
use App\Models\Subscriber;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Intervention\Image\Facades\Image;
use Yajra\DataTables\Facades\DataTables;
use App\Http\Controllers\Controller;
use App\Jobs\NewsletterSendJobs;
use App\Mail\NewsletterMail;
use App\Models\Admin;
use App\Models\Newsletter;
use App\Models\Visitor;
use App\Models\Warehouse;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;

class AdminController extends Controller
{
    public function dashboard()
    {
        $users = User::count();
        $order_summeries = Order_summery::all();
        $subscribers = Subscriber::count();
        $contact_messages = Contact_message::count();
        $categories = Category::count();
        $subcategories = Subcategory::count();
        $childcategories = Childcategory::count();
        $brands = Brand::count();
        $products = Product::count();
        $visitors = Visitor::count();
        return view('admin.dashboard', compact('users', 'visitors', 'categories', 'subcategories', 'childcategories', 'brands', 'products', 'subscribers', 'contact_messages', 'order_summeries'));
    }

    public function profile()
    {
        return view('admin.profile.index');
    }

    public function changeProfile(Request $request){
        $request->validate([
            'name' => 'required',
            'phone_number' => 'nullable',
            'profile_photo' => 'nullable|image|mimes:png,jpg,jpeg',
        ]);

        Admin::find(Auth::guard('admin')->id())->update([
            'name' => $request->name,
            'date_of_birth' => $request->date_of_birth,
            'gender' => $request->gender,
            'phone_number' => $request->phone_number,
            'address' => $request->address,
        ]);

        // Profile Photo Upload
        if($request->hasFile('profile_photo')){
            if(Auth::guard('admin')->user()->profile_photo != "default_profile_photo.png"){
                unlink(base_path("public/uploads/profile_photo/").Auth::guard('admin')->user()->profile_photo);
            }
            $profile_photo_name =  "Admin-Profile-Photo-".Auth::guard('admin')->user()->id.".". $request->file('profile_photo')->getClientOriginalExtension();
            $upload_link = base_path("public/uploads/profile_photo/").$profile_photo_name;
            Image::make($request->file('profile_photo'))->resize(300,300)->save($upload_link);
            Admin::find(auth()->id())->update([
                'profile_photo' => $profile_photo_name
            ]);
        }

        $notification = array(
            'message' => 'Profile updated successfully.',
            'alert-type' => 'success'
        );
        return back()->with($notification);
    }

    public function changePassword(Request $request){
        $request->validate([
            'old_password' => 'required',
            'password' => 'required|confirmed|min:8',
            'password_confirmation' => 'required',
        ]);
        if($request->old_password == $request->password){
            return back()->withErrors(['password_error' => 'New password can not same as old password']);
        }
        if(Hash::check($request->old_password, Auth::guard('admin')->user()->password)){
            Admin::find(Auth::guard('admin')->id())->update([
                'password' => Hash::make($request->password)
            ]);
            $notification = array(
                'message' => 'Password Change Success.',
                'alert-type' => 'success'
            );
            return back()->with($notification);
        }else{
            return back()->withErrors(['password_error' => 'Your Old Password is Wrong!']);
        }
    }

    public function allCustomer(Request $request){

        if ($request->ajax()) {
            $customers = "";
            $query = User::select('users.*');

            if($request->status){
                $query->where('users.status', $request->status);
            }

            $customers = $query->get();

            return Datatables::of($customers)
                    ->addIndexColumn()
                    ->editColumn('profile_photo', function($row){
                        return '<img src="'.asset('uploads/profile_photo').'/'.$row->profile_photo.'" width="40" >';
                    })
                    ->editColumn('created_at', function($row){
                            return'
                            <span class="badge bg-light">'.$row->created_at->format('d-M-Y h:m:s A').'</span>
                            ';
                    })
                    ->editColumn('status', function($row){
                        if($row->status == "Yes"){
                            return'
                            <span class="badge bg-success">'.$row->status.'</span>
                            <button type="button" id="'.$row->id.'" class="btn btn-warning btn-sm customerStatusBtn"><i class="fa fa-ban"></i></button>
                            ';
                        }else{
                            return'
                            <span class="badge bg-warning">'.$row->status.'</span>
                            <button type="button" id="'.$row->id.'" class="btn btn-success btn-sm customerStatusBtn"><i class="fa fa-check"></i></button>
                            ';
                        }
                    })
                    ->addColumn('action', function($row){
                        $btn = '
                        <button type="button" id="'.$row->id.'" class="btn btn-success btn-sm viewCustomerModelBtn" data-toggle="modal" data-target="#viewCustomerModel"><i class="fa fa-eye"></i></button>
                        ';
                        return $btn;
                    })
                    ->rawColumns(['profile_photo', 'created_at', 'status', 'action'])
                    ->make(true);
        }

        return view('admin.customer.index');
    }

    public function customerDetails($id)
    {
        $customer_details = User::where('id', $id)->first();
        return view('admin.customer.details', compact('customer_details'));
    }

    public function customerStatus($id){
        if(User::where('id', $id)->first()->status == "Yes"){
            User::where('id', $id)->update([
                'status' => "No",
            ]);
            return response()->json([
                'message' => 'User status inactive successfully',
            ]);
        }else{
            User::where('id', $id)->update([
                'status' =>"Yes",
            ]);
            return response()->json([
                'message' => 'User status active successfully',
            ]);
        }
    }

    public function allAdministration(Request $request){
        if ($request->ajax()) {
            $administrations = "";
            $query = Admin::select('admins.*');

            if($request->status){
                $query->where('admins.status', $request->status);
            }

            if($request->role){
                $query->where('admins.role', $request->role);
            }

            $administrations = $query->get();

            return Datatables::of($administrations)
                    ->addIndexColumn()
                    ->editColumn('profile_photo', function($row){
                        return '<img src="'.asset('uploads/profile_photo').'/'.$row->profile_photo.'" width="40" >';
                    })
                    ->editColumn('created_at', function($row){
                            return'
                            <span class="badge badge-info">'.$row->created_at->format('d-M-Y h:m:s A').'</span>
                            ';
                    })
                    ->editColumn('status', function($row){
                        if($row->status == "Yes"){
                            return'
                            <span class="badge bg-success">'.$row->status.'</span>
                            <button type="button" id="'.$row->id.'" class="btn btn-warning btn-sm administrationStatusBtn"><i class="fa fa-ban"></i></button>
                            ';
                        }else{
                            return'
                            <span class="badge bg-warning">'.$row->status.'</span>
                            <button type="button" id="'.$row->id.'" class="btn btn-success btn-sm administrationStatusBtn"><i class="fa fa-check"></i></button>
                            ';
                        }
                    })
                    ->editColumn('role', function($row){
                        if($row->role == "Super Admin"){
                            return'
                            <span class="badge bg-success">'.$row->role.'</span>
                            ';
                        }else{
                            if($row->role == "Admin"){
                                return'
                                <span class="badge bg-info">'.$row->role.'</span>
                                ';
                            }else{
                                if($row->warehouse_id){
                                    return'
                                    <span class="badge bg-primary">'.$row->role.'</span>
                                    <span class="badge bg-light">'.$row->relationtowarehouse->warehouse_name.'</span>
                                    ';
                                }else{
                                    return'
                                    <span class="badge bg-primary">'.$row->role.'</span>
                                    ';
                                }
                            }
                        }
                    })
                    ->addColumn('action', function($row){
                        $btn = '
                        <button type="button" id="'.$row->id.'" class="btn btn-info btn-sm editAdministrationModelBtn" data-toggle="modal" data-target="#editAdministrationModel"><i class="fa fa-pencil-square-o"></i></button>
                        <button type="button" id="'.$row->id.'" class="btn btn-success btn-sm viewAdministrationModelBtn" data-toggle="modal" data-target="#viewAdministrationModel"><i class="fa fa-eye"></i></button>
                        ';
                        return $btn;
                    })
                    ->rawColumns(['profile_photo', 'created_at', 'status', 'role', 'action'])
                    ->make(true);
        }

        $warehouses = Warehouse::where('status', 'Yes')->get();
        return view('admin.administration.index', compact('warehouses'));
    }

    public function administrationDetails($id)
    {
        $administration_details = Admin::where('id', $id)->first();
        return view('admin.administration.details', compact('administration_details'));
    }

    public function administrationEdit($id)
    {
        $administration = Admin::where('id', $id)->first();
        return response()->json($administration);
    }

    public function administrationUpdate(Request $request, $id)
    {
        $administration = Admin::where('id', $id)->first();
        $validator = Validator::make($request->all(), [
            'role' => 'required',
        ]);

        if($validator->fails()){
            return response()->json([
                'status' => 400,
                'error'=> $validator->errors()->toArray()
            ]);
        }else{
            if($request->role == 'Warehouse' && $request->warehouse_id == NULL){
                return response()->json([
                    'status' => 401,
                    'message' => 'Please select warehouse name.',
                ]);
            }
            $administration->update([
                'role' => $request->role,
                'warehouse_id' => $request->warehouse_id,
                'updated_by' => Auth::guard('admin')->user()->id,
            ]);
            return response()->json([
                'status' => 200,
                'message' => 'Administration updated successfully',
            ]);
        }
    }

    public function administrationStatus($id){
        if(Admin::where('id', $id)->first()->status == "Yes"){
            Admin::where('id', $id)->update([
                'status' => "No",
            ]);
            return response()->json([
                'message' => 'Administration status inactive successfully',
            ]);
        }else{
            Admin::where('id', $id)->update([
                'status' =>"Yes",
            ]);
            return response()->json([
                'message' => 'Administration status active successfully',
            ]);
        }
    }

    public function allSubscriber(Request $request){
        if ($request->ajax()) {
            $subscribers = "";
            $query = Subscriber::select('subscribers.*');

            if($request->status){
                $query->where('subscribers.status', $request->status);
            }

            $subscribers = $query->get();

            return Datatables::of($subscribers)
                    ->addIndexColumn()
                    ->editColumn('created_at', function($row){
                            return'
                            <span class="badge bg-info">'.$row->created_at->format('d-M-Y h:m:s A').'</span>
                            ';
                    })
                    ->editColumn('status', function($row){
                        if($row->status == "Yes"){
                            return'
                            <span class="badge bg-success">'.$row->status.'</span>
                            <button type="button" id="'.$row->id.'" class="btn btn-warning btn-sm subscriberStatusBtn"><i class="fa fa-ban"></i></button>
                            ';
                        }else{
                            return'
                            <span class="badge bg-warning">'.$row->status.'</span>
                            <button type="button" id="'.$row->id.'" class="btn btn-success btn-sm subscriberStatusBtn"><i class="fa fa-check"></i></button>
                            ';
                        }
                    })
                    ->addColumn('action', function($row){
                        $btn = '
                        <button type="button" id="'.$row->id.'" class="btn btn-danger btn-sm deleteSubscriberBtn"><i class="fa fa-trash"></i></button>
                        ';
                        return $btn;
                    })
                    ->rawColumns(['created_at', 'status', 'action'])
                    ->make(true);
        }

        return view('admin.subscriber.index');
    }

    public function subscriberStatus($id){
        if(Subscriber::where('id', $id)->first()->status == "Yes"){
            Subscriber::where('id', $id)->update([
                'status' => "No",
            ]);
            return response()->json([
                'message' => 'Subscriber status inactive successfully',
            ]);
        }else{
            Subscriber::where('id', $id)->update([
                'status' =>"Yes",
            ]);
            return response()->json([
                'message' => 'Subscriber status active successfully',
            ]);
        }
    }

    public function subscriberDestroy($id)
    {
        $subscriber = Subscriber::where('id', $id)->first();

        $subscriber->deleted_by = Auth::guard('admin')->user()->id ;
        $subscriber->save();
        $subscriber->delete();
        return response()->json([
            'message' => 'Subscriber delete successfully',
        ]);
    }

    public function allNewsletter(Request $request){
        if ($request->ajax()) {
            $newsletters = "";
            $query = Newsletter::select('newsletters.*');

            $newsletters = $query->get();

            return Datatables::of($newsletters)
                    ->addIndexColumn()
                    ->editColumn('created_at', function($row){
                            return'
                            <span class="badge bg-info">'.$row->created_at->format('d-M-Y h:m:s A').'</span>
                            ';
                    })
                    ->addColumn('action', function($row){
                        $btn = '
                        <button type="button" id="'.$row->id.'" class="btn btn-info btn-sm viewNewsletterModelBtn" data-toggle="modal" data-target="#viewNewsletterModel"><i class="fa fa-eye"></i></button>
                        ';
                        return $btn;
                    })
                    ->rawColumns(['created_at', 'action'])
                    ->make(true);
        }

        return view('admin.subscriber.newsletter');
    }

    public function sendNewsletter(Request $request)
    {
        $validator = Validator::make($request->all(), [
            '*' => 'required',
        ]);

        if($validator->fails()){
            return response()->json([
                'status' => 400,
                'error'=> $validator->errors()->toArray()
            ]);
        }else{
            $newsletter_id = Newsletter::insertGetId([
                'received_by' => $request->received_by,
                'newsletter_subject' => $request->newsletter_subject,
                'newsletter_body' => $request->newsletter_body,
                'created_at' => Carbon::now(),
            ]);

            dispatch(new NewsletterSendJobs($newsletter_id));

            return response()->json([
                'status' => 200,
                'message' => 'Newsletter send successfully',
            ]);
        }
    }

    public function viewNewsletter($id)
    {
        $newsletter = Newsletter::where('id', $id)->first();
        return view('admin.subscriber.newsletter-details', compact('newsletter'));
    }

    public function contactMessage(Request $request)
    {
        if ($request->ajax()) {
            $contact_messages = "";
            $query = Contact_message::select('contact_messages.*');

            if($request->status){
                $query->where('contact_messages.status', $request->status);
            }

            if($request->created_at){
                $query->where('contact_messages.created_at', 'LIKE', '%'.$request->created_at.'%');
            }

            $contact_messages = $query->get();

            return Datatables::of($contact_messages)
            ->addIndexColumn()
            ->editColumn('created_at', function($row){
                return'
                <span class="badge bg-light">'.$row->created_at->format('d-M-Y h:m:s A').'</span>
                ';
            })
            ->editColumn('status', function($row){
                if($row->status == "Read"){
                    return'
                    <span class="badge bg-success">'.$row->status.'</span>
                    ';
                }else{
                    return'
                    <span class="badge bg-info">'.$row->status.'</span>
                    ';
                }
            })
            ->addColumn('action', function($row){
                $btn = '
                <button type="button" id="'.$row->id.'" class="btn btn-info btn-sm viewContactMessageModelBtn" data-toggle="modal" data-target="#viewContactMessageModel"><i class="fa fa-eye"></i></button>
                <button type="button" id="'.$row->id.'" class="btn btn-danger btn-sm deleteContactMessageBtn"><i class="fa fa-trash"></i></button>
                    ';
                return $btn;
            })
            ->rawColumns(['status', 'created_at', 'action'])
            ->make(true);
        }

        return view('admin.contact.index');
    }

    public function contactMessageDetails($id)
    {
        Contact_message::where('id', $id)->update([
            'status' => "Read",
        ]);
        $message_details = Contact_message::where('id', $id)->first();
        return view('admin.contact.details', compact('message_details'));
    }

    public function contactMessageDestroy($id)
    {
        $contact_message = Contact_message::where('id', $id)->first();

        $contact_message->deleted_by = Auth::guard('admin')->user()->id;
        $contact_message->save();
        $contact_message->delete();
        return response()->json([
            'message' => 'Contact message delete successfully',
        ]);
    }
}
