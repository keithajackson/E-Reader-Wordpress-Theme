if(window.location.hash) {
	var hash = window.location.hash;
	var hashtourl = hash.substring(2);
	window.location.href = "/"+hashtourl;
}
$(document).ready(function () {
	// Cached DOM references
	var $goarchive = $('#goarchive'),
		$gopost = $('#gopost'),
		$archive = $('#archive'),
		$post = $('#post');

	function goarchive() {
		$goarchive.fadeOut(300);
		$post.hide('slide', {
			direction: 'left'
		}, 600, function () {
			$archive.scrollTop(0);
			$archive.show('slide', {
				direction: 'right'
			}, 600);
			$gopost.fadeIn(300);
		});
	}

	function gopost() {
		$gopost.fadeOut(300);
		$archive.hide('slide', {
			direction: 'right'
		}, 600, function () {
			$post.scrollTop(1);
			$post.show('slide', {
				direction: 'left'
			}, 600);
			$goarchive.fadeIn(300);
		});
	}

	function loadpost() {
		var perma = $(this).attr('rel'),
			postid = $(this).attr('id'),
			postitle = $(this).attr('title');

		$(this).parent().parent().addClass('loader');

		$post.load(perma + ' #post', function () {
			$gopost.fadeOut(300);
			$archive.hide('slide', {
				direction: 'right'
			}, 600, function () {
				$post.scrollTop(1);
				$goarchive.fadeIn(300);
				$post.show('slide', {
					direction: 'left'
				}, 600, function () {
					$('#' + postid).parent().parent().removeClass('loader');
					window.location.hash = '/' + postitle;
					if (typeof twttr !== 'undefined') {
						twttr.widgets.load();
					}
				});
			});
		});
	}

	function chmod(newmod) {
		$("body").attr("id", newmod);
		$(".fauxpas-inject").remove();
		$("#fauxpas-footer img").remove();
		if(newmod === "fauxpas") {
			// add audio
			$("body").append('<audio class="fauxpas-inject" src="' + php_src + '/media/hotmk.mp3" autoplay="true" loop="true"></audio>');
			// add images
			$("body").append('<img class="fauxpas-inject" src="' + php_src + '/img/dino.gif" id="fauxpas-dino"></audio>');
			$("body").append('<img class="fauxpas-inject" src="' + php_src + '/img/fire.gif" id="fauxpas-fire"></audio>');
			$("#fauxpas-footer").append('<img src="' + php_src + '/img/ie.gif"/>');
			$("#fauxpas-footer").append('<img src="' + php_src + '/img/netscape.gif"/>');
			$("#fauxpas-footer").append('<img src="' + php_src + '/img/cag.gif"/>');
		}
	}

	$goarchive.on('click',$goarchive,goarchive);

	$gopost.on('click',$gopost,gopost);

	//$archive.find('a').on('click',$archive.find('a'),loadpost);


	/* arrow key blognav */

	$(document).keydown(function(ev) {
		if(ev.which === 39) {
			if ( $post.is(':visible') ) {
				goarchive();
			}
			return false;
		}

		if(ev.which === 37) {
			if ( $archive.is(':visible') ) {
				gopost();
			}
			return false;
		}
	});
	$("html").on("swipeleft", function() {
		if ( $archive.is(':visible') ) {
			gopost();
		}
		return false;
		//This only fires when the user swipes left
	});
	$("html").on("swiperight", function() {
		if ( $post.is(':visible') ) {
			goarchive();
		}
		return false;
	    //This only fires when the user swipes right
	});
	$(".btn-theme").on("click", function() {
		chmod($(this).data("theme"));
		// store the current theme for future reference
		localStorage.setItem("blog-theme", $(this).data("theme"));

	});
	$(window).scroll(function() {
		var scrollMargin = 15;
	   if($(window).scrollTop() < scrollMargin || $(document).height() - ($(window).scrollTop() + $(window).height()) < scrollMargin) {
	       // show the scroll
	   		$("#goarchive").addClass("slideleftborder");
	   } else {
	   		$("#goarchive").removeClass("slideleftborder");
		}
	});
	$(window).scrollTop(1);
	// change theme if it is not the default
	if(localStorage.getItem("blog-theme") != null) {
		chmod(localStorage.getItem("blog-theme"));
	}

});
