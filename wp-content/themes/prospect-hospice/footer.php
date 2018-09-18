<?php
$footer_logo = get_field('footer_logo', 'options');
$social_heading = get_field('footer_social_heading', 'options');
$username = get_field('username', 'options');
$hashtag = get_field('hashtag', 'options');
$corp_content = get_field('footer_corporate_content', 'options');
$acred = get_field('footer_accreditations', 'options');
$disclaimer = get_field('footer_disclaimer', 'options');
$facebook_url = get_field('facebook_url', 'options');
$twitter_username = get_field('config_twitter_username', 'options');
$linkedin_url = get_field('linkedin_url', 'options');
$instagram_url = get_field('instagram_url', 'options');
$email = get_field('config_primary_email', 'options');
$tel = get_field('config_telephone_number', 'options');
?>
			<footer class="site-footer">
				<div class="container">
					<div class="row">
						<div class="col-12 col-md-3">
							<?php if($footer_logo) echo '<a href="' . home_url() . '" class="footer-logo"><img src="' . $footer_logo['sizes']['medium'] . '" class="img-fluid" alt="Prospect Hospice" /></a>'; ?>
							<?php if($social_heading) echo '<h6 class="footer-heading">' . $social_heading . '</h6>'; ?>
							<?php if($username['username_text'] || $username['username_link']):
									echo '<p class="footer-username">';
									if($username['username_link']) echo '<a href="' . $username['username_link'] . '" target="_blank" >';
										if($username['username_text']) echo $username['username_text'];
									if($username['username_link']) echo '</a>';
									echo '</p>';
							 endif; ?>
							<?php
							if($facebook_url || $twitter_username || $linkedin_url || $instagram_url):
								echo '<ul class="footer-social">';
									if($facebook_url) echo '<li><a href="' . $facebook_url . '" target="_blank"><img src="' . get_stylesheet_directory_uri() . '/img/facebook.png" alt="Facebook" /></a></li>';
									if($twitter_username) echo '<li><a href="https://twitter.com/' . $twitter_username . '" target="_blank"><img src="' . get_stylesheet_directory_uri() . '/img/twitter.png" alt="Twitter" /></a></li>';
									if($instagram_url) echo '<li><a href="' . $instagram_url . '" target="_blank"><img src="' . get_stylesheet_directory_uri() . '/img/instagram.png" alt="Instagram" /></a></li>';
									if($linkedin_url) echo '<li><a href="' . $linkedin_url . '" target="_blank"><img src="' . get_stylesheet_directory_uri() . '/img/linkedin.png" alt="Linkedin" /></a></li>';
								echo '</ul>';
							endif; ?>
							<?php if($hashtag['hashtag_text'] && $hashtag['hashtag_link']) echo '<a href="' . $hashtag['hashtag_link'] . '" class="footer-hashtag" target="_blank">' . $hashtag['hashtag_text'] . '</a>'; ?>

						</div>
						<div class="col-12 col-md-3">
							<h6 class="footer-heading">Useful Links</h6>
							<?php wp_nav_menu(array(
								'container_class' => false,
								'theme_location'	=> 'footer-navigation',
								'menu_class' => 'footer-menu',
							));?>
						</div>
						<div class="col-12 col-md-6">
							<?php if($corp_content):
								echo '<p class="footer-corporate">' . $corp_content . '</p>';
							endif; ?>
							<?php
							if(is_array($acred) && array_filter($acred)):
								echo '<div class="footer-accreditations-section">';
									if($acred['heading']) echo '<h6 class="footer-heading">' . $acred['heading'] . '</h6>';
									if($acred['content']) echo '<p>' . $acred['content'] . '</p>';
									if($acred['logos']):
										echo '<div class="footer-accreditions-logos">';
											foreach($acred['logos'] as $logo):
												echo '<img src="' . $logo['logo']['sizes']['medium'] . '" alt="' . $logo['logo']['alt'] . '" class="img-fluid" />';
											endforeach;
										echo '</div>';
									endif;
								echo '</div>';
							endif; ?>
						</div>
					</div>
				</div>
			</footer>
			<div class="copyright-footer">
				<div class="container">
					<div class="row">
						<div class="col-12 col-md-10">
							<div class="footer-copyright">
								<div class="copyright">Copyright Prospect Hospice <?php echo date("Y"); ?> &nbsp;</div>
								<div class="email"><?php if($email) echo 'Email: <a href="MAILTO:' . $email . '">' . $email .'</a> &nbsp;'; ?></div>
								<div class="tel"><?php if($tel) echo 'Tel: <a href="TEL:' . str_replace(" ", '', $tel) . '">' . $tel .'</a>'; ?></div>
							</div>
							<?php if($disclaimer) echo '<p class="footer-disclaimer">' . $disclaimer . '<br />Website designed & built by <a href="https://bosonweb.net" title="Boson Web" target="_blank">Boson Web</a></p>'; ?>
						</div>
						<div class="col-12 col-md-2">
							<ul class="footer-accessibility">
							 <li class="accessibility-small"><a href="#">A</a></li>
							 <li class="accessibility-normal"><a href="#">A</a></li>
							 <li class="accessibility-large"><a href="#">A</a></li>
							</ul>
						</div>
					</div>
				</div>
			</div>
			<?php wp_footer(); ?>
		</div><!-- /scroller-inner -->
	</div><!-- /scroller -->
	<?php if(prospect_get_donate_page_ID()): ?>
		<div class="static-donate">
			<a href="<?php echo get_permalink(prospect_get_donate_page_ID()); ?>"><i class="far fa-heart"></i> Donate</a>
		</div>
	<?php endif; ?>
</div><!-- /pusher -->

</body>
</html>
