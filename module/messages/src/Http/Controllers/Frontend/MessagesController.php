<?php
/**
 * Created by PhpStorm.
 * User: Admin
 * Date: 4/5/2018
 * Time: 12:15 AM
 */

namespace Messages\Http\Controllers\Frontend;

use Barryvdh\Debugbar\Controllers\BaseController;
use Messages\Http\Requests\SendMessageRequest;
use Messages\Models\MessageDetail;
use Messages\Models\MessageLists;
use Messages\Models\Messages;
use Users\Models\UsersMeta;
use Users\Repositories\UsersRepository;
use Illuminate\Http\Request;
use Users\Models\Users;

class MessagesController extends BaseController
{
    public function index($message_id = null)
    {
        $user = \Auth::user()->load(['messages' => function ($query) use ($message_id) {
            $query->with(['getMessage' => function ($query) {
                $query->with('getDetail')->with('getSender')->with('getReceiver');
            }])->orderBy('updated_at', 'desc');
        }]);

        return view('nqadmin-messages::frontend.index', compact('user'));

    }

    public function create($user_id = null, UsersRepository $usersRepository)
    {
        $user = \Auth::user()->load(['messages' => function ($query) {
            $query->with(['getMessage' => function ($query) {
                $query->with('getDetail')->with('getSender')->with('getReceiver');
            }]);
        }]);
        $chat_user = null;
        $meta = UsersMeta::where('meta_value', $user_id)->where('meta_key', 'code_user')->first();
        if ($meta && $meta->users_id != $user->id) {
            $chat_user = $usersRepository->findByField('id', $meta->users_id)->first();
            if (!empty($chat_user)) {
                $id_1 = \Auth::id();
                $id_2 = $chat_user->id;
                $check = \DB::table('messages')
                    ->where(function ($query) use ($id_1, $id_2) {
                        $query->where('sender', $id_1);
                        $query->where('receiver', $id_2);
                    })->orWhere(function ($query) use ($id_1, $id_2) {
                        $query->where('sender', $id_2);
                        $query->where('receiver', $id_1);
                    })->first();
                if (!empty($check)) {
                    return redirect(route('front.message.index.get', ['message_id' => $check->id]));
                }
            }
        }
        return view('nqadmin-messages::frontend.create', compact('user', 'chat_user'));
    }

    public function send(SendMessageRequest $request, UsersRepository $usersRepository)
    {
        $chat_user = $usersRepository->findByField('id', $request->user_id)->first();
        $auth_id = \Auth::id();
        if (!empty($chat_user) && $request->users_id != $auth_id) {
            $id_1 = $auth_id;
            $id_2 = $chat_user->id;
            $check = \DB::table('messages')
                ->where(function ($query) use ($id_1, $id_2) {
                    $query->where('sender', $id_1);
                    $query->where('receiver', $id_2);
                })->orWhere(function ($query) use ($id_1, $id_2) {
                    $query->where('sender', $id_2);
                    $query->where('receiver', $id_1);
                })->first();
            if (empty($check)) {
                $message = Messages::create([
                    'sender' => $auth_id,
                    'receiver' => $chat_user->id,
                ]);
                MessageDetail::create([
                    'sender' => $auth_id,
                    'message_id' => $message->id,
                    'message' => $request->message,
                ]);
                MessageLists::create([
                    'user_id' => $auth_id,
                    'message_id' => $message->id,
                    'seen' => 'active',
                ]);
                MessageLists::create([
                    'user_id' => $chat_user->id,
                    'message_id' => $message->id,
                ]);
            } else {
                $message = Messages::find($check->id);
                $message->updated_at = date('Y-m-d H:i:s');
                $message->save();
                $detail = MessageDetail::create([
                    'sender' => $auth_id,
                    'message_id' => $message->id,
                    'message' => $request->message,
                ]);
                $message->getMessageInList->where('user_id', $auth_id)->first()->updated_at = date('Y-m-d H:i:s');
                $message->getMessageInList->where('user_id', $auth_id)->first()->save();

                $message->getMessageInList->where('user_id', '!=', $auth_id)->first()->seen = 'disable';
                $message->getMessageInList->where('user_id', '!=', $auth_id)->first()->save();
            }

            if ($request->ajax()) {
                $html = view('nqadmin-messages::frontend.components.each-message', ['detail' => $detail])->render();
                return json_encode(['html' => $html]);
            }
            return redirect(route('front.message.index.get', ['message_id' => $message->id]));
        }
        return redirect(route('front.message.create.get'))->with('error', 'Có lỗi sảy ra trong quá trình gửi tin!');
    }

    public function searchUser(Request $request)
    {
        if ($request->ajax()) {
            $q = $request->q['term'];
            $users = Users::where('first_name', 'like', '%' . $q . '%')->where('id', '!=', \Auth::id())->get();
            $res = array();
            if ($users && $users->count() > 0) {
                foreach ($users as $user) {
                    $tmp = array('id' => $user->id, 'name' => $user->first_name);
                    $res[] = $tmp;
                }
            }
            return \GuzzleHttp\json_encode($res);
        }
    }

    public function setStar(Request $request)
    {
        if ($request->ajax()) {
            $message_list = MessageLists::find($request->message);
            if (!empty($message_list)) {
                if ($message_list->type == 'normal') {
                    $message_list->type = 'star';
                    $action = 'add';
                } else {
                    $message_list->type = 'normal';
                    $action = 'remove';
                }
                $message_list->save();
                return \GuzzleHttp\json_encode(['success' => true, 'action' => $action]);
            }
        }
    }
}