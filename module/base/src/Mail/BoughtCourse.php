<?php

namespace Base\Mail;

use Course\Models\Course;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;
use Users\Models\Users;

class BoughtCourse extends Mailable
{
    use Queueable, SerializesModels;

    public $user;
    public $course;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(Users $user, Course $course)
    {
        $this->user = $user;
        $this->course = $course;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject('Khóa đào tạo' . $this->course->name . ' đã có thêm lượt mua!')->view('nqadmin-dashboard::mail.content.course.bought');
    }
}
