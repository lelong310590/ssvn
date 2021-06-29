/**
 * Created by Admin on 1/9/2018.
 */
$('document').ready(function () {
	$('.input-max-length').maxlength({
		alwaysShow: true,
		threshold: 10,
		warningClass: "label label-info",
		limitReachedClass: "label label-warning",
		placement: 'bottom',
		message: '%charsTyped% / %charsTotal% ký tự.',
		validate: true
	})
})