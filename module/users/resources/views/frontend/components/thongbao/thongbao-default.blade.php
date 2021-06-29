<form name="" method="POST" class="box-form-default" action="{{ route('front.users.quan_ly_khoa_hoc_tao_thong_bao_default.post',['id'=>$id]) }}">
    {{ csrf_field() }}
    <div class="form-group">
        <label class="txt-label text-666">Thư chào mừng</label>
        <div class="form-textarea">
            <input readonly type="text" id='textlength' size="3" maxlength="3" value="1000" class="number-length num1">
            <textarea onKeyDown="textCounter(this,'.num1' ,1000);" onKeyUp="textCounter(this,'.num1' ,1000)" class="txt-form" name="welcome" id="text" rows="5" cols="">
                {{ isset($course->getAdvertise->where('type','welcome')->first()->content)?trim($course->getAdvertise->where('type','welcome')->first()->content):'' }}
            </textarea>
        </div>

        <p class="txt-change">Chỉnh sửa lần cuối vào 06/06/2017</p>
    </div>
    <div class="form-group">
        <label class="txt-label text-666">Thông báo Chúc mừng</label>
        <div class="form-textarea">
            <input readonly type="text" id='textnewlength' size="3" maxlength="3" value="1000" class="number-length num2">
            <textarea onKeyDown="textCounter(this,'.num2' ,1000);" onKeyUp="textCounter(this,'.num2' ,1000)" class="txt-form" name="congratulation" id="textnew" rows="5" cols="">
                {{ isset($course->getAdvertise->where('type','congratulation')->first()->content)?trim($course->getAdvertise->where('type','congratulation')->first()->content):'' }}
            </textarea>
        </div>
    </div>
    <div class="clearfix box-btn box-btn-save">
        <button type="submit" class="btn btn-small btn-default-yellow pull-right">Lưu</button>
    </div>
</form>