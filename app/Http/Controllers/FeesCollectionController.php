<?php

namespace App\Http\Controllers;

use App\Exports\ExportCollectFees;
use App\Models\ClassModel;
use App\Models\SettingModel;
use App\Models\StudentAddFeesModel;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Session;
use Maatwebsite\Excel\Facades\Excel;
use Stripe\Stripe;

class FeesCollectionController extends Controller
{
    public function collection_fees(Request $request)
    {
        $data['getClass'] = ClassModel::getClass();
        if (!empty($request->all())) {
            $data['getRecord'] = User::getConllertFeesStudent();
        }
        $data['header_title'] = "Collection Fees";
        return view('admin.fees_collection.collection_fees', $data);
    }

    public function collection_fees_add($student_id)
    {
        $data['getFees'] = StudentAddFeesModel::getFees($student_id);
        $getStudent = User::getSingleClass($student_id);
        $data['paid_amount'] = StudentAddFeesModel::getPaidAmount($student_id, $getStudent->class_id);
        $data['getStudent'] = $getStudent;
        $data['header_title'] = "Collection Fees";
        // dd($data);
        return view('admin.fees_collection.collection_fees_add', $data);
    }
    public function export_collect_fees_repost(Request $request){

        return Excel::download(new ExportCollectFees, 'CollectFeesReport_' . date('d-m-Y') . '.xls');
    }

    public function collection_fees_repost()
    {
        $data['getClass'] = ClassModel::getClass();

        $data['getRecord'] = StudentAddFeesModel::getRecord();
        // dd($data);

        $data['header_title'] = "Collection Fees";
        return view('admin.fees_collection.collection_fees_repost', $data);
    }
    public function collection_fees_insert($student_id, Request $request)
    {
        $getStudent = User::getSingleClass($student_id);
        $paid_amount = StudentAddFeesModel::getPaidAmount($student_id, $getStudent->class_id);

        if (!empty($request->amount)) {
            $RemaningAmount = $getStudent->amount - $paid_amount;
            if ($RemaningAmount >= $request->amount) {

                $remaning_amount_user = $RemaningAmount - $request->amount;

                $payment = new StudentAddFeesModel;
                $payment->student_id = $student_id;
                $payment->class_id = $getStudent->class_id;
                $payment->paid_amount = $request->amount;
                $payment->total_amount =  $RemaningAmount;
                $payment->remaning_amount = $remaning_amount_user;
                $payment->payment_type = $request->payment_type;
                $payment->remark = $request->remark;
                $payment->is_payment = 1;
                $payment->created_by = Auth::user()->id;
                $payment->save();

                return redirect()->back()->with('success', "Seccessfully Saved Payment");
            } else {
                return redirect()->back()->with('error', "Insufficient Amount");
            }
        } else {
            return redirect()->back()->with('error', "You need add your payment at least one baht");
        }
    }

    //! student side 
    public function collection_fees_student(Request $request)
    {
        $student_id = Auth::user()->id;
        $data['getFees'] = StudentAddFeesModel::getFees($student_id);

        $getStudent = User::getSingleClass($student_id);
        $data['paid_amount'] = StudentAddFeesModel::getPaidAmount($student_id, $getStudent->class_id);
        $data['getStudent'] = $getStudent;

        $data['header_title'] = "Fees Collection";
        return view('student.collection_fees_student', $data);
    }
    public function collection_fees_student_payment(Request $request)
    {
        $student_id = Auth::user()->id;
        $getStudent = User::getSingleClass($student_id);
        $paid_amount = StudentAddFeesModel::getPaidAmount($student_id, $getStudent->class_id);

        if (!empty($request->amount)) {
            $RemaningAmount = $getStudent->amount - $paid_amount;
            if ($RemaningAmount >= $request->amount) {

                $remaning_amount_user = $RemaningAmount - $request->amount;

                $payment = new StudentAddFeesModel;
                $payment->student_id = $student_id;
                $payment->class_id = $getStudent->class_id;
                $payment->paid_amount = $request->amount;
                $payment->total_amount =  $RemaningAmount;
                $payment->remaning_amount = $remaning_amount_user;
                $payment->payment_type = $request->payment_type;
                $payment->remark = $request->remark;
                $payment->created_by = Auth::user()->id;

                $getSetting = SettingModel::getSingle();

                if ($request->payment_type == 'Paypal') {
                    // Your PayPal payment handling logic
                } elseif ($request->payment_type == 'Stripe') {
                    $setApiKey = $getSetting->stripe_key;
                    $setPublicKey = $getSetting->stripe_secret;

                    Stripe::setApiKey($setApiKey);
                    $finalPrice = $request->amount * 100;

                    $session = \Stripe\Checkout\Session::create([
                        'customer_email' => Auth::user()->email,
                        'payment_method_types' => ['card'],
                        'mode' => 'payment',
                        'line_items'  => [[
                            'price_data' => [
                                'currency' => 'usd',
                                'product_data' => [
                                    'name' => 'Student Payment',
                                    'description' => 'Student Payment',
                                    'images' => [url('assets/img/logo-2x.png')],
                                ],
                                'unit_amount' => intval($finalPrice),
                            ],
                            'quantity' => 1,
                        ]],
                        'success_url' => url('student/stripe/payment-success'),
                        'cancel_url' => url('student/stripe/payment-error'),
                    ]);
                    $payment->stripe_session_id = $session['id'];

                    $payment->save();

                    $data['session_id'] = $session['id'];
                    Session::put('stripe_session_id', $session['id']);
                    $data['setPublicKey'] = $setPublicKey;
                    return view('stripe_charge', $data);
                }
                return redirect()->back()->with('success', "Successfully Saved Payment");
            } else {
                return redirect()->back()->with('error', "Insufficient Amount");
            }
        } else {
            return redirect()->back()->with('error', "You need to add your payment at least one baht");
        }
    }
    public function stripe_payment_success()
    {

        $getSetting = SettingModel::getSingle();
        $setApiKey = $getSetting->stripe_key;
        $setPublicKey = $getSetting->stripe_secret;

        $trans_id = Session::get('stripe_session_id');
        $getFee = StudentAddFeesModel::where('stripe_session_id', '=', $trans_id)->first();

        \Stripe\Stripe::setApiKey($setApiKey);

        $getdata = \Stripe\Checkout\Session::retrieve($trans_id);

        // dd($getFee);
        if (
            !empty($getdata->id)
            && $getdata->id == $trans_id
            && !empty($getFee)
            && $getdata->payment_status == 'paid'
            && $getdata->status == 'complete'
        ) {
            $getFee->is_payment = 1;
            $getFee->payment_data = json_encode($getdata);
            $getFee->save();
            Session::forget('stripe_session_id');
            return  redirect('student/collection_fees')->with('success', 'Stripe payment success');
        } else {
            return redirect('student/collection_fees')->with('error', 'Stripe payment error');
        }
    }
    public function stripe_payment_error()
    {
        return redirect('student/collection_fees')->with('error', 'Stripe payment error');
    }

    //! parent side 
    public function collection_fees_student_parent($student_id, Request $request)
    {

        $data['getFees'] = StudentAddFeesModel::getFees($student_id);

        $getStudent = User::getSingleClass($student_id);
        $data['paid_amount'] = StudentAddFeesModel::getPaidAmount($student_id, $getStudent->class_id);
        $data['getStudent'] = $getStudent;
        //  dd($data);
        $data['header_title'] = "Fees Collection";
        return view('parent.collection_fees_student', $data);
    }
    private function isValidApiKey($apiKey)
    {
        // ทำ HTTP request เพื่อตรวจสอบความถูกต้องของ API Key
        // ในกรณีนี้เราสามารถใช้ Stripe API ได้ โดยการทำ request ไปยัง Stripe API ด้วยการใช้ API key แล้วตรวจสอบคำตอบ
        // ในตัวอย่างนี้เราจะใช้ HTTP request ไปยัง URL ของ Stripe API โดยใช้ API key เพื่อทำการตรวจสอบว่า API key ถูกต้องหรือไม่
        $response = Http::withHeaders([
            'Authorization' => 'Bearer ' . $apiKey,
        ])->get('https://api.stripe.com/v1/customers');

        // ตรวจสอบคำตอบจาก Stripe API
        if ($response->successful()) {
            return true; // API key ถูกต้อง
        } else {
            return false; // API key ไม่ถูกต้อง
        }
    }
    public function collection_fees_student_parent_payment($student_id, Request $request)
    {
        $getStudent = User::getSingleClass($student_id);
        $paid_amount = StudentAddFeesModel::getPaidAmount($student_id, $getStudent->class_id);

        if (!empty($request->amount)) {
            $RemaningAmount = $getStudent->amount - $paid_amount;
            if ($RemaningAmount >= $request->amount) {

                $remaning_amount_user = $RemaningAmount - $request->amount;

                $payment = new StudentAddFeesModel;
                $payment->student_id = $student_id;
                $payment->class_id = $getStudent->class_id;
                $payment->paid_amount = $request->amount;
                $payment->total_amount =  $RemaningAmount;
                $payment->remaning_amount = $remaning_amount_user;
                $payment->payment_type = $request->payment_type;
                $payment->remark = $request->remark;
                $payment->created_by = Auth::user()->id;

                $getSetting = SettingModel::getSingle();

                // Check if the API key is valid
                if ($request->payment_type == 'Stripe') {
                    $setApiKey = $getSetting->stripe_key;
                    $setPublicKey = $getSetting->stripe_secret;

                    // Validate the API key
                    if (!$this->isValidApiKey($setApiKey)) {
                        return redirect()->back()->with('error', 'Invalid API Key');
                    }

                    Stripe::setApiKey($setApiKey);
                    $finalPrice = $request->amount * 100;
                    // dd($getStudent->email);
                    $session = \Stripe\Checkout\Session::create([
                        'customer_email' => $getStudent->email,
                        'payment_method_types' => ['card'],
                        'mode' => 'payment',
                        'line_items'  => [[
                            'price_data' => [
                                'currency' => 'usd',
                                'product_data' => [
                                    'name' => 'Student Payment',
                                    'description' => 'Student Payment',
                                    'images' => [url('assets/img/logo-2x.png')],
                                ],
                                'unit_amount' => intval($finalPrice),
                            ],
                            'quantity' => 1,
                        ]],
                        'success_url' => url('parent/stripe/payment-success'),
                        'cancel_url' => url('parent/stripe/payment-error'),
                    ]);
                    $payment->stripe_session_id = $session['id'];

                    $payment->save();

                    $data['session_id'] = $session['id'];
                    Session::put('stripe_session_id', $session['id']);
                    $data['setPublicKey'] = $setPublicKey;
                    return view('stripe_charge', $data);
                }
                return redirect()->back()->with('success', "Successfully Saved Payment");
            } else {
                return redirect()->back()->with('error', "Insufficient Amount");
            }
        } else {
            return redirect()->back()->with('error', "You need to add your payment at least one baht");
        }
    }
    // ฟังก์ชันที่ใช้ในการดำเนินการหลังจากผู้ใช้ชำระเงินผ่าน Stripe สำเร็จ
    public function stripe_payment_success_parent()
    {
        // ดึงข้อมูลการตั้งค่าของ Stripe จากฐานข้อมูล
        $getSetting = SettingModel::getSingle();
        $setApiKey = $getSetting->stripe_key;
        $setPublicKey = $getSetting->stripe_secret;

        // ดึง Session ID จากเซสชันของ Laravel
        $trans_id = Session::get('stripe_session_id');
        // ค้นหาข้อมูลการชำระเงินของนักเรียนจาก Session ID
        $getFee = StudentAddFeesModel::where('stripe_session_id', $trans_id)->first();

        if (!$getFee || !$trans_id) {
            return redirect()->back()->with('error', 'Invalid payment session');
        }

        \Stripe\Stripe::setApiKey($setApiKey);

        try {
            // ดึงข้อมูลการชำระเงินจาก Stripe โดยใช้ Session ID
            $getdata = \Stripe\Checkout\Session::retrieve($trans_id);

            // ตรวจสอบความถูกต้องของข้อมูลการชำระเงิน
            if (
                $getdata->id == $trans_id
                && $getdata->payment_status == 'paid'
                && $getdata->status == 'complete'
            ) {
                // อัปเดตสถานะการชำระเงินของนักเรียนในฐานข้อมูล
                $getFee->is_payment = 1;
                $getFee->payment_data = json_encode($getdata);
                $getFee->save();
                // ลบ Session ID ออกจากเซสชันของ Laravel
                Session::forget('stripe_session_id');
                // ส่งผู้ใช้ไปยังหน้าการเรียกเก็บค่าธรรมเนียมของนักเรียนพร้อมกับข้อความแจ้งเตือนการชำระเงินสำเร็จ
                return redirect('parent/my_student/collection_fees_student/' . $getFee->student_id)->with('success', 'Stripe payment success');
            } else {
                // ส่งผู้ใช้ไปยังหน้าการเรียกเก็บค่าธรรมเนียมของนักเรียนพร้อมกับข้อความแจ้งเตือนเกี่ยวกับข้อผิดพลาดในการชำระเงิน
                return redirect('parent/my_student/collection_fees_student/' . $getFee->student_id)->with('error', 'Stripe payment error');
            }
        } catch (\Exception $e) {
            // ส่งผู้ใช้ไปยังหน้าการเรียกเก็บค่าธรรมเนียมของนักเรียนพร้อมกับข้อความแจ้งเตือนเกี่ยวกับข้อผิดพลาดในการดำเนินการ
            return redirect('parent/my_student/collection_fees_student/' . $getFee->student_id)->with('error', $e->getMessage());
        }
    }
    // ฟังก์ชันที่ใช้ในการแสดงข้อความแจ้งเตือนเกี่ยวกับข้อผิดพลาดในการชำระเงิน
    public function stripe_payment_error_parent()
    {
        // ส่งผู้ใช้กลับไปยังหน้าที่แสดงข้อมูลการเรียกเก็บค่าธรรมเนียมของนักเรียนพร้อมกับข้อความแจ้งเตือนเกี่ยวกับข้อผิดพลาดในการชำระเงิน
        return redirect()->back()->with('error', 'Stripe payment error');
    }
}
