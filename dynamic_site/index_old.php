<!DOCTYPE html>

<html>
	<head>
		<title>MyWiFind</title>
		<link rel="stylesheet" type="text/css" href="css/style.css">
		<script src="js/form_validate.js"></script>
	</head>
	
	
	
	<body>
		<div id="wrapper">
			<div id="header">
				<div id="logo">
					<a href="index.html">

						<!--<img src="./images/logo.jpg" alt="logo"> -->

						<svg id="logo_1" viewBox="0 0 612 612">
							<g>
								<path id="border" d="M0,612C0,407.997,0,204.001,0,0c204.002,0,407.997,0,612,0
		c0,204.001,0,407.997,0,612C407.997,612,204.002,612,0,612z M302.946,549.891c56.095,0,112.193,0.197,168.282-0.059
		c46.129-0.214,78.484-32.394,78.581-78.442c0.221-110.148,0.274-220.302-0.03-330.45c-0.125-46.573-32.178-78.736-78.406-78.846
		c-110.148-0.266-220.303-0.251-330.453-0.019c-45.846,0.099-78.739,32.917-78.84,78.694
		c-0.242,110.151-0.248,220.299,0.012,330.453c0.108,46.302,32.196,78.264,78.69,78.58
		C194.833,550.174,248.892,549.891,302.946,549.891z"/>
								<path id="background" d="M302.946,549.891
		c-54.054,0-108.113,0.283-162.166-0.089c-46.494-0.316-78.582-32.278-78.69-78.58c-0.26-110.154-0.254-220.301-0.012-330.453
		c0.101-45.777,32.994-78.595,78.84-78.694c110.15-0.233,220.305-0.247,330.453,0.019c46.229,0.11,78.281,32.273,78.406,78.846
		c0.305,110.147,0.251,220.301,0.03,330.45c-0.097,46.049-32.452,78.229-78.581,78.442
		C415.139,550.088,359.041,549.891,302.946,549.891z M311.332,495.434c102.951-0.442,184.196-83.522,183.946-188.107
		c-0.24-101.879-85.286-185.121-188.389-184.392c-102.15,0.72-184.451,85.244-183.958,188.935
		C123.419,414.636,206.797,495.876,311.332,495.434z"/>
								<path id="circle" d="M311.332,495.434c-104.535,0.442-187.913-80.798-188.401-183.564
		c-0.493-103.691,81.808-188.215,183.958-188.935c103.103-0.729,188.148,82.513,188.389,184.392
		C495.528,411.911,414.283,494.991,311.332,495.434z M210.356,300.943c65.884-51.783,132.082-51.586,199.48,1.663
		c10.626-10.725,20.344-20.533,29.942-30.221c-68.426-76.924-198.446-73.049-258.573-2.611
		C190.093,279.276,198.966,288.761,210.356,300.943z M388.477,320.374c-46.796-45.778-114.397-45.526-158.445,0.144
		c13.486,20.254,25.628,35.565,54.751,18.078c12.387-7.446,36.57-7.112,49.26,0.252
		C361.385,354.715,374.288,342.111,388.477,320.374z M337.824,362.372c-27.33-10.854-31.728-11.045-63.461,0
		c14.493,17.72,23.223,28.395,33.842,41.381"/>
								<path class="line" id="Top_Line" d="M210.356,300.943
		c-11.391-12.183-20.263-21.667-29.15-31.17c60.127-70.438,190.147-74.313,258.573,2.611c-9.599,9.688-19.316,19.496-29.942,30.221
		C342.438,249.357,276.24,249.16,210.356,300.943z"/>
								<path class="line" id="Mid_line" d="M388.477,320.374
		c-14.188,21.737-27.092,34.341-54.434,18.474c-12.689-7.364-36.873-7.698-49.26-0.252c-29.123,17.488-41.265,2.176-54.751-18.078
		C274.08,274.848,341.681,274.596,388.477,320.374z"/>
								<path class="line" id="Bottom_Line" d="M308.205,403.753
		c-10.62-12.987-19.35-23.661-33.842-41.381c34.741-14.247,34.741-14.247,63.461,0"/>
							</g>
						</svg>

					</a  >
				</div>
				<div id="titleblock">
					<h1>MyWiFind</h1>
				</div>
				<div id="menu">
					<ul id="links">
						<li><a href="">Contact Us</li>
						<li><a href="signup.html">Sign Up/ Login</a></li>
						<li><a href="index.html">Home</a></li>
					</ul>
				</div>
			</div>
			
			
			
			
			<div id="content">
			<div id="searchContent">

			<form id ="main_form">
			<input type ="text" name ="search_value" id = "search_value"><br>
Search By:
    <input type="radio" name="search_type" value="name" checked>Name
    <input type="radio" name="search_type" value="suburb">Suburb<br>


		<a href = "results_page.html"><input type="button" value="Lets Go">	</a>
			</form>
			
			<br>
			<br>
			<br>
		<form id = "rating_search">
		Or, Search by Rating
		
		<input type="radio" name="enterRating" value="1">1
						<input type="radio" name="enterRating" value="2">2
						<input type="radio" name="enterRating" value="3">3
						<input type="radio" name="enterRating" value="4">4
						<input type="radio" name="enterRating" value="5">5
		
		<a href = "results_page.html"><input type="button" value="Lets Go">	</a>
		
		</form>
		
		
				<form id = "geolocation_search">
		Find the nearest Wifi Hotspot
		
		
		<a href = "results_page.html"><input type="button" value="Lets Go"></a>
		
		</form>
				
				
				
				</div>
			</div>
			<div id="footer"> 
				<div id="footercontent">
				</div>
			</div>
		</div>
	</body>
</html>

