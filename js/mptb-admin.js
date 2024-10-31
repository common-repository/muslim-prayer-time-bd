/*!
 * Muslim Prayer Time BD - v2.4 - 28th March, 2023
 * by @realwebcare - https://www.realwebcare.com/
 */
 jQuery(document).ready(function($) {
	"use strict";
	$("#mptb_option").click(function() {
		if($("#mptb_option").is(":checked")){
			$("#sehri_enable").slideDown("slow");
			$('.prayer-end').css('border-bottom', '2px solid #aacbcd');
		} else {
			$("#sehri_enable").slideUp("slow");
			$('.prayer-end').css('border-bottom', 'none');
		}
	});
	if($("#mptb_option").is(":checked")){
		$("#sehri_enable").css("display","block");
		$('.prayer-end').css('border-bottom', '2px solid #aacbcd');
	} else {
		$("#sehri_enable").slideUp("slow");
		$('.prayer-end').css('border-bottom', 'none');
	}
	$("#mptb_image").click(function() {
		if($("#mptb_image").is(":checked")){
			$("#image_enable").slideDown("slow");
			$('.end-image').css('border-bottom', 'none');
			$('.prayer-end').css('border-top', '2px solid #aacbcd');
		} else {
			$("#image_enable").slideUp("slow");
			$('.end-image').css('border-bottom', '2px solid #aacbcd');
			$('.prayer-end').css('border-top', 'none');
		}
	});
	if($("#mptb_image").is(":checked")){
		$("#image_enable").css("display","block");
		$('.end-image').css('border-bottom', 'none');
		$('.prayer-end').css('border-top', '2px solid #aacbcd');
	} else {
		$("#image_enable").slideUp("slow");
		$('.end-image').css('border-bottom', '2px solid #aacbcd');
		$('.prayer-end').css('border-top', 'none');
	}
	$('.district_bg_color').wpColorPicker();
	$('.district_font_color').wpColorPicker();
	$('.prayer_name_bg').wpColorPicker();
	$('.prayer_time_bg').wpColorPicker();
	$('.sehri_time_bg').wpColorPicker();
	$('.iftar_time_bg').wpColorPicker();
	$('.sehri_time_font').wpColorPicker();
	$('.prayer_name_font').wpColorPicker();
	$('.prayer_time_font').wpColorPicker();
	$("#clear_all").click(function() {
		var answer = confirm ("Are you sure you want to reset everything?");
		if (answer === true) {
			alert('Prayer timetable has successfully reset!');
			window.location.reload();
		}
	});

	$("#prayer-name").on('click', function(){
		$("#prayer_names")[0].value = 'Fajr, Duhr, Asr, Maghrib, Isha, Sunrise';
		$("#prayer-name").fadeOut("slow");
		$("#name-clear").fadeIn("slow");
	});
	$("#prayer-time").on('click', function(){
		$("#period_times")[0].value = 'Dawn, Noon, Afternoon, Evening, Night, Dawn';
		$("#prayer-time").fadeOut("slow");
		$("#time-clear").fadeIn("slow");
	});

	$("#name-clear").on('click', function(){
		$("#prayer_names")[0].value = '';
		$("#name-clear").fadeOut("slow");
		$("#prayer-name").fadeIn("slow");
	});
	$("#time-clear").on('click', function(){
		$("#period_times")[0].value = '';
		$("#time-clear").fadeOut("slow");
		$("#prayer-time").fadeIn("slow");
	});
	
	if($("#prayer_names")[0].value != ''){
		$("#prayer-name").hide();
		$("#name-clear").show();
	}
	if($("#period_times")[0].value != ''){
		$("#prayer-time").hide();
		$("#time-clear").show();
	}

	$.mptbSelectOption();
	$.mptbdMediaUploader();
		
	// Remove image
	$('body').on('click', '#remove_image', function() {
		var targetfield = $(this).parents('#image_enable').find('#prayer_image');
		$(targetfield).val('');
		$(this).parents('#show_upload_preview').slideUp('slow');
		$(this).parents('#image_enable').find('.start-image').css('border-bottom', 'none');
	});
});
( function($) {
	"use strict";
	// Iterate over each select element
	$.mptbSelectOption = function() {
		$('.prayer-options select').each(function () {

			// Cache the number of options
			var $this = $(this),
				numberOfOptions = $(this).children('option').length;

			// Hides the select element
			$this.addClass('s-hidden');

			// Wrap the select element in a div
			$this.wrap('<div class="select'+(($this.attr("data-class")) ? " "+$this.attr("data-class") : "")+'"></div>');

			// Insert a styled div to sit over the top of the hidden select element
			$this.after('<div class="styledSelect"></div>');

			// Cache the styled div
			var $styledSelect = $this.next('div.styledSelect');

			var $selected = $this.children('option:selected');

			var $contentSelected = (($selected.attr("data-photo")) ? '<img src="'+$selected.attr("data-photo")+'" />' : "") + (($selected.attr("data-icon")) ? '<span class="ir ico '+$selected.attr("data-icon")+'"></span>' : "") + $selected.text();

			// Show the first select option in the styled div
			$styledSelect.html($contentSelected);

			// Insert an unordered list after the styled div and also cache the list
			var $list = $('<ul />', {
				'class': 'options',
			}).insertAfter($styledSelect);

			// Insert a list item into the unordered list for each select option
			for (var i = 0; i < numberOfOptions; i++) {
				var content = (($this.children('option').eq(i).attr("data-photo")) ? '<img src="'+$this.children('option').eq(i).attr("data-photo")+'" />' : "") + (($this.children('option').eq(i).attr("data-icon")) ? '<span class="ir ico '+$this.children('option').eq(i).attr("data-icon")+'"></span>' : "") + $this.children('option').eq(i).text();
				var $option = $this.children('option').eq(i);

				$('<li />', {
					html: content,
					rel: $this.children('option').eq(i).val(),
					"class": (($selected.val() == $option.val()) ? 'active' : '') +
								($option.attr('disabled') ? ' disabled' : ''),
					"data-photo": $option.attr("data-photo"),
					"data-icon": $option.attr("data-icon")
				}).appendTo($list);
			}

			// Cache the list items
			var $listItems = $list.children('li');

			if($this.attr("data-error")){
				$this.parent().append('<div class="select__error">'+ $this.attr("data-error") +'</div><div class="select__ico select__ico--error"></div></div><div class="select__ico select__ico--ok"></div>');
			}

			// Show the unordered list when the styled div is clicked (also hides it if the div is clicked again)
			$styledSelect.click(function(e) {
				e.stopPropagation();
				if (!$(this).hasClass("active")) {
					$('div.styledSelect.active').each(function() {
						$(this).removeClass('active').next('ul.options').hide();
					});
				}
				$(this).toggleClass('active').next('ul.options').toggle();
			});

			// Hides the unordered list when a list item is clicked and updates the styled div to show the selected list item
			// Updates the select element to have the value of the equivalent option
			$listItems.click(function(e) {
				e.stopPropagation();
				var $selected = $(this);
				if ($selected.hasClass('disabled')){return;}
				var $contentSelected = (($selected.attr("data-photo")) ? '<img src="'+$selected.attr("data-photo")+'" />' : "") + (($selected.attr("data-icon")) ? '<span class="ir ico '+$selected.attr("data-icon")+'"></span>' : "") + $selected.text();
				$styledSelect.html($contentSelected).removeClass('active');

				if ($this.val() != $(this).attr('rel')) {
					$this.val($(this).attr('rel')).change();
				}

				$list.hide();
			});

			// Hides the unordered list when clicking outside of it
			$(document).click(function () {
				$styledSelect.removeClass('active');
				$list.hide();
			});
		});
	};
	/**
	 * 
	 * mptbdMediaUploader v1.0 2019-10-04
	 * Copyright (c) 2019 mptbd
	 * 
	 */
	$.mptbdMediaUploader = function( options ) {
		var settings = $.extend({
			target : '.start-image', // The class wrapping the textbox
			uploaderTitle : 'Select or upload image', // The title of the media upload popup
			uploaderButton : 'Set image', // the text of the button in the media upload popup
			multiple : false, // Allow the user to select multiple images
			buttonText : 'Upload image', // The text of the upload button
			buttonClass : '.mptbd-upload', // the class of the upload button
			previewSize : '', // The preview image size
			modal : false, // is the upload button within a bootstrap modal ?
			buttonStyle : { // style the button
				color : '#fff',               
			},
		}, options );

		$( settings.target ).append( '<a href="#" class="button-primary ' + settings.buttonClass.replace('.','') + '">' + settings.buttonText + '</a>' );
		$( settings.target ).append('<div id="show_preview" class="prayer-options end-image" style="display: none;"><label class="input-title">Preview</label><img class="preview_image" src="#" style="display: none;"><span id="remove_image"></span></div>');
		$( settings.buttonClass ).css( settings.buttonStyle );

		$('body').on('click', settings.buttonClass, function(e) {
			e.preventDefault();
			var selector = $(this).parent( settings.target );
			var custom_uploader = wp.media({
				title: settings.uploaderTitle,
				button: {
					text: settings.uploaderButton
				},
				multiple: settings.multiple
			})

			.on('select', function() {
				var attachment = custom_uploader.state().get('selection').first().toJSON();
				selector.find( '#show_preview' ).slideDown("slow");
				selector.parents('#image_enable').find('#show_upload_preview').hide();
				selector.find( 'img' ).attr( 'src', attachment.url).show();
				selector.find( 'input' ).val(attachment.url);
				if( settings.modal ) {
					$('.modal').css( 'overflowY', 'auto');
				}
				// Remove image
				$('body').on('click', '#remove_image', function() {
					var targetfield = $(this).parents('#image_enable').find('#prayer_image');
					$(targetfield).val('');
					$(this).parents('#show_preview').slideUp('slow');
				});
			})
			.open();
		}); 
	};
})(jQuery);