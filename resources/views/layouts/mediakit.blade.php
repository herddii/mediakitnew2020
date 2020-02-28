<!DOCTYPE html>
<html lang="en">

<!-- Mirrored from irtech.biz/TF/buxkit/buxkit/index.html by HTTrack Website Copier/3.x [XR&CO'2014], Tue, 11 Feb 2020 09:33:04 GMT -->
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Mediakit 2.0</title>
    {{Html::style('css/bootstrap.min.css')}}
    {{Html::style('css/animate.css')}}
    {{Html::style('css/magnific-popup.css')}}
    {{Html::style('css/style.css')}}
    {{Html::style('css/responsive.css')}}

    {{Html::script('js/jquery.min.js')}}
    {{Html::script('js/bootstrap.min.js')}}
    {{Html::script('js/TweenMax.js')}}
</head>

<body> 
<!-- navbar area start -->
<nav class="navbar fixed-top navbar-expand-lg navbar-light bg-light">
	<div class="container">
  <a class="navbar-brand" href="#"><img src="{{URL::to('img/MNCmediakit.png')}}" style="width: 100px; height: auto"></a>
  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarTogglerDemo02" aria-controls="navbarTogglerDemo02" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button>

  <div class="collapse navbar-collapse" id="navbarTogglerDemo02">
    <ul class="navbar-nav mr-auto mt-2 mt-lg-0">
       <li class="nav-item">
                    <a class="nav-link" href="#about">HOME</a>
                </li>
                <li class="nav-item dropdown">
                    <a class="nav-link" href="#feature">SALESKIT</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#pricing">DASHBOARD</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#team">SAM LITE</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#team">MBA LITE</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#team">SOCMED LIVE</a>
                </li>
                <li class="nav-item">
                	 <a class="nav-link pl-0 dropdown-toggle" data-toggle="dropdown" href="#">MORE
                            <span class="sr-only">(current)</span>
                        </a>
                        <div class="dropdown-menu">
                            <a href="blog.html" class="dropdown-item">Client Birthday</a>
                            <a href="blog-grid.html" class="dropdown-item">Vislog</a>
                            <a href="blog-no-sidebar.html" class="dropdown-item">About Us</a>
                            <a href="blog-details.html" class="dropdown-item">Collaboration</a>
                            <a href="blog-details.html" class="dropdown-item">Competitor Info</a>
                        </div>
                </li>
                <li class="nav-item">
                    <a href="#" class="nav-link" style="color: darkblue; ">Hai, Adelia Fortiena</a>
                </li>
    </ul>
  </div>
</div>
</nav>
<!-- navbar area end -->

<!-- header area start -->
@yield('content')
<!-- block feature area end -->

<!-- why choose us area start -->

<!-- footer area start -->
<footer class="footer-area footer-bg">
    <div class="container">
        <div class="row">
            <div class="col-lg-4 col-md-6">
                <div class="footer-widget widget about_widget"><!-- footer widget -->
                    <a href="index.html" class="footer-logo"><img src="{{URL::to('img/MNCmediakit.png')}}" style="width: 100px; height: auto;" alt=""></a>
                    <div class="copyright-text margin-top-30">Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod
                    tempor incididunt ut labore et dolore magna aliqua.</div>
                </div><!-- //. footer widget -->
            </div>
            <div class="col-lg-8 col-md-6">
                <div id="logohere"><!-- footer widget -->
                    <!-- <h4 class="widget-title">MNC Group</h4> -->
                </div><!-- //. footer widget -->
            </div>
        </div>
    </div>
</footer>
<!-- footer area end -->

<div class="back-to-top base-color-2">
        <i class="fas fa-rocket"></i>
</div>

</body>
<script>
	$(()=>{
		$.get("{{URL::to('mam/dashboard/channel')}}",(x)=>{
			var view = '<div class="footer-widget widget"><div class="row">';
			x.forEach((xd)=>{
				var url = 'img/logounit/'+xd.img;
				view +=`<div class="col-lg-2">
                    	<img src="{{URL::to('img/logounit/${xd.img}')}}" style="width: 70%;"/>
                    </div>`;
			})
			view +='</div></div>'
			$('#logohere').html(view);
		})
	})
</script>
@yield('js')
</html>