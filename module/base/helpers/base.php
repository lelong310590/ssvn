<?php
/**
 * Created by PhpStorm.
 * User: Admin
 * Date: 11/1/2017
 * Time: 8:53 AM
 */

use Base\Supports\FlashMessage;

if (!function_exists('is_in_dashboard')) {
    /**
     * @return bool
     */
    function is_in_dashboard()
    {
        $segment = request()->segment(1);
        if ($segment === config('SOURCE_ADMIN_ROUTE', 'admincp')) {
            return true;
        }

        return false;
    }
}

if (!function_exists('convert_status')) {
    function conver_status($status)
    {
        switch ($status) {
            case 'active' :
                return '<span class="status success">Kích hoạt</span>';
                break;
            case 'disable' :
                return '<span class="status danger">Tạm khóa</span>';
                break;
            default:
                return '<span class="status danger">Tạm khóa</span>';
                break;
        }
    }
}

if (!function_exists('convert_flash_message')) {
    function convert_flash_message($mess = 'create')
    {
        switch ($mess) {
            case 'create':
                $m = config('messages.success_create');
                break;
            case 'edit':
                $m = config('messages.success_edit');
                break;
            case 'delete':
                $m = config('messages.success_delete');
                break;
            case 'success_create_class_level_error_user':
                $m = config('messages.success_create_class_level_error_user');
                break;
            default:
                $m = config('messages.success_create');
        }

        return $m;
    }
}

if (!function_exists('random_string')) {
    function random_string($length = 10) {
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $charactersLength = strlen($characters);
        $randomString = '';
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[rand(0, $charactersLength - 1)];
        }
        return $randomString;
    }
}

if (!function_exists('changeStatus')) {
    function changeStatus($id, $repository)
    {
        try {
            $record = $repository->find($id);
            $status = ($record->status == 'active') ? 'disable' : 'active';
            $repository->update([
                'status' => $status
            ], $id);

            return redirect()->back()->with(FlashMessage::returnMessage('edit'));
        } catch (\Exception $e) {
            Debugbar::addThrowable($e);
            return redirect()->back()->withErrors(config('messages.error'));
        }
    }
}

if (!function_exists('setFeatured')) {
    function setFeatured($id, $repository)
    {
        try {
            $record = $repository->find($id);
            $status = ($record->featured == 'active') ? 'disable' : 'active';
            $repository->update([
                'featured' => $status
            ], $id);

            return redirect()->back()->with(FlashMessage::returnMessage('edit'));
        } catch (\Exception $e) {
            Debugbar::addThrowable($e);
            return redirect()->back()->withErrors(config('messages.error'));
        }
    }
}

if (!function_exists('getDelete')) {
    function getDelete($id, $repository)
    {
        try {
            $repository->delete($id);
            return redirect()->back()->with(FlashMessage::returnMessage('delete'));
        } catch (\Exception $e) {
            Debugbar::addThrowable($e);
            return redirect()->back()->withErrors(config('messages.error'));
        }
    }
}

function time_elapsed_string($datetime, $full = false)
{
    $now = new DateTime;
    $ago = new DateTime($datetime);
    $diff = $now->diff($ago);

    $diff->w = floor($diff->d / 7);
    $diff->d -= $diff->w * 7;

    $string = array(
        'y' => 'năm',
        'm' => 'tháng',
        'w' => 'tuần',
        'd' => 'ngày',
        'h' => 'tiếng',
        'i' => 'phút',
        's' => 'giây',
    );
    foreach ($string as $k => &$v) {
        if ($diff->$k) {
            $v = $diff->$k . ' ' . $v . ($diff->$k > 1 ? '' : '');
        } else {
            unset($string[$k]);
        }
    }

    if (!$full) $string = array_slice($string, 0, 1);
    return $string ? implode(', ', $string) . ' trước' : 'vừa xong';
}

function secToHR($seconds, $short = false)
{
    $hours = floor($seconds / 3600);
    $minutes = floor(($seconds / 60) % 60);
    $seconds = $seconds % 60;
    if (!$short)
        return "$hours giờ, $minutes phút, $seconds giây";
    else {
        $hours = $hours < 10 ? '0' . $hours : $hours;
        $minutes = $minutes < 10 ? '0' . $minutes : $minutes;
        $seconds = $seconds < 10 ? '0' . $seconds : $seconds;
        return "$hours:$minutes:$seconds";
    }
}

function humanTiming($time)
{

    $time = time() > $time ? time() - $time : $time - time(); // to get the time since that moment

    $tokens = array(
        31536000 => 'năm',
        2592000 => 'tháng',
        604800 => 'tuần',
        86400 => 'ngày',
        3600 => 'giờ',
        60 => 'phút',
    );

    $result = '';
    $counter = 1;
    foreach ($tokens as $unit => $text) {
        if ($time < $unit) continue;
        if ($counter > 2) break;

        $numberOfUnits = floor($time / $unit);
        $result .= "$numberOfUnits $text ";
        $time -= $numberOfUnits * $unit;
        ++$counter;
    }

    return "{$result}";
}

function stripUnicode($str)
{
    if (!$str) return false;
    $unicode = array(
        'a' => 'á|à|ả|ã|ạ|ă|ắ|ằ|ẳ|ẵ|ặ|â|ấ|ầ|ẩ|ẫ|ậ|&#227;|&#224;|&#225;|&#226;|&#226;́|&#226;̀|&#226;̣|&#226;̉|&#226;̃|á|à|ả|ạ|ắ|ằ|ẳ|ặ|ấ|ầ|ẩ|ẫ|ậ',
        'A' => 'Á|À|Ả|Ã|Ạ|Ă|Ắ|Ằ|Ẳ|Ẵ|Ặ|Â|Ấ|Ầ|Ẩ|Ẫ|Ậ|&#193;|&#192;|&#195;|&#194;|&#194;́|&#194;̀|&#194;̣|&#194;̉|&#194;̃|Á|À|Ả|Ạ|Ắ|Ằ|Ẳ|Ặ|Ấ|Ầ|Ẩ|Ẫ|Ậ',
        'd' => 'đ',
        'D' => 'Đ',
        'e' => 'é|è|ẻ|ẽ|ẹ|ê|ế|ề|ể|ễ|ệ|&#233;|&#232;|&#234;|&#234;́|&#234;̀|&#234;̣|&#234;̉|&#234;̃|é|è|ẻ|ẽ|ẹ|ế|ề|ể|ễ|ệ',
        'E' => 'É|È|Ẻ|Ẽ|Ẹ|Ê|Ế|Ề|Ể|Ễ|Ệ|&#201;|&#200;|&#202;|&#202;́|&#202;̀|&#202;̣|&#202;̉|&#202;̃|É|È|Ẻ|Ẽ|Ẹ|Ế|Ề|Ể|Ễ|Ệ',
        'i' => 'í|ì|ỉ|ĩ|ị|&#237;|&#236;|í|ì|ỉ|ị|ĩ',
        'I' => 'Í|Ì|Ỉ|Ĩ|Ị|&#205;|&#204;|Í|Ì|Ỉ|Ĩ|Ị',
        'o' => 'ó|ò|ỏ|õ|ọ|ô|ố|ồ|ổ|ỗ|ộ|ơ|ớ|ờ|ở|ỡ|ợ|&#243;|&#242;|&#245;|&#244;|&#244;̀|&#244;́|&#244;̣|&#244;̉|&#244;̃|ó|ò|ỏ|õ|ọ|ố|ồ|ổ|ỗ|ộ|ớ|ờ|ở|ợ|ỡ',
        'O' => 'Ó|Ò|Ỏ|Õ|Ọ|Ô|Ố|Ồ|Ổ|Ỗ|Ộ|Ơ|Ớ|Ờ|Ở|Ỡ|Ợ|&#211;|&#210;|&#213;|&#212;|&#212;̀|&#212;́|&#212;̣|&#212;̉|&#212;̃|Ó|Ò|Ỏ|Õ|Ọ|Ố|Ồ|Ổ|Ỗ|Ộ|Ớ|Ờ|Ở|Ỡ|Ợ',
        'u' => 'ú|ù|ủ|ũ|ụ|ư|ứ|ừ|ử|ữ|ự|&#250;|&#249;|ú|ù|ủ|ũ|ụ|ứ|ừ|ử|ữ|ự',
        'U' => 'Ú|Ù|Ủ|Ũ|Ụ|Ư|Ứ|Ừ|Ử|Ữ|Ự|&#218;|&#217;|Ú|Ù|Ử|Ũ|Ụ|Ứ|Ừ|Ử|Ữ|Ự',
        'y' => 'ý|ỳ|ỷ|ỹ|ỵ|&#253;|ý|ỳ|ỷ|ỹ|ỵ',
        'Y' => 'Ý|Ỳ|Ỷ|Ỹ|Ỵ|&#221;|Ý|Ỳ|Ỷ|Ỹ|Ỵ',
    );
    foreach ($unicode as $khongdau => $codau) {
        $arr = explode("|", $codau);
        $str = str_replace($arr, $khongdau, $str);
    }
    $str = str_replace("–", "-", $str);
    $str = str_replace(",", "-", $str);
    $str = str_replace("?", "-", $str);
    $str = str_replace('"', '-', $str);
    $str = str_replace("“", "-", $str);
    $str = str_replace("”", "-", $str);
    $str = str_replace(" ", "-", $str);
    $str = str_replace(":", "-", $str);
    $str = str_replace("’", "-", $str);
    $str = str_replace("'", "-", $str);
    $str = str_replace(".", "-", $str);
    $str = str_replace("!", "-", $str);
    $str = str_replace("(", "-", $str);
    $str = str_replace(")", "-", $str);
    $str = str_replace("[", "-", $str);
    $str = str_replace("]", "-", $str);
    $str = str_replace("%", "-", $str);
    $str = str_replace("/", "-", $str);
    $str = str_replace("*", "-", $str);
    $str = preg_replace("/-{2,5}/", "-", $str);
    return htmlspecialchars($str);
}