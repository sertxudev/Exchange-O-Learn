<body style="background-color:#000">
    <div style="text-align:center;height: 100%;">
        <img src="./assets/img/blocked.gif" style="height: 100%;" alt="">
    </div>
<script>

	setInterval(
        function () {
            $.ajax({
				method: "POST",
				url: "post.php",

				data: {
				    r: 'bloqueado'
				}
			})
				.done(function (msg) {
				    if (msg == 0) {
				        location.reload();
				    }
		    	});
        }
	, 1500);

</script>
</body>

