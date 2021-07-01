<?php
$products_challenge_html       = '';
$render_list_challenges_report = '';

if ( is_user_logged_in() ) {
	$user_id     = get_current_user_id();
	$WP_User     = get_userdata( $user_id );
	$user_avatar = get_avatar( $user_id );


	$username             = $WP_User->user_login;
	$userAthlete          = new \Elhelper\modules\userStravaModule\model\UserStravaAthleteModel( $user_id );
	$athleteTotalDistance = $userAthlete->getAthleteTotalDistance();
	$user_total_distance  = ! empty( $athleteTotalDistance ) ? $athleteTotalDistance * 0.001 . ' km' : '0 km';


	//product
	$num_of_challenge       = 0;
	$num_challenge_finished = 0;

//	$products                = inspire_get_list_purchased_product_by_user_object( $WP_User );
	$challenges = \Elhelper\modules\productStravaModule\db\ChallengeDb::getAllChallengeOfUser( $user_id );


	if ( ! empty( $challenges ) ) {
		//num of challenge
		$num_of_challenge       = count( $challenges );
		$num_challenge_finished = 0;

		foreach ( $challenges as $challenge ) {
			\Elhelper\modules\productStravaModule\model\ChallengeModel::getListFinisherInfo( $challenge->product_id );

//			$challengeModel          = new \Elhelper\modules\productStravaModule\model\ChallengeModel( $challenge );
//			echo '<pre>';
//			print_r($challengeModel->checkIfCanFinishChallenge());
//			echo '</pre>';
//			die;
			$products_challenge_html .= \Elhelper\widgets\userProfile\UserProfile::renderProductChallenge( $challenge );
			if ( $challenge->status == 1 ) {
				$num_challenge_finished ++;
			}
		}

		//render list challenge report
		$render_list_challenges_report = \Elhelper\widgets\userProfile\UserProfile::renderListChallengeReport( $challenges );

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
                    <div class="order-md-1 col-sm-12 col-md-3 order-lg-1 col-lg-2">
                        <div class="call-to-action">
							<?php echo $user_avatar ?>
                        </div>
                    </div>
                    <div class="order-md-3 col-sm-12 col-md-12 order-lg-2 col-lg-7">
                        <h2><?php echo $WP_User->user_nicename ?></h2>
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
                        <?php echo $button_conntect_strava ?>
                        
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
					<?php echo $products_challenge_html; ?>
					<?php echo \Elhelper\widgets\userProfile\UserProfile::renderAddNewChallenge() ?>
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
						if ( $products->have_posts() ) {
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
													<?php echo esc_html_e( 'Tìm Hiểu Thêm', 'elhelper' ); ?>
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
	<?php echo $render_list_challenges_report ?>
    <!-- End List Challenges -->
</div>
