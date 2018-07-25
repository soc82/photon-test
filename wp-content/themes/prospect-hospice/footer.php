			<footer>
				<div class="container">
					<p>&copy; <?php echo date("Y"); echo " "; echo bloginfo('name'); ?></p>
					<br>
				</div>
			</footer>
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
