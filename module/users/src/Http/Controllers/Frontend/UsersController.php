<?php
/**
 * Created by PhpStorm.
 * User: Admin
 * Date: 4/5/2018
 * Time: 12:15 AM
 */

namespace Users\Http\Controllers\Frontend;

use Advertise\Models\Advertise;
use Advertise\Models\AdvertiseCourse;
use Advertise\Models\AdvertiseUser;
use Barryvdh\Debugbar\Controllers\BaseController;
use Base\Supports\FlashMessage;
use Botble\Ecommerce\Import\ProductImport;
use Cart\Models\Order;
use Cart\Models\OrderDetail;
use ClassLevel\Repositories\ClassLevelRepository;
use Course\Models\Course;
use Course\Models\CurriculumProgress;
use Course\Repositories\CertificateRepository;
use GuzzleHttp\Exception\GuzzleException;
use GuzzleHttp\Client;
use Maatwebsite\Excel\Facades\Excel;
use Users\Import\UsersImport;
use function GuzzleHttp\Promise\all;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Media\Repositories\MediaRepository;
use Notify\Models\Notify;
use Qa\Models\Question;
use Qa\Repositories\ReplyRepository;
use Rating\Repositories\RatingRepository;
use Users\Models\Users;
use Users\Models\UsersMeta;
use Course\Repositories\CourseRepository;
use Auth;
use Illuminate\Support\Facades\DB;
use Qa\Repositories\QuestionRepository;
use Coupon\Repositories\CouponRepository;
use Users\Repositories\UsersRepository;
use Carbon\Carbon;

class UsersController extends BaseController
{
    public function getInfo(ClassLevelRepository  $classLevelRepository)
    {
        $users = \Auth::user();

        $client = new Client(); //GuzzleHttp\Client
        $result = $client->get('https://s.boxme.asia/api/v1/locations/countries/VN/provinces/');
        $city = json_decode($result->getBody())->data;

        $default_city = reset($city);
        $result = $client->get('https://s.boxme.asia/api/v1/locations/countries/VN/' . $default_city->id . '/district/');
        $province = json_decode($result->getBody())->data;

        $users->load('data');
        $users->city = $city;
        $users->province = $province;

        $classLevel = $classLevelRepository->findWhere([
            'status' => 'active'
        ]);

        return view('nqadmin-users::frontend.info', [
            'data' => $users,
            'classLevel' => $classLevel
        ]);
    }

    public function postProvince(Request $request)
    {
        $city_id = $request->city_id;
        $client = new Client(); //GuzzleHttp\Client

        $result = $client->get('https://s.boxme.asia/api/v1/locations/countries/VN/' . $city_id . '/district/');
        $province = json_decode($result->getBody())->data;

        return response()->json($province, 200);
    }

    public function postUpdateInfo(Request $request)
    {
        $input = $request->except('_token');
        $users = \Auth::user();
        $code_user = $users->getDataByKey('code_user');

        if ($code_user == null) {
            while (true) {
                $code = explode('@', $users->email)[0] . strtolower(str_random(3)) . $users->id;
                $meta = $users->data()->where('meta_value', $code)->where('meta_key', 'code_user')->first();
                if ($meta == null) {
                    break;
                }
            }

            $insert = [
                'users_id' => $users->id,
                'meta_key' => 'code_user',
                'meta_value' => $code,
                'created_at' => date('Y-m-d H:i:s'),
            ];
            UsersMeta::insert($insert);
        }

        foreach ($input as $key => $value) {
            if ($key == 'first_name') {
                if ($value != '') {
                    $users->first_name = $value;
                    $users->save();
                }
                continue;
            }

            if ($key == 'position') {
                if ($value[0] != '') {
                    $users->position = $value[0];
                    $users->save();
                }
                continue;
            }

            if ($key == 'dob') {
                $value[0] = $value[0] . '-' . $value[1] . '-' . $value[2];
                $value[1] = $value[3];
            }

            $meta = $users->data()->where('meta_key', $key)->first();
            if ($meta) {
                $meta->meta_value = $value[0];
                $meta->status = $value[1];
                $meta->save();
            } else {
                if ($value[0]) {
                    $insert = [
                        'users_id' => $users->id,
                        'meta_key' => $key,
                        'meta_value' => $value[0],
                        'status' => $value[1],
                        'created_at' => date('Y-m-d H:i:s'),
                    ];
                    UsersMeta::insert($insert);
                }
            }
        }

        return redirect()->back()->with(FlashMessage::returnMessage('create'));
    }

    public function postUpdateContact(Request $request)
    {
        $input = $request->except('_token');
        $users = \Auth::user();

        $key = $input['key'];
        $value = $input['value'];

        if ($key == 'first_name') {
            if ($value != '') {
                $users->first_name = $value;
                $users->save();
            }
        } else {
            $meta = $users->data()->where('meta_key', $key)->first();
            if ($meta) {
                $meta->meta_value = $value;
                $meta->save();
            } else {
                if ($value) {
                    $insert = [
                        'users_id' => $users->id,
                        'meta_key' => $key,
                        'meta_value' => $value,
                        'created_at' => date('Y-m-d H:i:s'),
                    ];
                    UsersMeta::insert($insert);
                }
            }
        }

        return response()->json($input, 200);
    }

    public function postUpdateAvatar(Request $request, MediaRepository $mediaRepository)
    {
        $users = \Auth::user();
        $avarta = $mediaRepository->upload($users->id, $request->file, null, 'avarta');
        $users->thumbnail = $avarta->url;
        $users->save();
        return response()->json(['image' => asset($users->thumbnail)], 200);
    }

    public function getMyCourse(Request $request)
    {
        $user = \Auth::user();
        $courses = Course::getFilter('bought', $request);
        return view('nqadmin-users::frontend.my_course', compact('user', 'courses'));
    }

    public function getLoveCourse()
    {
        return view('nqadmin-users::frontend.love_course');
    }

    public function getHistory()
    {
        $user = \Auth::user();
        $bought = OrderDetail::where('customer', $user->id)->where('status', 'done')->paginate(10);
        return view('nqadmin-users::frontend.history', compact('user', 'bought'));
    }

    public function getHistoryDetail($order_id)
    {
        $user = \Auth::user();
        $order = Order::where('customer', $user->id)->where('id', $order_id)->where('status', 'done')->first();
        return view('nqadmin-users::frontend.history_detail', compact('user', 'order'));
    }

    public function getNotification()
    {
        $notify = Notify::where('status', 'active')
            ->where('apply_with->user', "all")
            ->orWhereRaw('json_contains(apply_with, \'' . Auth::id() . '\',\'$.user\')')
            ->get()->groupBy(function ($date) {
                return Carbon::parse($date->created_at)->format('Y-m-d'); // grouping by years
            });

        return view('nqadmin-users::frontend.notification', [
            'notify' => $notify
        ]);
    }

    public function getChangePassword()
    {
        $users = \Auth::user();
        return view('nqadmin-users::frontend.change_password', [
            'data' => $users
        ]);
    }

    public function postChangePassword(Request $request)
    {
        $users = \Auth::user();

        $validatedData = $request->validate([
            'current-password' => 'required',
            'new-password' => 'required|string|min:6|confirmed',
        ]);

        if (!(Hash::check($request->get('current-password'), $users->password))) {
            // The passwords matches
            return redirect()->back()->with("error", "Your current password does not matches with the password you provided. Please try again.");
        }
        if (strcmp($request->get('current-password'), $request->get('new-password')) == 0) {
            //Current password and new password are same
            return redirect()->back()->with("error", "New Password cannot be same as your current password. Please choose a different password.");
        }

        //Change Password
        $users->password = $request->get('new-password');
        $users->save();

        return redirect()->back()->with("success", "Password changed successfully !");
    }

    public function changePassword(Request $request)
    {

    }


    public function tongquankhoahoc(CourseRepository $courseRepository, Request $request)
    {
        $getAverageRating = \Auth::user()->load(['course' => function ($query) use ($request) {
            $query->with('getRating');
        }])->getAverageRating();

        $users = \Auth::user()->load('sell')->load(['course' => function ($query) use ($request) {
            if (!empty($request->keyword)) {
                $query->where('slug', 'LIKE', '%' . stripUnicode($request->keyword) . '%');
            }
            $query->with('getRating')->with('getLdp')->with('getOrderDetail')->with('owner');
        }]);
        return view('nqadmin-users::frontend.tong_quan_khoa_hoc', [
            'user' => $users,
            'getAverageRating' => $getAverageRating,
        ]);
    }

    public function tongquankhoahochoidap(Request $request, QuestionRepository $questionRepository)
    {
        $userId = Auth::id();
        $cond = array(
            array('course.author', $userId)
        );

        $orderBy = 'desc';
        if ($request->question && $request->question == 1) {
            $orderBy = 'asc';
        }
        if ($request->course && $request->course != 0) {
            $cond[] = array('course.id', $request->course);
        }
        $doesHave = 0;
        $repl = 0;
        if ($request->check) {
            if (in_array(0, $request->check)) {
                $cond[] = array('question.readed', 1);
            }
            if (in_array(1, $request->check)) {
                $repl = 1;
            }
            if (in_array(2, $request->check)) {
                $doesHave = 1;
            }
        }
        $question = $questionRepository->scopeQuery(function ($query) use ($userId, $cond, $orderBy, $doesHave, $repl) {
            $result = $query->select('question.*')->join('course', function ($join) {
                $join->on('question.course', '=', 'course.id');

            })->with('getcourse')->with('owner')->with('getAnswer')->where($cond)->orderBy('question.id', $orderBy);
            if ($doesHave == 1) {
                $result = $query->select('question.*')->join('course', function ($join) {
                    $join->on('question.course', '=', 'course.id');

                })->with('getcourse')->with('owner')->doesntHave('getAnswer')->where($cond)->orderBy('question.id', $orderBy);
            }
            if ($repl == 1) {
                $result = $result->whereDoesntHave('getAnswer', function ($query) {
                    $query->where('usefull', 1);
                })->where(array(array('course.author', $userId)));
            }
            return $result;

        })->paginate(5);
        //unread count
        $unread = $questionRepository->scopeQuery(function ($query) use ($userId, $cond, $orderBy, $doesHave) {
            return $query->select('question.*')->join('course', function ($join) {
                $join->on('question.course', '=', 'course.id');
            })->where(array(array('question.readed', 1), array('course.author', $userId)));
        })->all()->count();
        //not reply count
        $notreply = $questionRepository->scopeQuery(function ($query) use ($userId, $cond, $orderBy, $doesHave) {
            return $query->select('question.*')->join('course', function ($join) {
                $join->on('question.course', '=', 'course.id');
            })->doesntHave('getAnswer')->where(array(array('course.author', $userId)));
        })->all()->count();
        //top cmt count
        $topcmt = $questionRepository->scopeQuery(function ($query) use ($userId, $cond, $orderBy, $doesHave) {
            return $query->select('question.*')->join('course', function ($join) {
                $join->on('question.course', '=', 'course.id');
            })->whereDoesntHave('getAnswer', function ($query) {
                $query->where('usefull', 1);
            })->where(array(array('course.author', $userId)));
        })->all()->count();
        //lay danh sach khoa hoc
        $users = \Auth::user()->load('sell')->load(['course' => function ($query) use ($request) {
            $query->with('getRating')->with('getLdp')->with('getOrderDetail')->with('owner');
        }]);
        $listCourse = $users->course;
        return view('nqadmin-users::frontend.tong_quan_khoa_hoc_hoi_dap', [
            'questions' => $question,
            'notreply' => $notreply,
            'unread' => $unread,
            'topcmt' => $topcmt,
            'courselist' => $listCourse
        ]);
    }

    public function tongquankhoahocdanhgia(Request $request, RatingRepository $ratingRepository)
    {
        $userId = Auth::id();
        $thump = Auth::user()->thumbnail;
        $cond = array(
            array('author', $userId)
        );
        if ($request->rate) {
            $cond[] = array('rating_number', $request->rate);
        }
        if ($request->not_reply) {
            $cond[] = array('answer', null);
        }
        $orderBy = 'desc';
        if ($request->rating && $request->rating == 1) {
            $orderBy = 'asc';
        }
        $ratings = $ratingRepository->scopeQuery(function ($query) use ($userId, $cond, $orderBy) {
            return $query->with('getcourse')->with('owner')->where($cond)->orderBy('id', $orderBy);
        })->paginate(5);
        return view('nqadmin-users::frontend.tong_quan_khoa_hoc_danh_gia', ['ratings' => $ratings, 'thump' => $thump]);
    }

    public function quanlykhoahocthongke($id, CourseRepository $courseRepository)
    {
        $course = $courseRepository->with('getRating')->with('getLdp')->with('getOrderDetail')->with('owner')->find($id);
        return view('nqadmin-users::frontend.quan_ly_khoa_hoc_thong_ke', ['id' => $id, 'course' => $course]);
    }

    public function quanlykhoahochocsinh($id, Request $request, CourseRepository $courseRepository)
    {
        $course = $courseRepository->with('getRating')->with('getLdp')->with('getOrderDetail')->with('owner')->find($id);
        $student = Users::whereHas('bought', function ($query) use ($id) {
            $query->where('course_id', $id)->groupBy('customer');
        });
        if ($request->fn) {
            $student = $student->where('first_name', 'like', '%' . $request->fn . '%');
        }
        $student = $student->paginate(10);
        return view('nqadmin-users::frontend.quan_ly_khoa_hoc_hoc_sinh', ['id' => $id, 'course' => $course, 'student' => $student]);
    }

    public function quanlykhoahocthongbao($id, CourseRepository $courseRepository)
    {
        $course = $courseRepository->with('getRating')
            ->with('getLdp')
            ->with('getOrderDetail')
            ->with('owner')
            ->with('getAdvertise')
            ->find($id);
        return view('nqadmin-users::frontend.quan_ly_khoa_hoc_thong_bao', ['id' => $id, 'course' => $course]);
    }

    public function searchCourse(Request $request)
    {
        if ($request->ajax()) {
            $q = $request->q['term'];
            $courses = Course::where('status', 'active')->where('slug', 'LIKE', '%' . stripUnicode($q) . '%')->get();
            $res = array();
            foreach ($courses as $course) {
                $tmp = array('id' => $course->id, 'name' => $course->name);
                $res[] = $tmp;
            }
            return \GuzzleHttp\json_encode($res);
        }
    }

    public function searchAllCourse(Request $request)
    {
        if ($request->ajax()) {
            $courses = Course::where('status', 'active')->get();
            $res = array();
            foreach ($courses as $course) {
                $tmp = array('id' => $course->id, 'name' => $course->name);
                $res[] = $tmp;
            }
            return \GuzzleHttp\json_encode($res);
        }
    }

    public function quanlykhoahoctaothongbao($id, CourseRepository $courseRepository)
    {
        $course = $courseRepository->with('getRating')->with('getLdp')->with('getOrderDetail')->with('owner')->find($id);
        return view('nqadmin-users::frontend.quan_ly_khoa_hoc_tao_thong_bao', ['id' => $id, 'course' => $course]);
    }

    public function postquanlykhoahoctaothongbao($id, Request $request)
    {
        if (!empty($request->courses)) {
            foreach (explode(',', $request->courses) as $course_id) {
                if (!empty($course_id)) {
                    $course = Course::find($course_id);
                    if (!empty($course)) {
                        $advertise = Advertise::create([
                            'author_id' => \Auth::id(),
                            'course_id' => $course->id,
                            'title' => $request->title,
                            'content' => $request->get('content'),
                            'type' => 'normal',
                        ]);
                        $students = $course->getStudents();
                        if (!empty($request->from)) {
                            $students = $students->where('created_at', '>', date("Y-m-d 00:00:00", strtotime($request->from)));
                        }
                        if (!empty($request->to)) {
                            $students = $students->where('created_at', '<', date("Y-m-d 00:00:00", strtotime($request->to)));
                        }
                        foreach ($students as $student) {
                            $check = AdvertiseUser::where('advertise_id', $advertise->id)
                                ->where('user_id', $student->first()->customer)
                                ->first();
                            if (empty($check))
                                AdvertiseUser::create([
                                    'advertise_id' => $advertise->id,
                                    'user_id' => $student->first()->customer
                                ]);
                        }
                    }
                }
            }
            return redirect()->back()->with('success', 'Đã gửi thông báo');
        }
        return redirect()->back()->with('error', 'Có lỗi sảy ra');
    }

    public function postquanlykhoahoctaothongbaodefault($id, Request $request)
    {
        if (!empty($request->welcome)) {
            $check = Advertise::where('type', 'welcome')
                ->where('course_id', $id)
                ->first();
            if (empty($check)) {
                Advertise::create([
                    'author_id' => \Auth::id(),
                    'course_id' => $id,
                    'title' => 'Thư chào mừng',
                    'content' => $request->welcome,
                    'type' => 'welcome',
                ]);
            } else {
                $check->content = $request->welcome;
                $check->save();
            }
        }
        if (!empty($request->congratulation)) {
            $check = Advertise::where('type', 'congratulation')
                ->where('course_id', $id)
                ->first();
            if (empty($check)) {
                Advertise::create([
                    'author_id' => \Auth::id(),
                    'course_id' => $id,
                    'title' => 'Thư chúc mừng',
                    'content' => $request->congratulation,
                    'type' => 'congratulation',
                ]);
            } else {
                $check->content = $request->welcome;
                $check->save();
            }

        }
        return redirect()->back()->with('success', 'Đã lưu thông báo mặc định');
    }

    public function quanlykhoahocgia(Request $request, $id, CourseRepository $courseRepository, CouponRepository $couponRepository)
    {
        $userId = Auth::id();
        $cond = array(
            array('author', $userId)
        );
        if ($request->q) {
            $cond[] = array('code', 'LIKE', '%' . $request->q . '%');
        }
        $orderBy = 'desc';
        $course = $courseRepository->with('getLdp')->with('owner')->find($id);
        $coupons = $couponRepository->scopeQuery(function ($query) use ($userId, $cond, $orderBy) {
            return $query->with('course')->where($cond)->orderBy('id', $orderBy);
        })->paginate(5);

        return view('nqadmin-users::frontend.quan_ly_khoa_hoc_gia', ['id' => $id, 'course' => $course, 'coupons' => $coupons]);
    }

    public function quanlykhoahocsetting($id)
    {
        return view('nqadmin-users::frontend.quan_ly_khoa_hoc_setting', ['id' => $id]);
    }

    public function postReplyReview(Request $request, RatingRepository $ratingRepository)
    {
        $answer = array(
            'content' => $request->get('content'),
            'time' => date('Y-m-d H:i:s')
        );
        $res = $ratingRepository->update([
            'answer' => json_encode($answer)
        ], $request->id);
        return redirect()->back()->with("success", "Thêm câu trả lời thành công!");
    }

    public function deleteAnswer(Request $request, RatingRepository $ratingRepository)
    {
        $res = $ratingRepository->update([
            'answer' => null
        ], $request->id);
        return redirect()->back()->with("success", "Xóa câu trả lời thành công!");
    }

    public function deleteAnswerq(Request $request, ReplyRepository $replyRepository)
    {
        $res = $replyRepository->delete($request->id);
        return redirect()->back()->with("success", "Xóa câu trả lời thành công!");
    }

    public function deleteQuestion(Request $request, QuestionRepository $questionRepository)
    {
        $res = $questionRepository->delete($request->id);
        return redirect()->back()->with("success", "Xóa câu hỏi thành công!");
    }

    public function changeRead(Request $request, QuestionRepository $questionRepository)
    {
        $question = $questionRepository->find($request->id);
        $res = $questionRepository->update(['readed' => $question->readed == 1 ? 0 : 1], $request->id);
        return redirect()->back();
    }

    public function changeUsefull(Request $request, ReplyRepository $replyRepository)
    {
        try {
            $answer = $replyRepository->find($request->id);
            $res = $replyRepository->update(['usefull' => $answer->usefull == 1 ? 0 : 1], $request->id);
        } catch (\Exception $e) {
            echo $e->getMessage();
        }

        return redirect()->back();
    }

    public function postReplyQuestion(Request $request, QuestionRepository $questionRepository, ReplyRepository $replyRepository)
    {
        $res = $replyRepository->create([
            'question' => $request->id,
            'author' => Auth::id(),
            'content' => $request->contentt
        ]);
        $question = $questionRepository->find($request->id);
        $course = $question->getCourse;
        $advertise = Advertise::create([
            'author_id' => \Auth::id(),
            'course_id' => $course->id,
            'title' => 'Có câu trả lời cho thắc mắc của bạn',
            'content' => $request->contentt,
            'answer_id' => $request->id,
            'type' => 'normal',
        ]);
        AdvertiseUser::create([
            'advertise_id' => $advertise->id,
            'user_id' => $question->owner->id,
        ]);
        return redirect()->back()->with("success", "Thêm câu trả lời thành công!");
    }

    public function getProfile($code, UsersRepository $usersRepository)
    {
        $meta = UsersMeta::where('meta_value', $code)->where('meta_key', 'code_user')->first();
        if ($meta) {
            $user = $usersRepository->with(['course' => function ($q) {
                return $q->where('status', 'active');
            }])->findByField('id', $meta->users_id)->first()->load('data');
            if ($user->position == 'Giáo viên') {
                return view('nqadmin-users::frontend.profile_giao_vien', [
                    'user' => $user
                ]);
            } else {
                return view('nqadmin-users::frontend.profile_hoc_sinh', [
                    'user' => $user
                ]);
            }
        } else {
            return redirect(route('home'));
        }
    }

    public function getCertificate(
        CertificateRepository $certificateRepository
    )
    {
        $user = auth('nqadmin')->id();

        $certificates = $certificateRepository->with('course')->scopeQuery(function ($q) use ($user) {
            return $q->where('user_id', $user);
        })->paginate(15);

        return view('nqadmin-course::frontend.certificate_list', compact('certificates'));
    }

    public function getStat(
        Request $request,
        ClassLevelRepository $classLevelRepository,
        CourseRepository $courseRepository,
        CertificateRepository $certificateRepository,
        UsersRepository $usersRepository
    )
    {
        $user = auth('nqadmin')->user();
        if (intval($user->hard_role) < 1) {
            return redirect()->back()->withErrors('Bạn không có quyền xem nội dung này');
        }

        $courseInCompany = [];
        $selectedCompany = false;
        $company = $classLevelRepository->findWhere([
            'status' => 'active'
        ]);

        $certificates = $certificateRepository->count();

        $courses = $courseRepository->findWhere([
            'status' => 'active'
        ])->count();

        $employers = $usersRepository->findWhere([
            'status' => 'active',
            'hard_role' => 1
        ])->count();

        if ($request->get('company') != null) {
            $currentCompany = $request->get('company');
            $selectedCompany = $classLevelRepository->with(['getUsers' => function($q) {
                $q->where('hard_role', 1);
            }])->find($currentCompany);

            $userInCompany = $usersRepository->scopeQuery(function ($q) use ($currentCompany) {
                return $q->where('classlevel', $currentCompany)->where('hard_role', 1)->pluck('id');
            })->get();

            $courseInCompany = $courseRepository
                ->with('getLdp')
                ->whereHas('getLdp', function ($r) use ($currentCompany) {
                    $r->where('course_ldp.classlevel', $currentCompany)->orWhere('course_ldp.classlevel', null);
                })
                ->with(['certificate' => function($r) use ($userInCompany) {
                    return $r->whereIn('certificate.user_id', $userInCompany)->get();
                }])
                ->with(['getOrderDetail' => function($c) use ($userInCompany) {
                    return $c->whereIn('order_details.customer', $userInCompany)->get();
                }])
                ->scopeQuery(function ($q) use ($currentCompany) {
                    return $q->where('status', 'active');
                })->get();
        } elseif (intval($user->hard_role) == 2) {
            $currentCompany = $user->classlevel;

            $selectedCompany = $classLevelRepository->with(['getUsers' => function($q) use ($user) {
                $q->where('id', '!=', $user->id)->where('hard_role', 1);
            }])->find($currentCompany);

            $userInCompany = $usersRepository->scopeQuery(function ($q) use ($currentCompany, $user) {
                return $q->where('id', '!=', $user->id)->where('hard_role', 1)->where('classlevel', $currentCompany)->pluck('id');
            })->get();

            $courseInCompany = $courseRepository
                ->with('getLdp')
                ->whereHas('getLdp', function ($r) use ($currentCompany) {
                    $r->where('course_ldp.classlevel', $currentCompany)->orWhere('course_ldp.classlevel', null);
                })
                ->with(['certificate' => function($r) use ($userInCompany) {
                    return $r->whereIn('certificate.user_id', $userInCompany)->get();
                }])
                ->with(['getOrderDetail' => function($c) use ($userInCompany) {
                    return $c->whereIn('order_details.customer', $userInCompany)->distinct('customer')->get();
                }])

                ->scopeQuery(function ($q) use ($currentCompany) {
                    return $q->where('status', 'active');
                })->get();
        }

        if (intval($user->hard_role) > 2) {
            $allCompany = $classLevelRepository->with('getUsers')
                ->with('getCertificate')
                ->paginate(20);
        } else {
            $allCompany = [];
        }

        return view('nqadmin-users::frontend.stat', compact(
            'company',
            'courseInCompany',
            'selectedCompany',
            'certificates',
            'courses',
            'employers',
            'allCompany'
        ));
    }

    public function getEmployers(
        UsersRepository $usersRepository
    )
    {
        $master = auth('nqadmin')->user();
        $company = $master->classlevel;
        $employers = $usersRepository->scopeQuery(function ($q) use ($company) {
            return $q->where('classlevel', $company)->where('status', 'active')->where('hard_role', '1');
        })->orderBy('first_name', 'asc')->paginate(20);

        return view('nqadmin-users::frontend.employers', compact(
            'employers'
        ));
    }

    public function postEmployers(
        Request $request
    )
    {
        try {

            $user = auth('nqadmin')->user();

            Excel::import(
                new UsersImport($user->classlevel),
                $request->file('excel_file')
            );

            return redirect()->back()->with([
                'success' => 'Nhập dữ liệu thành công'
            ]);
        } catch (\Exception $e) {
            return redirect()->back()->withErrors('Có lỗi xảy ra khi import dữ liệu');
        }
    }
}