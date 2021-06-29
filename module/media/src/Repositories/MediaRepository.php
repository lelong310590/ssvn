<?php
/**
 * Created by PhpStorm.
 * User: Admin
 * Date: 4/28/2018
 * Time: 10:00 AM
 */

namespace Media\Repositories;

use Media\Models\Media;
use Prettus\Repository\Eloquent\BaseRepository;
use Users\Models\Users;
use File;
use FFMpeg\FFMpeg;
use FFMpeg\FFProbe;
use FFMpeg\Coordinate\TimeCode;
use Image;

class MediaRepository extends BaseRepository
{
    public function model()
    {
        $this->path = public_path() . '/';
        $this->ffmpegConfig = [
            'ffmpeg.binaries' => env('FFMPEG_BINARIES', '/usr/local/bin/ffmpeg'),
            'ffprobe.binaries' => env('FFPROBE_BINARIES', '/usr/local/bin/ffprobe'),
            'timeout' => 3600, // The timeout for the underlying process
            'ffmpeg.threads' => 12,   // The number of threads that FFMpeg should use
        ];

        return Media::class;
    }

    protected $path = '';
    protected $ffmpegConfig = [];

    /**
     * @param $userid
     * @param $file
     * @param $curriculum
     * @param $type
     *
     * @return array|mixed
     */
    public function upload($userid, $file, $curriculum = null, $type)
    {
        $user = Users::where('id', $userid)->first();
        if (empty($user)) {
            return [];
        }

        $email = $user->email;

        $location = $this->path . 'upload/' . $email . '/' . $type;
        $thumbnailLocation = $this->path . '/upload/' . $email . '/thumbnails';

        if (!File::exists($location)) {
            File::makeDirectory($location, 0775, true, true);
        }

        $data = $file;
        if (strlen($data) < 0) {
            return [];
        }

//		$fileName = $file->getClientOriginalName();
//		$extension = File::extension($fileName);

        $name = $file->getClientOriginalName();
        $fileName = str_slug(pathinfo($name)['filename'], '-');
        $extension = File::extension($name);
        $fullName = $fileName . '.' . $extension;

        if (File::exists($location . '/' . $fullName)) {
            $fullName = $fileName . '-1' . '.' . $extension;
        }

        $fileMime = $file->getMimeType();
        $url = '/upload/' . $email . '/' . $type . '/' . $fullName;

        if ($type == 'video') {
            $thumbnailUrl = '/upload/' . $email . '/thumbnails';
            $thumbnailName = explode('.', $fullName);
        }

        try {
            $data->move($location, $fullName);
            $resolution = 720;

            $thumbnail = '';
            $duration = 0;

            if ($type == 'video') {
                if (!File::exists($thumbnailLocation)) {
                    File::makeDirectory($thumbnailLocation, 0775, true, true);
                }
                $thumbnail = $this->createThumbnailFromVideo($url, 10, $thumbnailName[0], $thumbnailUrl); // create thumbnail from iframe
                $resolution = Image::make($this->path . $thumbnail)->width();
            }

            $status = 'processing';

            $reject_reason = '';

            //muon check chat luong 720p thi if $resolution < 720

            if ($type != 'video') {
                $status = 'disable';
                $reject_reason = 'Chất lượng Video tải lên không đạt yêu cầu 720p';
            } else {
                $status = 'active';
            }

            if ($type == 'video') {
                $this->resizeThumbnailVideo($this->path . $thumbnail); //resize thumbnail
                $duration = $this->getDuration($url);
            }

            if ($type != 'quiz') {
                $media = $this->create([
                    'name' => $file->getClientOriginalName(),
                    'thumbnail' => $thumbnail,
                    'duration' => $duration,
                    'url' => $url,
                    'type' => $fileMime,
                    'owner' => $user->id,
                    'curriculum_item' => $curriculum,
                    'status' => $status,
                    'reject_reason' => $reject_reason,
                ]);
            }

            return $media;
        } catch (\Exception $e) {
            return [$e->getMessage()];
        }
    }

    /**
     * @param     $source
     * @param int $second
     * @param     $name
     * @param     $exportSrc
     *
     * @return string
     */
    protected function createThumbnailFromVideo($source, $second = 10, $name, $exportSrc)
    {
        $ffmpeg = FFMpeg::create($this->ffmpegConfig);
        $video = $ffmpeg->open($this->path . $source);
        $video->frame(TimeCode::fromSeconds($second))
            ->save($this->path . $exportSrc . '/' . $name . '.jpg');

        return $exportSrc . '/' . $name . '.jpg';
    }

    /**
     * @param $image
     */
    protected function resizeThumbnailVideo($image)
    {
        $img = Image::make($image);
        $img->resize(750, 442);
        $img->save();
    }

    /**
     * @param $source
     *
     * @return mixed
     */
    protected function getDuration($source)
    {
        $ffprobe = FFProbe::create($this->ffmpegConfig);
        $video_duration = $ffprobe
            ->format($this->path . $source)// extracts streams informations
            ->get('duration');
        return $video_duration;
    }

    /**
     * @param $curriculumId
     */
    public function removeOldContent($curriculumId)
    {
        $media = $this->findWhere(['curriculum_item' => $curriculumId]);
        foreach ($media as $m) {
            $this->update([
                'curriculum_item' => NULL,
            ], $m->id);
        }
    }

    /**
     * Upload image tao khoa hoc
     * @param $userid
     * @param $file
     * @return array|string
     */
    public function uploadImage($userid, $file)
    {
        $user = Users::where('id', $userid)->first();
        if (empty($user)) {
            return [];
        }

        $email = $user->email;

        $location = $this->path . 'upload/' . $email . '/course/';

        if (!File::exists($location)) {
            File::makeDirectory($location, 0775, true, true);
        }

        $data = $file;
        if (strlen($data) < 0) {
            return [];
        }
        $temp = explode('.', $file->getClientOriginalName());
        unset($temp[count($temp) - 1]);
        $fileName = stripUnicode(implode('.', $temp)) . '.' . $file->getClientOriginalExtension();
        $url = '/upload/' . $email . '/course/' . $fileName;
        try {
            $data->move($location, $fileName);
            $this->resizeThumbnailVideo($location . $fileName);
            return $url;
        } catch (\Exception $e) {
            return [$e->getMessage()];
        }
    }

    /**
     * upload video tao khoa hoc
     * @param $userid
     * @param $file
     * @return array|string
     */
    public function uploadVideo($userid, $file)
    {
        $user = Users::where('id', $userid)->first();
        if (empty($user)) {
            return [];
        }

        $email = $user->email;

        $location = $this->path . 'upload/' . $email . '/course';

        if (!File::exists($location)) {
            File::makeDirectory($location, 0775, true, true);
        }

        $data = $file;
        if (strlen($data) < 0) {
            return [];
        }
        $temp = explode('.', $file->getClientOriginalName());
        unset($temp[count($temp) - 1]);
        $fileName = stripUnicode(implode('.', $temp)) . '.' . $file->getClientOriginalExtension();
        $fileMime = $file->getMimeType();
        $url = '/upload/' . $email . '/course/' . $fileName;
        try {
            $data->move($location, $fileName);

            return $url;
        } catch (\Exception $e) {
            return [$e->getMessage()];
        }
    }

    /**
     * @param $owner
     *
     * @return mixed
     */
    public function getListVideo($owner)
    {
        $media = $this->findWhere([
            'owner' => $owner,
            'curriculum_item' => null,
            ['type', 'LIKE', '%video%']
        ])->all();
        foreach ($media as $m) {
            $m['show_reason'] = false;
        }
        return $media;
    }

    /**
     * @param $id
     *
     * @return string
     */
    public function deleteMedia($id)
    {
        try {
            $media = $this->find($id);
            $url = $media->url;
            $mediaPath = $this->path . $url;
            File::delete($mediaPath); // delete file first
            $this->delete($id);
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }

    /**
     * @param $id
     *
     * @return string
     */
    public function deleteResource($id)
    {
        try {
            $this->delete($id);
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }

    /**
     * @param $id
     */
    public function setNullResource($id)
    {
        try {
            $this->update([
                'curriculum_item' => null
            ], $id);
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }

    /**
     * @param $owner
     *
     * @return mixed
     */
    public function getListResource($owner)
    {
        $media = $this->findWhere([
            'owner' => $owner,
            'curriculum_item' => null,
            ['type', '!=', 'video/mp4']
        ])->all();
        foreach ($media as $m) {
            $m['show_reason'] = false;
        }
        return $media;
    }
}