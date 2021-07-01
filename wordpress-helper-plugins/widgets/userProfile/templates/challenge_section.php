<?php
$products_challenge_html = '';

if ( is_user_logged_in() ) {
	$user_id              = get_current_user_id();
	$WP_User              = get_userdata( $user_id );
	$username             = $WP_User->user_login;
	$userAthlete          = new \Elhelper\modules\userStravaModule\model\UserStravaAthleteModel( $user_id );
	$athleteTotalDistance = $userAthlete->getAthleteTotalDistance();
	$user_total_distance  = ! empty( $athleteTotalDistance ) ? $athleteTotalDistance * 0.001 . ' km' : '0 km';


	$list_athlete_of_challenge = [];
	//product
	$num_of_challenge       = 0;
	$num_challenge_finished = 0;

//	$products                = inspire_get_list_purchased_product_by_user_object( $WP_User );
	$challenges = \Elhelper\modules\productStravaModule\db\ChallengeDb::getAllChallenge();

	if ( ! empty( $challenges ) ) {

		$num_of_challenge = count( $challenges );
		foreach ( $challenges as $challenge ) {
			$products_challenge_html .= \Elhelper\widgets\userProfile\UserProfile::renderProductChallenge( $challenge );

		}
		$num_challenge_finished = 0;

	}
}
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
                    <div class="order-md-1 col-md-3 col-lg-2">
                        <div class="call-to-action">
                            <img class="image"
                                 src="<?php echo esc_url( plugins_url( 'assets/images/avartar.png', dirname( __FILE__ ) ) . '' ); ?>"
                                 alt="avartar">
                        </div>
                    </div>
                    <div class="order-md-3 col-md-12 col-lg-7">
                        <h2> Trần Nguyễn Thế Duy </h2>
                        <h3>Tổng km</h3>
                        <span class="distance"><?php echo isset( $user_total_distance ) ? $user_total_distance : '0 km' ?></span>
                        <div class="row mt-2">
                            <div class="col-md-4">
                                <h3>Số thử thách</h3>
                                <span class="number"><?php echo isset( $num_of_challenge ) ? $num_of_challenge : 0 ?></span>
                            </div>
                            <div class="col-md-8">
                                <h3>Đã Hoàn Thành</h3>
                                <span class="number"><?php echo isset( $num_challenge_finished ) ? $num_challenge_finished : 0 ?></span>
                            </div>
                        </div>
                    </div>
                    <div class="order-md-2 col-md-5 col-lg-3">
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
                <div class="row strava-challenges__list strava-challenges__list-slick">
					<?php echo $products_challenge_html; ?>
					<?php echo \Elhelper\widgets\userProfile\UserProfile::renderAddNewChallenge() ?>
                </div>
            </div>
        </div>
        <!-- End Challenges Section -->
        <div class="popup-modal">
            <div class="container-fluid">
                <div class="popup-modal__challenges">
                    <div class="popup-modal__challenges-item">
                        <div class="row justify-content-around">
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
                            <div class="col-md-12 col-lg-5">
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
                                        </div>
                                    </a>
                                </div>
                            </div>
							<?php
							$count ++;
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
