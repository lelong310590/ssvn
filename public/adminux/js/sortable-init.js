/**
 * Created by Admin on 4/9/2018.
 */
$( function() {
	$( ".sortable" ).sortable({
		placeholder: "ui-state-highlight"
	});
	$( ".sortable" ).disableSelection();

	$('.sortable-add-more-button').on('click', function (e) {
		e.preventDefault();
		var _this = $(e.currentTarget);
		var inputName = _this.attr('data-name-value');
		var sortable = _this.parent().prev();
		var placeHolder = sortable.attr('data-placeholder');
		var html = '<li class="ui-state-default">';
		html += '<input type="text" ' +
						'class="form-control" ' +
						'autocomplete="off" ' +
						'name="' + inputName + '" ' +
						'placeholder="' + placeHolder + '" ' +
				'>';
		html += '<i class="fa fa-bars move-item"></i>';
		html += '<a href="#" class="target-delete-item"><i class="fa fa-times"></i></a>';
		html += '</li>'	;
		sortable.append(html);
	})

	$('.target-input-content').on('focus', function (e) {
		e.preventDefault();
		var _this = $(e.currentTarget);
		var name = _this.attr('data-name-value');
		_this.attr('name', name);
	})

	$('.target-input-content').on('mouseleave', function (e) {
		e.preventDefault();
		var _this = $(e.currentTarget);
		var name = _this.attr('data-name-value');
		var value = _this.val();
		if (value != '') {
			_this.attr('name', name);
		} else {
			_this.removeAttr('name');
		}
	})

	$('body').on('click', '.target-delete-item' , function (e) {
		e.preventDefault();
		var _this = $(e.currentTarget);
		var sortable = _this.parent().prev().children().size();
		if (sortable > 0) {
			_this.parent().remove();
		} else {
			return false;
		}
	})

	// Curriculum

	//Set sortable
	$( ".curriculum-sortable" ).sortable({
		placeholder: "curriculum-sortable-state-highlight"
	});
	$( ".curriculum-sortable" ).disableSelection();

	/**
	 * Click edit on avaiable section
	 */
	$('body').on('click', '.curriculum-section-toolbar-edit', function (e) {
		e.preventDefault();
		var _this = $(e.currentTarget);
		var title = _this.parents('.curriculum-section-title');
		var txt = title.find('.curriculum-section-title-value');
		var txtValue = txt.attr('data-value');
		var editor = title.next();
		var inputTitle = editor.find('.curriculum-section-edit-title');
		editor.show();
		inputTitle.val(txtValue);
		title.hide();
	})

	/**
	 * Click delete button on the avaiable section
	 */
	$('body').on('click', '.curriculum-section-toolbar-delete', function (e) {
		e.preventDefault();
		var _this = $(e.currentTarget);
		var elemArray = $('.curriculum-section-state').toArray();
	})

	/**
	 * Click cancel on the current edit section
	 */
	$('body').on('click', '.curriculum-section-edit-cancel', function (e) {
		e.preventDefault();
		var _this = $(e.currentTarget);
		var editor = _this.parents('.curriculum-section-edit-wrapper');
		var title = editor.prev();
		var txt = title.find('.curriculum-section-title-value');
		var txtValue = txt.attr('data-value');
		if (txtValue != '') {
			editor.hide();
			title.show();
		} else {
			title.parents('.curriculum-section').remove();
		}
	})

	/**
	 * Click add more section button
	 */
	$('.curriculum-add-more').on('click', function (e) {
		e.preventDefault();
		var _this = $(e.currentTarget);
		// var html = '<div class="curriculum-section col-sm-16">';
		// html += '<div class="curriculum-section-state col-sm-16">';
		// html += '<h4 class="curriculum-section-title" style="display: none">'
		// html += '<b>Phần:</b>';
		// html += '<i class="fa fa-file-text-o" aria-hidden="true"></i> ';
		// html += '<span class="curriculum-section-title-value" data-value=""></span>';
		// html += '<div class="curriculum-section-toolbar">';
		// html += '<a href="" class="curriculum-section-toolbar-edit"><i class="fa fa-pencil" aria-hidden="true"></i></a>';
		// html += '<a href="" class="curriculum-section-toolbar-delete"><i class="fa fa-trash-o" aria-hidden="true"></i></a>';
		// html += '</div>';
		// html += '<div class="section-move-item float-right">';
		// html += '<i class="fa fa-bars"></i>';
		// html += '</div>';
		// html += '</h4>';
		// html += '<div class="curriculum-section-edit-wrapper" style="display: block">';
		// html += '<form action="">';
		// html += '<div class="form-group">';
		// html += '<label for="example-text-input" class="col-form-label"><b>Phần</b></label>';
		// html += '<input class="form-control curriculum-section-edit-title" type="text" value="">';
		// html += '</div>';
		// html += '<div class="form-group">';
		// html += '<label for="example-text-input" class="col-form-label">Học sinh sẽ có thể làm gì vào cuối phần này?</label>';
		// html += '<input class="form-control curriculum-section-edit-title-description" type="text" value="">';
		// html += '</div>';
		// html += '<div class="form-group text-right">';
		// html += '<a type="submit" class="btn btn-primary curriculum-section-edit-cancel">Đóng</a>';
		// html += '<button type="submit" class="btn btn-primary">Lưu lại</button>';
		// html += '</div>';
		// html += '</form>';
		// html += '</div>';
		// html += '</div>';
		// html += '</div>';

		$('.curriculum-toolbar-add-wrapper').show();
		_this.hide();
	})

	/**
	 * Click close button on add-more section
	 */
	$('.curriculum-toolbar-add-close').on('click', function (e) {
		e.preventDefault();
		var _this = $(e.currentTarget);
		_this.parents('.curriculum-toolbar-add-wrapper').hide();
		$('.curriculum-add-more').show();
	})

	/**
	 * Click save button on add-more section
	 */
	$('.curriculum-toolbar-add-save').on('click', function (e) {
		e.preventDefault();
		var _this = $(e.currentTarget);
		var txt = _this.parents('.curriculum-toolbar-add-wrapper').find()
	})
} );