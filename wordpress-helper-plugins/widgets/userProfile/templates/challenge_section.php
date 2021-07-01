<?php
// if ( is_user_logged_in() ) {
// 	$user_id                   = get_current_user_id();
// 	$WP_User                   = get_userdata( $user_id );
// 	$username                  = $WP_User->user_login;
// 	$userAthlete               = new \Elhelper\modules\userStravaModule\model\UserStravaAthleteModel( $user_id );
// 	$athleteTotalDistance      = $userAthlete->getAthleteTotalDistance();
// 	$athleteTotalDistance      *= 0.001;
// 	$user_total_distance       = ! empty( $athleteTotalDistance ) ? $athleteTotalDistance . ' km' : '0 km';
// 	$products                  = inspire_get_list_purchased_product_by_user_object( $WP_User );
// 	$num_of_challenge          = ! empty( $products ) ? count( $products ) : 0;
// 	$num_challenge_finished    = 0;
// 	$list_athlete_of_challenge = [];
// 	if ( ! empty( $products ) ) {
// 		$distanceOfProduct = $userAthlete->getDistanceOfProduct( $products[0] );
// 		$distanceOfProduct *= 0.001;
// 	}
// }
$str                    = __DIR__ . '/conntect_strava_btn.php';
$button_conntect_strava = require $str;

?>
<div class="conatiner">
    <div class="wrap-modal-user-profile">
        <div class="overlay"></div>

        <!-- Informations section -->
        <div class="strava-information mx-3">
            <div class="container-fluid">
                <div class="row justify-content-md-between">
                    <div class="order-md-1 col-sm-12 col-md-3 order-lg-1 col-lg-2">
                        <div class="call-to-action">
                            <img class="image" src="<?php echo esc_url( plugins_url( 'assets/images/avartar.png', dirname( __FILE__ )  ) . ''); ?>" alt="avartar">
                        </div>
                    </div>
                    <div class="order-md-3 col-sm-12 col-md-12 order-lg-2 col-lg-7">
                        <h2> Trần Nguyễn Thế Duy </h2>
                            <div class="d-flex align-items-end d-lg-block">
                                <h3>TỔNG TÍCH LŨY</h3>
                                <span class="distance"><?php echo isset( $user_total_distance ) ? $user_total_distance : '0 km' ?></span>
                            </div>
                        <div class="row mt-2">
                            <div class="col-md-4">
                                <div class="d-flex align-items-end d-lg-block">
                                    <h3>SỐ THỬ THÁCH</h3>
                                    <span class="number"><?php echo isset( $num_of_challenge ) ? $num_of_challenge : 0 ?></span>
                                </div>
                            </div>
                            <div class="col-md-8">
                                <div class="d-flex align-items-end d-lg-block">
                                    <h3>ĐÃ HOÀN THÀNH</h3>
                                    <span class="number"><?php echo isset( $num_challenge_finished ) ? $num_challenge_finished : 0 ?></span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="order-md-2 col-sm-12 col-md-5 order-lg-3 col-lg-3">
                        <!--<div class="button popup-strava-challenges">KẾT NỐI STRAVA
							 <span class="logout">ngắt kết nối với Strava</span>
						</div>-->
						<?php echo $button_conntect_strava ?>

                        <div class="button">ĐĂNG XUẤT</div>
                    </div>
                </div>
            </div>
        </div>
        <!-- End Informations section -->

        <!-- Challenges Section -->
        <div class="strava-challenges mx-3">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-md-12">
                        <h2 class="heading">Các thử thách</h2>
                    </div>
                </div>
                <div class="strava-challenges__list strava-challenges__list-slick">
                    <div class="strava-challenges__item">
                        <div class="strava-challenges__inner">
                            <?php // if ( ! empty( $products ) ): ?>
                            <div class="row">
                                <div class="col-md-12 col-lg-3">
                                    <!-- banner -->
                                    <div class="strava-challenges__head">
                                        <div class="strava-challenges__banner">
                                            <img src="<?php echo esc_url( plugins_url( 'assets/images/mountain.png', dirname( __FILE__ ) ) ); ?>" alt="banner">
                                        </div>
                                        <div class="strava-challenges__head-info">
                                            <h2 class="d-block d-lg-none">Chinh phục Everest</h2>
                                            <span class="distance-date d-block d-lg-none">85 km - 25 ngày</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-12 col-lg-9">
                                    <div class="strava-challenges__content">
                                        <h2 class="d-none d-lg-block">
                                            <a href="#">
                                                Chinh phục Everest
                                            </a>
                                        </h2>
                                        <span class="distance-date d-none d-lg-block">85 km - 25 ngày</span>

                                        <div class="row">
                                            <div class="col-6">
                                                <h3>Ngày bắt đầu</h3>
                                                <span class="date">01/07/2021</span>
                                            </div>
                                            <div class="col-6">
                                                <h3>Ngày kết thúc</h3>
                                                <span class="date">25/07/2021</span>
                                            </div>
                                        </div>

                                        <div class="row align-items-end align-items-lg-center">
                                            <div class="col-3 pr-0">
                                                <h3 class="label">Độ dài</h3>
                                                <span class="percent">0%</span>
                                            </div>
                                            <div class="col-9">
                                                <div class="line" data-active="0">
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
                                                <div class="d-none d-lg-block distance-left">
                                                    <b><?php echo isset( $distanceOfProduct ) && ! empty( $distanceOfProduct ) ? $distanceOfProduct . 'km' : '0 km' ?></b>
                                                    <span>Còn lại <b>51km</b></span>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row align-items-end align-items-lg-center">
                                            <div class="col-3 pr-0">
                                                <h3 class="label">Thời gian</h3>
                                                <span class="percent">70%</span>
                                            </div>
                                            <div class="col-9">
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
                                                <div class="d-none d-lg-block distance-left">
                                                    <b>34 ngày</b>
                                                    <span>Còn lại <b>51 ngày</b></span>
                                                </div>
                                            </div>
                                        </div>

                                    </div>
                                </div>
                            </div>
                            <?php // endif; ?>

                            <div class="strava-challenges__status">
                                <div class="strava-challenges__status-image">
                                    <span>Đã hoàn thành</span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="strava-challenges__item">
                        <div class="strava-challenges__inner">
                            <?php // if ( ! empty( $products ) ): ?>
                            <div class="row">
                                <div class="col-md-12 col-lg-3">
                                    <!-- banner -->
                                    <div class="strava-challenges__head">
                                        <div class="strava-challenges__banner">
                                            <img src="<?php echo esc_url( plugins_url( 'assets/images/mountain.png', dirname( __FILE__ ) ) ); ?>" alt="banner">
                                        </div>
                                        <div class="strava-challenges__head-info">
                                            <h2 class="d-block d-lg-none">Chinh phục Everest</h2>
                                            <span class="distance-date d-block d-lg-none">85 km - 25 ngày</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-12 col-lg-9">
                                    <div class="strava-challenges__content">
                                        <h2 class="d-none d-lg-block">
                                            <a href="#">
                                                Chinh phục Everest
                                            </a>
                                        </h2>
                                        <span class="distance-date d-none d-lg-block">85 km - 25 ngày</span>

                                        <div class="row">
                                            <div class="col-6">
                                                <h3>Ngày bắt đầu</h3>
                                                <span class="date">01/07/2021</span>
                                            </div>
                                            <div class="col-6">
                                                <h3>Ngày kết thúc</h3>
                                                <span class="date">25/07/2021</span>
                                            </div>
                                        </div>

                                        <div class="row align-items-end align-items-lg-center">
                                            <div class="col-3 pr-0">
                                                <h3 class="label">Độ dài</h3>
                                                <span class="percent">0%</span>
                                            </div>
                                            <div class="col-9">
                                                <div class="line" data-active="0">
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
                                                <div class="d-none d-lg-block distance-left">
                                                    <b><?php echo isset( $distanceOfProduct ) && ! empty( $distanceOfProduct ) ? $distanceOfProduct . 'km' : '0 km' ?></b>
                                                    <span>Còn lại <b>51km</b></span>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row align-items-end align-items-lg-center">
                                            <div class="col-3 pr-0">
                                                <h3 class="label">Thời gian</h3>
                                                <span class="percent">70%</span>
                                            </div>
                                            <div class="col-9">
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
                                                <div class="d-none d-lg-block distance-left">
                                                    <b>34 ngày</b>
                                                    <span>Còn lại <b>51 ngày</b></span>
                                                </div>
                                            </div>
                                        </div>

                                    </div>
                                </div>
                            </div>
                            <?php // endif; ?>
                        </div>
                    </div>
                    <div class="strava-challenges__item">
                        <div class="strava-challenges__inner">
                            <div class="strava-challenges__wrap-image">
                                <div class="button more-challenge">THÊM THỬ THÁCH MỚI</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- End Challenges Section -->

        <div class="popup-modal">
            <div class="container-fluid">
                <div class="popup-modal__challenges" id="popup-modal-challenges">
                    <div class="popup-modal__challenges-list">
                        <?php
                        if ( class_exists( 'WooCommerce' ) ) {
                            $args = array(
                                'post_type'           => 'product'
                            ,
                                'post_status'         => 'publish'
                            ,
                                'ignore_sticky_posts' => 1
                            ,
                                'posts_per_page'      => 4
                            ,
                                'orderby'             => 'date'
                            ,
                                'order'               => 'desc'
                            );

                            $products = new \WP_Query( $args );
                        }
                        $count = 0;
                        if ( $products->have_posts() ){
                            while ( $products->have_posts() ) {
                            $products->the_post();
                            ?>
                                <div class="thumb-item">
                                    <a href="<?php the_permalink(); ?>">
                                        <div class="thumb-item__image">
                                            <?php the_post_thumbnail( 'shop_catelog', [
                                                'class' => 'img-responsive',
                                                'title' => get_the_title()
                                            ] ); ?>
                                        </div>
                                        <div class="thumb-item__content">
                                            <div class="thumb-item__heading">
                                                <?php echo wp_kses( get_the_title(), array( 'br' => array() ) ) ?>
                                            </div>
                                            <div class="thumb-item__distance-date">
                                                <?php echo the_excerpt(); ?>
                                            </div>
                                            <div class="thumb-item__description">
                                                <?php echo the_content(); ?>
                                            </div>
                                            <div class="thumb-item__button-wrap">
                                                <div class="thumb-item__button">
                                                    <?php echo esc_html_e('Tìm Hiểu Thêm', 'elhelper'); ?>
                                                </div>
                                            </div>
                                        </div>
                                    </a>
                                </div>
                            <?php
                            $count ++;
                            }
                        }
                        wp_reset_postdata();
                        ?>
                    </div>
                </div>
            </div>
        </div>


    </div>

    <!-- List Challenges -->
    <div class="list-challenges">
        <div class="container-fluid">
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
</div>
