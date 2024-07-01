<head>
	<link rel="stylesheet" href="css/head-side.css">
	<link rel=" stylesheet" href="css/style.css">
</head>
<?php if($_SESSION['id'])
{ ?><div class="brand clearfix" style="height:60px">
		
		<img src="" style="height:60px; width:60px" alt="logo">
		<a href="#" class="logo" style="font-size:16px;">TRTC</a>
		<span class="menu-btn"><i class="fa fa-bars"></i></span>
	</div>

<?php
} else { ?>
<div class="brand clearfix" style="height:60px">
		<img src="" style="height:60px; width:60px" alt="logo">
		<a href="#" class="logo" style="font-size:16px;">TRTC</a>
		<span class="menu-btn"><i class="fa fa-bars"></i></span>
		
	</div>
	<?php } ?>