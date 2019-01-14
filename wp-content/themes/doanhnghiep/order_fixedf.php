<div class="order-fixedf">
	<div id="x"> </div>
	<script type="text/javascript">
		var x = document.getElementById('x');
		var s = [
		'Anh <strong>Nguyễn Quang Minh</strong> ở Hà Nội vừa đặt hàng thành công <strong>3</strong> hộp Xukoda !',
		'Chỉ còn lại 90 hộp xukoda ! ',

		'Chị <strong>Nguyễn Thị Khuyên</strong> ở Bình Dương vừa đặt hàng thành công <strong>10</strong> hộp Xukoda ! ',
		'Chỉ còn lại <strong>80</strong> hộp xukoda !',

		'Chị <strong>Phạm Hồng Hạnh</strong> ở Phú Thọ vừa đặt hàng thành công <strong>3</strong> hộp Xukoda !',
		'Chỉ còn lại <strong>77</strong> hộp xukoda !',

		'Anh <strong>Phạm Minh Tuấn</strong> ở Hà Nội vừa đặt hàng thành công <strong>6</strong> hộp Xukoda !',
		'Chỉ còn lại <strong>71</strong> hộp xukoda !',

		'Anh <strong>Nguyễn Văn Tăng</strong> ở Hà Đông vừa đặt hàng thành công <strong>9</strong> hộp Xukoda !',
		'Chỉ còn lại <strong>62</strong> hộp xukoda !',

		'Anh <strong>Nguyễn Thái Sơn</strong> ở Lạng Sơn vừa đặt hàng thành công <strong>12</strong> hộp Xukoda !',
		'Chỉ còn lại <strong>50</strong> hộp xukoda !',

		'Chị <strong>Nguyễn Quang Minh</strong> ở Hà Nội vừa đặt hàng thành công <strong>6</strong> hộp Xukoda !',
		'Chỉ còn lại <strong>44</strong> hộp xukoda !',

		'Chị <strong>Nguyễn Thu Hằng</strong> ở Kon Tum vừa đặt hàng thành công <strong>12</strong> hộp Xukoda !',
		'Chỉ còn lại <strong>32</strong> hộp xukoda !',

		];
		var i = 0;

	
		setTimeout(	function loop() {
			console.log(i);
			x.innerHTML = s[i];
			jQuery('.order-fixedf').hide();
			if (++i < s.length) {
				jQuery('.order-fixedf').show();
				setTimeout(loop, 4000);
			}
		},10000);
	</script>	
</div>
