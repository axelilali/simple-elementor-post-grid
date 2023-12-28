jQuery(function ($) {
	let page = 2;

	$("#ilali-post-widget button").on("click", function () {
		let siteUrl = $(this).data("site-url");
		let postType = $(this).data("post-type");
		let postOrder = $(this).data("post-order");
		let postsPerPage = $(this).data("posts-per-page");
		let excerptLength = $(this).data("excerpt-length");
		let maxPages = $(this).data("max-pages");

		let columns = $(this).data("columns");
		let thumbnail = $(this).data("thumbnail");
		let title = $(this).data("title");
		let date = $(this).data("date");
		let excerpt = $(this).data("excerpt");

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
				thumbnail,
				title,
				date,
				excerpt,
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

				if (page >= maxPages) {
					$("#ilali-post-widget button").hide();
				}
			},
			error: function (err) {
				console.error(err);
				$("#ilali-post-widget").css({
					opacity: 1,
					pointerEvents: "all",
				});
			},
		});
	});
});
