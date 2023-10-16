jQuery(function ($) {
	$page = 2;

	$("#ilali-post-widget button").on("click", function () {
		$siteUrl = $(this).data("site-url");
		$postType = $(this).data("post-type");
		$postOrder = $(this).data("post-order");
		$postsPerPage = $(this).data("posts-per-page");
		$excerptLength = $(this).data("excerpt-length");

		$.ajax({
			method: "post",
			url: `${$siteUrl}/wp-admin/admin-ajax.php`,
			headers: {},
			data: {
				action: "posts_pagination",
				page: $page,
				postType: $postType,
				postOrder: $postOrder,
				postsPerPage: $postsPerPage,
				excerptLength: $excerptLength,
			},
			beforeSend: function () {
				$("#ilali-post-widget").css({
					opacity: 0.5,
					pointerEvents: "none",
				});
			},
			success: function (response) {
				$("#ilali-post-widget").css({
					opacity: 1,
					pointerEvents: "all",
				});
				$("#ilali-post-widget .row").append(response.data);
				$page++;
			},
			error: function (err) {
				console.log(err);
			},
		});
	});
});
