
@extends('layouts.mediakit')

@section('content')
<div class="header-area header-bg" id="home">
   <div class="header-bottom-area padding-top-130"><!-- header bottom area -->
       <div class="container">
           <div class="row">
               <div class="col-lg-4 col-md-6 animated flipInX" style="padding-right: 5px;
    padding-left: 5px; animation-delay: 0.1s">
                   <div class="single-feature-item-01  wow zoomIn" style="background: url('/img/testing.jpg'); background-repeat: no-repeat; background-size: cover; height: 250px;">
                        <h4 class="title animated fadeInDown" style="color: white; animation-delay: 0.3s;">Target Vs Achievement</h4>
                        <div class="content" style="display: flex; flex-direction: row; justify-content: space-around;
    align-items: center;">
                        <div style="display: flex; flex-direction: column;">
                            <div class="animated fadeInLeft" style="display: flex; flex-direction: row; align-items: center; margin: 2px; animation-delay: 0.5s;">
                                <div style="display: flex; background-color: #124699; width: 50px; height: 50px; border-radius: 10px; justify-content: center; align-items: center;">
                                    <span style="font-size: 1.2rem; font-weight: bold; color: white;">70%</span>
                                </div>
                                <div style="display: flex; background-color: white; width: 80px; height: 30px; border-radius: 0px 10px 10px 0px; justify-content: center; align-items: center;">
                                    <img src="{{URL::to('img/rcti.png')}}" style="width: 30px;"/>
                                </div>
                            </div>
                            <div class="animated fadeInLeft" style="display: flex; flex-direction: row; align-items: center; margin: 2px; animation-delay: 0.7s;">
                                <div style="display: flex; background-color: #124699; width: 50px; height: 50px; border-radius: 10px; justify-content: center; align-items: center;">
                                    <span style="font-size: 1.2rem; font-weight: bold; color: white;">70%</span>
                                </div>
                                <div style="display: flex; background-color: white; width: 80px; height: 30px; border-radius: 0px 10px 10px 0px; justify-content: center; align-items: center;">
                                    <img src="{{URL::to('img/MNCTV.png')}}" style="width: 30px;"/>
                                </div>
                            </div>
                            <div class="animated fadeInLeft" style="display: flex; flex-direction: row; align-items: center; margin: 2px; animation-delay: 0.8s;">
                                <div style="display: flex; background-color: #124699; width: 50px; height: 50px; border-radius: 10px; justify-content: center; align-items: center;">
                                    <span style="font-size: 1.2rem; font-weight: bold; color: white;">70%</span>
                                </div>
                                <div style="display: flex; background-color: white; width: 80px; height: 30px; border-radius: 0px 10px 10px 0px; justify-content: center; align-items: center;">
                                    <img src="{{URL::to('img/GTV.png')}}" style="width: 30px;"/>
                                </div>
                            </div>
                        </div>
                        <div class="animated zoomIn" style="display: flex; background-color: white; width: 150px; height: 150px; border-radius: 400px; justify-content: center; align-items: center; animation-delay: 1s;">
                             <span class="animated zoomIn" style="font-size: 3.8rem; font-weight: bold; color: #682ee5; animation-delay: 1.2s;">70%</span>
                        </div>
                        </div>
                        
                   </div><!-- //. single feature item 01 -->
               </div>
               <div class="col-lg-2 col-md-6 animated" style="padding-right: 5px;
    padding-left: 5px; animation-delay: 0.2s">
                   <div class="single-feature-item-01 animated flipInY" style="background: url('/img/testing5.jpg'); background-repeat: no-repeat; background-size: cover; height: 250px; animation-delay: 0.5s"><!-- single feature item 01 -->
                        <div class="content" style="display: flex; flex-direction: column; justify-content: space-around; align-items: center;">
                            <span class="title" style="color: #fff;">Market Share</span>
                            <div style="display: flex; border-radius: 50px; width: 90px; height: 90px; background-color: #fff; justify-content: center; align-items: center;">
                            <p style="font-size: 1.8rem;
    font-weight: bold; color: #1029e0;">68%</p>
                            </div>
                        </div>
                   </div><!-- //. single feature item 01 -->
               </div>
               <div class="col-lg-2 col-md-6" style="padding-right: 5px;
    padding-left: 5px;">
                   <div class="single-feature-item-01  wow zoomIn" style="background: url('/img/testing2.jpg'); background-repeat: no-repeat; background-size: cover; height: 250px;"><!-- single feature item 01 -->
                            <h4 class="title" style="color: white;">SAM</h4>

                        <div class="icon">
                            <img src="{{URL::to('icon/SAM.PNG')}}" class="iconsvg"/>
                        </div>
                        <div class="content">
                            <p style="color: #0a4d5e;
                            background-color: white;
                            border-radius: 50px; margin: 5px; font-size: 14px;">16 Packages</p>
                            <p style="color: #0a4d5e;
                            background-color: white;
                            border-radius: 50px; margin: 5px; font-size: 14px;">12 Concepts</p>
                        </div>
                   </div><!-- //. single feature item 01 -->
               </div>
               <div class="col-lg-2 col-md-6" style="padding-right: 5px;
    padding-left: 5px;">
                   <div class="single-feature-item-01  wow zoomIn" style="background: url('/img/testing3.jpg') 50% 50%; background-repeat: no-repeat; background-size: cover; height: 250px;"><!-- single feature item 01 -->
                            <h4 class="title" style="color: white;">MBA</h4>

                        <div class="icon">
                            <img src="{{URL::to('icon/MBA.PNG')}}" class="iconsvg"/>
                        </div>
                        <div class="content">
                            <p style="color: #f53611;
                            background-color: white;
                            border-radius: 50px; margin: 5px; font-size: 14px;">1 Pop Quiz</p>
                            <p style="color: #f53611;
                            background-color: white;
                            border-radius: 50px; margin: 5px; font-size: 14px;">1 Monthly Test</p>
                        </div>
                   </div><!-- //. single feature item 01 -->
               </div>
               <div class="col-lg-2 col-md-6" style="padding-right: 5px;
    padding-left: 5px;">
                   <div class="single-feature-item-01  wow zoomIn" style="background: url('/img/testing4.jpg') 50% 50%; background-repeat: no-repeat; background-size: cover; height: 250px;"><!-- single feature item 01 -->
                            <h4 class="title" style="color: white;">CAM</h4>

                        <div class="icon">
                            <img src="{{URL::to('icon/system.png')}}" class="iconsvg"/>
                        </div>
                        <div class="content">
                            <p style="color: #4b307f;
                            background-color: white;
                            border-radius: 50px; margin: 5px; font-size: 14px;">4 Meetings</p>
                            <p style="color: #4b307f;
                            background-color: white;
                            border-radius: 50px; margin: 5px; font-size: 14px;">Client Handling</p>
                            <p style="color: #4b307f;
                            background-color: white;
                            border-radius: 50px; margin: 5px; font-size: 14px;">Product Handling</p>
                        </div>
                   </div><!-- //. single feature item 01 -->
               </div>
           </div>
       </div>
   </div><!-- header bottom area -->
</div>
<!-- header area end -->

<!-- block feature area start -->
<div class="block-feature-area padding-top-50" id="about">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <div class="block-feature-item"><!-- block feature item -->
                    <div style="display: flex; flex-direction: column; padding: 10px">
                        <div style="display: flex;">
                            <span style="font-size: 2.5rem; font-weight: bold;">INSIGHT</span>
                        </div>
                        <div style="background-color: #c5c5c5; height: 3px; width: 250px; border-radius: 10px;"></div>
                    </div>
                    <div class="row">
                        <div class="col-lg-6">
                             <div class="content-block-area"><!-- content block area -->
                                <h6 class="title wow fadeInUp">Performance Channel</h6>
                                <div style="display: flex; flex-direction: column;">
                                    <div style="display: flex; padding: 5px;">
                                        <span style="font-size: 1rem; font-weight: bold; color: #dc3545">TVR Periode 17 February 2020</span>
                                    </div>
                                    <div class="row padding-left-50">
                                        <div style="height: 350px; width: 100%; display: flex; flex-wrap: wrap;" id="tvr">
                                            <img src="{{URL::to('icon/loaded.gif')}}"/>
                                        </div>
                                    </div>
                                    <div class="btn-wrapper wow fadeInDown" style="margin-top: 10px; display: flex; justify-content: center;">
                                    <a href="#" class="boxed-btn gd-bg br-5 w180px">Read More</a>
                                </div>
                                </div>
                            <!-- <a href="#" class="btn btn-danger" style="float: left;">Read More</a> -->
                            </div>
                            <!-- <div class="btn-wrapper margin-top-20 wow fadeInDown" style="margin-top: -10px;">
                                    <a href="#" class="boxed-btn gd-bg br-5 w180px">Read More</a>
                                </div> -->
                        </div>
                        <div class="col-lg-6">
                            <div class="content-block-area padding-left-50"><!-- content block area -->
                                <h6 class="title wow fadeInUp">TOP PROGRAM</h6>
                                <div style="display: flex; flex-direction: column; align-items: center;">
                                    <div style="display: flex; padding: 5px; align-self: flex-start;">
                                        <span style="font-size: 1rem; font-weight: bold; color: #dc3545">Top Program in MNCGROUP for all Genre</span>
                                    </div> 
                                    <div class="row">
                                        <div style="height: 350px;" id="tp">
                                            <img src="{{URL::to('icon/loaded.gif')}}"/>
                                        </div>
                                </div>
                                <div class="btn-wrapper wow fadeInDown" style="margin-top: 10px; display: flex; justify-content: center;">
                                    <a href="#" class="boxed-btn gd-bg br-5 w180px">Read More</a>
                                </div>
                                </div>
                            </div>
                            
                        </div>
                    </div>
                </div>
            </div>  
        </div>
    </div>
</div>
<!-- block feature area end -->

<!-- block feature area start -->
<div class="block-feature-area padding-50">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <div class="block-feature-item"><!-- block feature item -->
                    <div style="display: flex; flex-direction: column; padding: 10px">
                        <div style="display: flex;">
                            <span style="font-size: 2.5rem; font-weight: bold;">Market Share</span>
                        </div>
                        <div style="background-color: #c5c5c5; height: 3px; width: 300px; border-radius: 10px;"></div>
                    </div>
                    <div class="row reorder-xs" style="margin-top: 20px;">
                        <div class="col-lg-6">
                            <div class="content-block-area padding-left-50"><!-- content block area -->
                                <div style="display: flex; flex-direction: column;">
                                    <h6 class="title wow fadeInUp" style="display: flex; align-self: flex-start;">Advertiser</h6>
                                    <div class="row">
                                        <div style="height: 320px;" id="adv_market">
                                            <img src="{{URL::to('icon/loaded.gif')}}"/>
                                   </div>
                                    </div>
                                    <div class="btn-wrapper wow fadeInDown" style="margin-top: 10px; display: flex; justify-content: center;">
                                    <a href="#" class="boxed-btn gd-bg br-5 w180px">Read More</a>
                                </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="content-block-area" style="padding-left: 43px;"><!-- content block area -->
                                <div style="display: flex; flex-direction: column; align-items: space-around;">
                                   <h6 class="title wow fadeInUp" style="display: flex; align-self: flex-start;">Agency</h6>
                                    <div class="row">
                                        <div style="height: 320px;" id="agcy_mkt">
                                            <img src="{{URL::to('icon/loaded.gif')}}"/>
                                   </div>
                                    </div>
                                    <div class="btn-wrapper wow fadeInDown" style="margin-top: 10px; display: flex; justify-content: center;">
                                    <a href="#" class="boxed-btn gd-bg br-5 w180px">Read More</a>
                                </div>
                                </div>
                                
                            </div>
                            
                        </div>
                    </div>
                </div>
            </div>  
        </div>
    </div>
</div>

<div class="block-feature-area padding-50">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <div class="block-feature-item"><!-- block feature item -->
                    <div style="display: flex; flex-direction: column; padding: 10px">
                        <div style="display: flex;">
                            <span style="font-size: 2.5rem; font-weight: bold;">News</span>
                        </div>
                        <div style="background-color: #c5c5c5; height: 3px; width: 200px; border-radius: 10px;"></div>
                    </div>
                    <div class="row reorder-xs" style="margin-top: 20px;">
                        <div class="col-lg-12">
                            <div class="content-block-area padding-50"><!-- content block area -->
                                <div style="display: flex; flex-direction: column; align-items: space-between;">
                                    <h6 class="title wow fadeInUp" style="display: flex; align-self: center;">Brand Activity</h6>
                                    <div class="row">
                                        <div id="brand_activity" class="row">
                                            <img src="{{URL::to('icon/loaded.gif')}}"/>
                                        </div>
                                    </div>
                                    <div class="btn-wrapper wow fadeInDown" style="margin-top: 10px; display: flex; justify-content: center;">
                                    <a href="#" class="boxed-btn gd-bg br-5 w180px">Read More</a>
                                </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-12">
                            <div class="content-block-area padding-50"><!-- content block area -->
                                <div style="display: flex; flex-direction: column; align-items: space-between;">
                                    <h6 class="title wow fadeInUp" style="display: flex; align-self: center;">Brand Campaign</h6>
                                    <div class="row">
                                        <div id="brand_campaign" class="row">
                                            <img src="{{URL::to('icon/loaded.gif')}}"/>
                                        </div>
                                    </div>
                                    <div class="btn-wrapper wow fadeInDown" style="margin-top: 10px; display: flex; justify-content: center;">
                                    <a href="#" class="boxed-btn gd-bg br-5 w180px">Read More</a>
                                </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>  
        </div>
    </div>
</div>

@stop

@section('js')
<script>  
    $(()=>{
        var width = window.screen.width - 10;
        $('.flextengah').css('width',width);
        
        brand_act(3);
        brand_camp(5);
        tvrate();
        listoprogram();
        market_share_adv();
        market_share_agcy();
        
        
    })
    function addZero(i){
        return i < 10 ? `0${i}` : i;
    }
    function transform(value){
        // console.log(value.toLowerCase().includes('https://www.youtube.com/'));
        let val = value.replace('https://www.youtube.com/','');
        console.log(val);
        if(val.includes('time_continue')){
            let g = val.split('&v=')[1];
            return 'https://img.youtube.com/vi/'+g+'/hqdefault.jpg';
        } else {
            let g = val.split('?v=')[1];
            return 'https://img.youtube.com/vi/'+g+'/hqdefault.jpg';
        }
    }
    function brand_act(val){
        $.get("{{URL::to('getIndex')}}/"+val,(brandactivity)=>{
            var append = '';
            brandactivity['data'].forEach((b)=>{
                var date = new Date(b.publishdate);
                var month = date.toLocaleString('en-us',{month:'short'});
                var changingdate = `${month} ${addZero(date.getDate())}, ${date.getFullYear()}`;
                append += `
                <div class="col-lg-6 col-sm-12 col-xs-12">
                    <div style="display: flex; flex-direction: row; padding: 15px;">
                        <div style="display: flex; flex: 1; border-radius: 10px; box-shadow: 0px 0px 5px 0px rgba(0,0,0,0.4); margin: 5px;">
                            <img style="display: block;
                            width: 30vw !important;
                            height: 110px !important;
                            object-fit: cover !important;" src="https://mncmediakit.com/datafile/portal/thumbnail/3/${b.cover}"/>
                        </div>
                        <div style="display: flex; flex: 3; flex-direction: column; margin: 5px; justify-content: center;">
                            <h6>${b.judul}</h6>
                            <div style="padding: 5px; border-radius: 5px; background-color: #124699; max-width: 100px; display: flex; justify-content: center; align-items: center;">
                                <span style="color: white;">${b.sub_kategori}</span>
                            </div>
                            <span>${changingdate}</span>
                        </div>
                    </div>
                </div>
                `;
            })
            $('#brand_activity').html(append);
        })
    }
    function brand_camp(val){
        $.get("{{URL::to('getIndex')}}/"+val,(brandcampaign)=>{
            var append = '';
            brandcampaign['data'].forEach((b)=>{
                var date = new Date(b.publishdate);
                var month = date.toLocaleString('en-us',{month:'short'});
                var changingdate = `${month} ${addZero(date.getDate())}, ${date.getFullYear()}`;
                append += `
                <div class="col-lg-6 col-sm-12 col-xs-12">
                    <div style="display: flex; flex-direction: row; padding: 15px;">
                        <div style="display: flex; flex: 1; border-radius: 10px; box-shadow: 0px 0px 5px 0px rgba(0,0,0,0.4); margin: 5px;">
                            <img style="display: block;
                            width: 30vw !important;
                            height: 110px !important;
                            object-fit: cover !important;" src="${transform(b.video)}"/>
                        </div>
                        <div style="display: flex; flex: 3; flex-direction: column; margin: 5px; justify-content: center;">
                            <h6>${b.judul}</h6>
                            <div style="padding: 5px; border-radius: 5px; background-color: #124699; max-width: 100px; display: flex; justify-content: center; align-items: center;">
                                <span style="color: white;">${b.type_video}</span>
                            </div>
                            <span>${changingdate}</span>
                        </div>
                    </div>
                </div>
                `;
            })
            $('#brand_campaign').html(append);
        })
    }
    function tvrate(){
        $.get("{{URL::to('tv-rating')}}",(tvr)=>{
            setTimeout(()=>{
                var append_tvr = '';
            tvr.forEach((f,v)=>{
                
                    append_tvr +=`
                        <div class="col-xs-3 animated zoomIn" style="padding: 2px;">
                            <div style="display: flex; flex-direction: row; align-items: center; margin: 2px; box-shadow: 0px 0px 5px 0px rgba(0,0,0,0.4);">
                                <div style="display: flex; background-color: #124699; width: 40px; height: 40px; border-radius: 1px; justify-content: center; align-items: center;">
                                    <span style="font-size: 0.8rem; font-weight: bold; color: white; padding: 1px;">${f.rating1}</span>
                                </div>
                                <div style="display: flex; background-color: #fff; width: 80px; height: 40px; border-radius: 0px 1px 1px 0px; justify-content: center; align-items: center; padding: 3px;">
                                    <img src="{{URL::to('img/logo/${f.name_channel}.png')}}" style="width: 45px;"/>
                                </div>
                            </div>
                        </div>`;
                
            })
            $('#tvr').html(append_tvr);
            },3000);
        })
    }
    function listoprogram(){
        $.get("{{URL::to('list_top_program')}}",(tp)=>{
            var append_tp = `<table class="table table-bordered">
                               <tr style="padding: 10px; border: 1px solid black;">
                                   <th style="text-align: center;">No</th>
                                   <th style="text-align: center;">Program</th>
                                   <th style="text-align: center;">Channel</th>
                                   <th style="text-align: center;">TVR</th>
                                   <th style="text-align: center;">TVS</th>
                               </tr>
                            <tbody>`;
            tp.allgenre.forEach((d)=>{
                append_tp += `
                <tr>
                    <td style="text-align: center;">${d.no}</td>
                    <td style="text-align: left;">${d.name}</td>
                    <td style="text-align: center;"><img src="{{URL::to('img/logo/${d.name_channel}.png')}}" style="width: 30px;"></td>
                    <td style="text-align: center;">${d.tvr}</td>
                    <td style="text-align: center;">${d.shares.toFixed(2)}</td>
                </tr>
                `;
            })
            append_tp +=`</tbody></table>`;
            $('#tp').html(append_tp);
        })
    }
    function market_share_adv(){
        $.post("{{URL::to('market_share')}}",{type: 'ADVERTISER'},(market)=>{
            var append_mkt = `<table style="width: 100%">
                               <tr style="padding: 10px; border: 1px solid black;">
                                   <th rowspan="2" style="text-align: center;">Advertiser</th>
                                   <th rowspan="2" style="text-align: center;">MTD</th>
                                   <th colspan="3" style="text-align: center;">Revenue</th>
                                   <th rowspan="2" style="text-align: center;">Action</th>
                               </tr>
                               <tr>
                                   <th style="text-align: center;">RCTI</th>
                                   <th style="text-align: center;">MNCTV</th>
                                   <th style="text-align: center;">GTV</th>
                               </tr>
                              <tbody>`;
            market.forEach((h)=>{
                let greenRCTI = parseInt(h.RCTI) > 0 ? 'rgba(3, 252, 23, 0.3)' : null;
                let greenMNC = parseInt(h.MNCTV) > 0 ? 'rgba(3, 252, 23, 0.3)' : null;
                let greenGTV = parseInt(h.GTV) > 0 ? 'rgba(3, 252, 23, 0.3)' : null;
                append_mkt += `
                <tr>
                    <td style="text-align: left; width: 240px;">${h.ADVERTISER}</td>
                    <td style="text-align: center;">${h.bulan.slice(0,3)}</td>
                    <td style="text-align: right; background-color: ${greenRCTI}">${parseInt(h.RCTI).toLocaleString()}</td>
                    <td style="text-align: right; background-color: ${greenMNC}"">${parseInt(h.MNCTV).toLocaleString()}</td>
                    <td style="text-align: right; background-color: ${greenGTV}"">${parseInt(h.GTV).toLocaleString()}</td>
                    <td style="text-align: center;"><img src="{{URL::to('img/logo/see.png')}}" style="width: 20px;"/></td>
                </tr>
                `;
            })
            append_mkt += `</tbody></table>`;
            $('#adv_market').html(append_mkt);
        })
    }
    function market_share_agcy(){
        $.post("{{URL::to('market_share')}}",{type: 'AGENCY'},(market)=>{
            var append_mkt = `<table style="width: 100%">
                               <tr style="padding: 10px; border: 1px solid black;">
                                   <th rowspan="2" style="text-align: center;">Agency</th>
                                   <th rowspan="2" style="text-align: center;">MTD</th>
                                   <th colspan="3" style="text-align: center;">Revenue</th>
                               </tr>
                               <tr>
                                   <th style="text-align: center;">RCTI</th>
                                   <th style="text-align: center;">MNCTV</th>
                                   <th style="text-align: center;">GTV</th>
                               </tr>
                              <tbody>`;
            market.forEach((h)=>{
                let greenRCTI = parseInt(h.RCTI) > 0 ? 'rgba(3, 252, 23, 0.3)' : null;
                let greenMNC = parseInt(h.MNCTV) > 0 ? 'rgba(3, 252, 23, 0.3)' : null;
                let greenGTV = parseInt(h.GTV) > 0 ? 'rgba(3, 252, 23, 0.3)' : null;
                append_mkt += `
                <tr>
                    <td style="text-align: left; width: 228px;">${h.AGENCY_PINTU}</td>
                    <td style="text-align: center;">${h.bulan.slice(0,3)}</td>
                    <td style="text-align: right; background-color: ${greenRCTI}">${parseInt(h.RCTI).toLocaleString()}</td>
                    <td style="text-align: right; background-color: ${greenMNC}"">${parseInt(h.MNCTV).toLocaleString()}</td>
                    <td style="text-align: right; background-color: ${greenGTV}"">${parseInt(h.GTV).toLocaleString()}</td>
                </tr>
                `;
            })
            append_mkt += `</tbody></table>`;
            $('#agcy_mkt').html(append_mkt);
        })
    }
</script>
@stop