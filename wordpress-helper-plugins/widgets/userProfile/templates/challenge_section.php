<div class="wrap-modal-user-profile">
    <div class="overlay"></div>

    <!-- Informations section -->
    <div class="strava-information mx-3">
        <div class="container">
            <div class="row">
                <div class="col-md-12 col-lg-2">
                    <div class="call-to-action">
                        <div class="image"></div>
                    </div>
                </div>
                <div class="col-md-12 col-lg-7">
                    <h2>Trần Nguyễn Thế Duy</h2>
                    <h3>Tổng km</h3>
                    <span class="distance">1053 km</span>
                    <div class="row mt-2">
                        <div class="col-md-4">
                            <h3>Số thử thách</h3>
                            <span class="number">02</span>
                        </div>
                        <div class="col-md-8">
                            <h3>Đã Hoàn Thành</h3>
                            <span class="number">01</span>
                        </div>
                    </div>
                </div>
                <div class="col-md-12 col-lg-3">
                    <div class="button popup-strava-challenges">KẾT NỐI STRAVA 
                        <!-- <span class="logout">ngắt kết nối với Strava</span> -->
                    </div>
                    <div class="button">ĐĂNG XUẤT</div>
                </div>
            </div>
        </div>
    </div>
    <!-- End Informations section -->

    <!-- Challenges Section -->
    <div class="strava-challenges mx-3">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <h2 class="heading">Các thử thách</h2>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12 col-lg-6">
                    <div class="left-challenge">
                        <div class="row">
                            <div class="col-md-4 col-lg-3">
                                <div class="banner"></div>
                            </div>
                            <div class="col-md-8 col-lg-9">
                                <div class="content">
                                    <h2>Chinh phục Everest</h2>
                                    <span class="distance-date">85 km - 25 ngày</span>

                                    <div class="row">
                                        <div class="col-md-6">
                                            <h3>Ngày bắt đầu</h3>
                                            <span class="date">01/07/2021</span>
                                        </div>
                                        <div class="col-md-6">
                                            <h3>Ngày kết thúc</h3>
                                            <span class="date">25/07/2021</span>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-3 pr-0">
                                            <h3 class="label">Độ dài</h3>
                                            <span class="percent">40%</span>
                                        </div>
                                        <div class="col-md-9">
                                            <div class="line" data-active="4">
                                                <div class="rectangle"></div>
                                                <div class="rectangle"></div>
                                                <div class="rectangle"></div>
                                                <div class="rectangle"></div>
                                                <div class="rectangle"></div>
                                                <div class="rectangle"></div>
                                                <div class="rectangle"></div>
                                                <div class="rectangle"></div>
                                                <div class="rectangle"></div>
                                                <div class="rectangle"></div>
                                            </div>
                                            <div class="distance-left">
                                                <b>34km</b>
                                                <span>Còn lại <b>51km</b></span>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-3 pr-0">
                                            <h3 class="label">Thời gian</h3>
                                            <span class="percent">70%</span>
                                        </div>
                                        <div class="col-md-9">
                                            <div class="line" data-active="7">
                                                <div class="rectangle"></div>
                                                <div class="rectangle"></div>
                                                <div class="rectangle"></div>
                                                <div class="rectangle"></div>
                                                <div class="rectangle"></div>
                                                <div class="rectangle"></div>
                                                <div class="rectangle"></div>
                                                <div class="rectangle"></div>
                                                <div class="rectangle"></div>
                                                <div class="rectangle"></div>
                                            </div>
                                            <div class="distance-left">
                                                <b>34km</b>
                                                <span>Còn lại <b>51km</b></span>
                                            </div>
                                        </div>
                                    </div>
                                    
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-12 col-lg-6">
                    <div class="right-challenge">
                        <div class="button more-challenge">THÊM THỬ THÁCH MỚI</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- End Challenges Section -->

    <div class="popup-modal">
        <div class="container">
            <div class="popup-modal__challenges">
                <div class="popup-modal__challenges-item">
                    <div class="row justify-content-around">
                    <?php 
                        $count = 0;
                        if( $products->have_posts() ){
                            while ( $products->have_posts() ) {
                                $products->the_post(); 
                                ?>
                                    <div class="col-md-12 col-lg-5">
                                        <div class="thumb-item">
                                            <a href="<?php the_permalink(); ?>">
                                                <div class="thumb-item__image">
                                                    <?php  the_post_thumbnail( 'shop_catelog', ['class' => 'img-responsive', 'title' =>  get_the_title()] ); ?>
                                                </div>
                                                <div class="thumb-item__content">
                                                    <div class="thumb-item__heading">
                                                        <?php echo wp_kses( get_the_title(), array( 'br' => array()) ) ?>
                                                    </div>
                                                    <div class="thumb-item__distance-date">
                                                        <?php echo the_excerpt(); ?>
                                                    </div>
                                                    <div class="thumb-item__description">
                                                        <?php echo the_content(); ?>
                                                    </div>
                                                </div>
                                            </a>
                                        </div>
                                    </div>
                                <?php 
                                $count++;
                                if ( $count % 2 == 0 && $count < $products->post_count ) {
                                ?>
                                    </div>
                                </div>
                                <div class="popup-modal__challenges-item">
                                    <div class="row justify-content-around">
                                <?php } 
                            }
                        }
                        wp_reset_postdata();
                    ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- List Challenges -->
<div class="list-challenges">
    <div class="container">
        <div class="list-challenges__wrap mx-3">
            <div class="row">
                <div class="col-md-12">
                    <h2 class="heading">Danh sách nhà chinh phục</h2>
                    <span class="sub">(Xếp hạng dựa vào thời gian chinh phục)</span>
                </div>
            </div>

            <div class="row">
                <div class="col-md-12"> 
                    <h2>Chinh Phục Everest</h2>
                </div>
            </div>
            
            <div class="row">
                <div class="col-md-12">
                    <div class="table-tab">
                        <div class="table-item">
                            <table class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th scope="col">HẠNG</th>
                                        <th scope="col">TÊN NHÀ CHINH PHỤC</th>
                                        <th scope="col">TỐC ĐỘ <br>(avg Pace)</th>
                                        <th scope="col">TỔNG KM</th>
                                        <th scope="col">THỜI GIAN <br>CHINH PHỤC</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <th scope="row">01</th>
                                        <td>TRẦN NGUYỄN THẾ DUY</td>
                                        <td>07:59</td>
                                        <td>1053 KM</td>
                                        <td>05 NGÀY</td>
                                    </tr>
                                    <tr>
                                        <th scope="row">02</th>
                                        <td>TRẦN NGUYỄN THẾ DUY</td>
                                        <td>07:59</td>
                                        <td>1053 KM</td>
                                        <td>07 NGÀY</td>
                                    </tr>
                                    <tr>
                                        <th scope="row">03</th>
                                        <td>TRẦN NGUYỄN THẾ DUY</td>
                                        <td>07:59</td>
                                        <td>1053 KM</td>
                                        <td>15 NGÀY</td>
                                    </tr>
                                    <tr>
                                        <th scope="row">04</th>
                                        <td>TRẦN NGUYỄN THẾ DUY</td>
                                        <td>07:59</td>
                                        <td>1053 KM</td>
                                        <td>20 NGÀY</td>
                                    </tr>
                                    <tr>
                                        <th scope="row">05</th>
                                        <td>TRẦN NGUYỄN THẾ DUY</td>
                                        <td>07:59</td>
                                        <td>1053 KM</td>
                                        <td>10 NGÀY</td>
                                    </tr>
                                    <tr>
                                        <th scope="row"></th>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                    </tr>
                                    <tr>
                                        <th scope="row"></th>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                    </tr>
                                    <tr>
                                        <th scope="row"></th>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                    </tr>
                                    <tr>
                                        <th scope="row"></th>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                        <div class="table-item">
                            <table class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th scope="col">HẠNG</th>
                                        <th scope="col">TÊN NHÀ CHINH PHỤC</th>
                                        <th scope="col">TỐC ĐỘ <br>(avg Pace)</th>
                                        <th scope="col">TỔNG KM</th>
                                        <th scope="col">THỜI GIAN <br>CHINH PHỤC</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <th scope="row">01</th>
                                        <td>TRẦN NGUYỄN THẾ DUY</td>
                                        <td>07:59</td>
                                        <td>1053 KM</td>
                                        <td>05 NGÀY</td>
                                    </tr>
                                    <tr>
                                        <th scope="row">02</th>
                                        <td>TRẦN NGUYỄN THẾ DUY</td>
                                        <td>07:59</td>
                                        <td>1053 KM</td>
                                        <td>07 NGÀY</td>
                                    </tr>
                                    <tr>
                                        <th scope="row">03</th>
                                        <td>TRẦN NGUYỄN THẾ DUY</td>
                                        <td>07:59</td>
                                        <td>1053 KM</td>
                                        <td>15 NGÀY</td>
                                    </tr>
                                    <tr>
                                        <th scope="row">04</th>
                                        <td>TRẦN NGUYỄN THẾ DUY</td>
                                        <td>07:59</td>
                                        <td>1053 KM</td>
                                        <td>20 NGÀY</td>
                                    </tr>
                                    <tr>
                                        <th scope="row">05</th>
                                        <td>TRẦN NGUYỄN THẾ DUY</td>
                                        <td>07:59</td>
                                        <td>1053 KM</td>
                                        <td>10 NGÀY</td>
                                    </tr>
                                    <tr>
                                        <th scope="row"></th>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                    </tr>
                                    <tr>
                                        <th scope="row"></th>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                    </tr>
                                    <tr>
                                        <th scope="row"></th>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                    </tr>
                                    <tr>
                                        <th scope="row"></th>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- End List Challenges -->