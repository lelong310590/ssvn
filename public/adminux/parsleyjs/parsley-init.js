/**
 * Created by Admins on 4/13/2017.
 */
$(document).ready(function() {
	$("form").parsley();
    // ParsleyConfig definition if not already set
	window.ParsleyConfig = window.ParsleyConfig || {};
	window.ParsleyConfig.i18n = window.ParsleyConfig.i18n || {};

    // Define then the messages
	window.ParsleyConfig.i18n.en = jQuery.extend(window.ParsleyConfig.i18n.en || {}, {
		defaultMessage: "This value seems to be invalid.",
		type: {
			email:        "Định dạng Email không đúng.",
			url:          "Định dạng Url không đúng.",
			number:       "Định dạng số không đúng.",
			integer:      "Chỉ được sử dụng số nguyên.",
			digits:       "Chỉ được sử dụng các số từ 0-9.",
			alphanum:     "Chỉ được sử dụng chữ từ a-z và số từ 0-9."
		},
		notblank:       "Trường này không được bỏ trống.",
		required:       "Trường này không được bỏ trống.",
		pattern:        "Định dạng dữ liệu không đúng.",
		min:            "Giá trị nhập vào phải lớn hơn hoặc bằng %s.",
		max:            "Giá trị nhập vào phải nhỏ hơn hoặc bằng %s.",
		range:          "Giá trị nhập vào phải nằm trong khoảng %s và %s.",
		minlength:      "Độ dài chưa đủ. Tối thiểu là %s ký tự.",
		maxlength:      "Độ dài quá lớn. Tối đa là %s số.",
		length:         "Độ dài không chính xác. độ dài nằm trong khoảng %s và %s.",
		mincheck:       "Bạn chỉ chọn ít nhất %s mục.",
		maxcheck:       "Bạn chỉ được chọn tối đa là %s mục.",
		check:          "Bạn phải chọn ít nhất là %s mục và nhiều nhất là %s mục.",
		equalto:        "Hai giá trị phải giống nhau."
	});
})
