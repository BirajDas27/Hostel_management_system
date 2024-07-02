<head>
	<link rel="stylesheet" href="css/head-side.css">
	<link rel=" stylesheet" href="css/style.css">
</head>
<?php if($_SESSION['id'])
{ ?><div class="brand clearfix" style="height:60px">
		
		<a href="https://trtcguwahati.org/"><img class="image" src="img/logo.png" style="height:60px; width:60px" alt="logo"></a>
		<ul class="ts-profile-nav">
            <li>
                <a href="https://trtcguwahati.org/contact.html">Contact us</a>
            </li>
            <li>
                <a href="https://trtcguwahati.org/about.html">About us</a>
            </li>
        </ul>
		<span class="menu-btn"><i class="fa fa-bars"></i></span>
	</div>

<?php
} else { ?>
<div class="brand clearfix" style="height:60px">
        <a href="https://trtcguwahati.org/"><img class="image" src="img/logo.png" style="height:60px; width:60px" alt="logo"></a>
		<ul class="ts-profile-nav">
            <li>
                <a href="https://trtcguwahati.org/contact.html">Contact us</a>
            </li>
            <li>
                <a href="https://trtcguwahati.org/about.html">About us</a>
            </li>
        </ul>
		<span class="menu-btn"><i class="fa fa-bars"></i></span>
		
	</div>
	<?php } ?>