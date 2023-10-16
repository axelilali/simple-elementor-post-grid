jQuery(function ($) {
	let page = 2;

	$("#ilali-post-widget button").on("click", function () {
		let siteUrl = $(this).data("site-url");
		let postType = $(this).data("post-type");
		let postOrder = $(this).data("post-order");
		let postsPerPage = $(this).data("posts-per-page");
		let excerptLength = $(this).data("excerpt-length");
		let columns = $(this).data("columns");

		$.ajax({
			method: "post",
			url: `${siteUrl}/wp-admin/admin-ajax.php`,
			headers: {},
			data: {
				action: "posts_pagination",
				page,
				postType,
				postOrder,
				postsPerPage,
				excerptLength,
				columns,
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
				page++;
			},
			error: function (err) {
				console.log(err);
				$("#ilali-post-widget").css({
					opacity: 1,
					pointerEvents: "all",
				});
			},
		});
	});
});
