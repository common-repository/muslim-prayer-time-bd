/*!
 * Muslim Prayer Time BD - v2.4 - 28th March, 2023
 * by @realwebcare - https://www.realwebcare.com/
 */
function prayerOnChange(prayer_id, ptime, card, city) {
	"use strict";
	jQuery.ajax({
		type: 'POST',
		url: mptbajax.ajaxurl,
		data: {
			action: 'mptb_muslim_prayer_time',
			cityid: city,
			prid: prayer_id,
			prtime: ptime,
			srcard: card
		},
		success:function(response){
			var linkid = '#'+prayer_id;
			// Clone the div element
			var $clonedDiv = jQuery(linkid).clone();
			// Replace the original div with the cloned version
			jQuery(linkid).replaceWith($clonedDiv);
			// remove class to avoid duplicate class
			jQuery(linkid).removeClass('muslim_prayer_time');
			// replace id to avoid duplicate id
			var newid = 'prayer-'+prayer_id;
			jQuery(linkid).attr("id", newid);
			// make an animation effect
			jQuery('#'+newid).fadeOut("slow");
			jQuery('#'+newid).html("");
			// display the changed city's prayer time
			jQuery('#'+newid).append(response.substr(response.length-1, 1) === "0" ? response.substr(0, response.length-1) : response).fadeIn("slow");
		},
		error: function(MLHttpRequest, textStatus, errorThrown){
			alert(errorThrown);
		}
	});
}