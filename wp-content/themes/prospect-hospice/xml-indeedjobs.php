<?php

query_posts(['post_type' => 'jobs', 'posts_per_page' => -1 ]);

header('Content-Type: ' . feed_content_type('rss-http') . '; charset=' . get_option('blog_charset'), true);
$more = 1;
echo '<?xml version="1.0" encoding="'.get_option('blog_charset').'"?'.'>'; ?>
<rss version="0.92">
	<source>
		<publisher><?php wp_title_rss(); ?></publisher>
		<publisherurl><?php bloginfo_rss('url') ?></publisherurl>
		<lastBuildDate><?php
			$date = get_lastpostmodified( 'GMT' );
			echo $date ? mysql2date( 'D, d M Y H:i:s +0000', $date ) : date( 'D, d M Y H:i:s +0000' );
			?></lastBuildDate>


		<?php while (have_posts()) : the_post(); ?>
			<?php $terms = get_the_terms( get_the_ID() , 'jobtype' ); ?>
			<job>
				<title><?php the_title_rss() ?></title>
				<date><?php the_date('D, d M Y H:i:s +0000') ?></date>
				<referencenumber><![CDATA[<?php the_field('reference') ?>]]></referencenumber>
				<url><?php the_permalink_rss() ?></url>
				<company><![CDATA[Prospect Hospice]]></company>
				<city><![CDATA[Swindon]]></city>
				<country><![CDATA[UK]]></country>
				<postalcode><![CDATA[SN4 9BY]]></postalcode>
				<description><![CDATA[<?php the_content_feed() ?>]]></description>
				<salary><![CDATA[<?php the_field('salary') ?>]]></salary>
				<category><![CDATA[<?php echo implode(',', array_map(function ($e) { return $e->name; }, $terms)); ?>]]></category>
				<?php if (false): ?>
					<education><![CDATA[Bachelors]]></education>
					<jobtype><![CDATA[fulltime, parttime]]></jobtype>
					<experience><![CDATA[5+ years]]></experience>
				<?php endif; ?>

			</job>
		<?php endwhile; ?>
	</source>
</rss>
