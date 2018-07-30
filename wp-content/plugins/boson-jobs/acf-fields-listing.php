<?php
if( function_exists('acf_add_local_field_group') ):

acf_add_local_field_group(array(
	'key' => 'group_5b5f0cff39264',
	'title' => 'Jobs listing',
	'fields' => array(
		array(
			'key' => 'field_5b5f0d12be687',
			'label' => 'Hero Banner Image',
			'name' => 'hero_banner_image',
			'type' => 'image',
			'instructions' => '',
			'required' => 0,
			'conditional_logic' => 0,
			'wrapper' => array(
				'width' => '',
				'class' => '',
				'id' => '',
			),
			'return_format' => 'url',
			'preview_size' => 'thumbnail',
			'library' => 'all',
			'min_width' => '',
			'min_height' => '',
			'min_size' => '',
			'max_width' => '',
			'max_height' => '',
			'max_size' => '',
			'mime_types' => '',
		),
		array(
			'key' => 'field_5b5f0d5864f37',
			'label' => 'Hero Banner Heading',
			'name' => 'hero_banner_heading',
			'type' => 'text',
			'instructions' => '',
			'required' => 0,
			'conditional_logic' => 0,
			'wrapper' => array(
				'width' => '',
				'class' => '',
				'id' => '',
			),
			'default_value' => '',
			'placeholder' => '',
			'prepend' => '',
			'append' => '',
			'maxlength' => '',
		),
		array(
			'key' => 'field_5b5f0d6064f38',
			'label' => 'Hero Banner Second Heading',
			'name' => 'hero_banner_second_heading',
			'type' => 'textarea',
			'instructions' => '',
			'required' => 0,
			'conditional_logic' => 0,
			'wrapper' => array(
				'width' => '',
				'class' => '',
				'id' => '',
			),
			'default_value' => '',
			'placeholder' => '',
			'maxlength' => '',
			'rows' => '',
			'new_lines' => '',
		),
		array(
			'key' => 'field_5b5f0fe8391b5',
			'label' => 'Intro heading',
			'name' => 'intro_heading',
			'type' => 'text',
			'instructions' => '',
			'required' => 0,
			'conditional_logic' => 0,
			'wrapper' => array(
				'width' => '',
				'class' => '',
				'id' => '',
			),
			'default_value' => '',
			'placeholder' => '',
			'prepend' => '',
			'append' => '',
			'maxlength' => '',
		),
		array(
			'key' => 'field_5b5f0ff7391b6',
			'label' => 'Intro Text',
			'name' => 'intro_text',
			'type' => 'textarea',
			'instructions' => '',
			'required' => 0,
			'conditional_logic' => 0,
			'wrapper' => array(
				'width' => '',
				'class' => '',
				'id' => '',
			),
			'default_value' => '',
			'placeholder' => '',
			'maxlength' => '',
			'rows' => '',
			'new_lines' => '',
		),
		array(
			'key' => 'field_5b5f0d87c974f',
			'label' => 'Benefits Section Heading',
			'name' => 'benefits_section_heading',
			'type' => 'text',
			'instructions' => '',
			'required' => 0,
			'conditional_logic' => 0,
			'wrapper' => array(
				'width' => '',
				'class' => '',
				'id' => '',
			),
			'default_value' => '',
			'placeholder' => '',
			'prepend' => '',
			'append' => '',
			'maxlength' => '',
		),
		array(
			'key' => 'field_5b5f0d91c9750',
			'label' => 'Benefits Section Items',
			'name' => 'benefits_section_items',
			'type' => 'repeater',
			'instructions' => '',
			'required' => 0,
			'conditional_logic' => 0,
			'wrapper' => array(
				'width' => '',
				'class' => '',
				'id' => '',
			),
			'collapsed' => '',
			'min' => 0,
			'max' => 0,
			'layout' => 'table',
			'button_label' => '',
			'sub_fields' => array(
				array(
					'key' => 'field_5b5f0d9fc9751',
					'label' => 'Icon',
					'name' => 'icon',
					'type' => 'font-awesome',
					'instructions' => '',
					'required' => 0,
					'conditional_logic' => 0,
					'wrapper' => array(
						'width' => '',
						'class' => '',
						'id' => '',
					),
					'default_value' => 'fa-check',
					'save_format' => 'element',
					'allow_null' => 0,
					'show_preview' => 1,
					'enqueue_fa' => 0,
					'fa_live_preview' => '',
					'choices' => array(
						'' => '',
						'fa-500px' => '&#xf26e; 500px',
						'fa-address-book' => '&#xf2b9; address-book',
						'fa-address-book-o' => '&#xf2ba; address-book-o',
						'fa-address-card' => '&#xf2bb; address-card',
						'fa-address-card-o' => '&#xf2bc; address-card-o',
						'fa-adjust' => '&#xf042; adjust',
						'fa-adn' => '&#xf170; adn',
						'fa-align-center' => '&#xf037; align-center',
						'fa-align-justify' => '&#xf039; align-justify',
						'fa-align-left' => '&#xf036; align-left',
						'fa-align-right' => '&#xf038; align-right',
						'fa-amazon' => '&#xf270; amazon',
						'fa-ambulance' => '&#xf0f9; ambulance',
						'fa-american-sign-language-interpreting' => '&#xf2a3; american-sign-language-interpreting',
						'fa-anchor' => '&#xf13d; anchor',
						'fa-android' => '&#xf17b; android',
						'fa-angellist' => '&#xf209; angellist',
						'fa-angle-double-down' => '&#xf103; angle-double-down',
						'fa-angle-double-left' => '&#xf100; angle-double-left',
						'fa-angle-double-right' => '&#xf101; angle-double-right',
						'fa-angle-double-up' => '&#xf102; angle-double-up',
						'fa-angle-down' => '&#xf107; angle-down',
						'fa-angle-left' => '&#xf104; angle-left',
						'fa-angle-right' => '&#xf105; angle-right',
						'fa-angle-up' => '&#xf106; angle-up',
						'fa-apple' => '&#xf179; apple',
						'fa-archive' => '&#xf187; archive',
						'fa-area-chart' => '&#xf1fe; area-chart',
						'fa-arrow-circle-down' => '&#xf0ab; arrow-circle-down',
						'fa-arrow-circle-left' => '&#xf0a8; arrow-circle-left',
						'fa-arrow-circle-o-down' => '&#xf01a; arrow-circle-o-down',
						'fa-arrow-circle-o-left' => '&#xf190; arrow-circle-o-left',
						'fa-arrow-circle-o-right' => '&#xf18e; arrow-circle-o-right',
						'fa-arrow-circle-o-up' => '&#xf01b; arrow-circle-o-up',
						'fa-arrow-circle-right' => '&#xf0a9; arrow-circle-right',
						'fa-arrow-circle-up' => '&#xf0aa; arrow-circle-up',
						'fa-arrow-down' => '&#xf063; arrow-down',
						'fa-arrow-left' => '&#xf060; arrow-left',
						'fa-arrow-right' => '&#xf061; arrow-right',
						'fa-arrow-up' => '&#xf062; arrow-up',
						'fa-arrows' => '&#xf047; arrows',
						'fa-arrows-alt' => '&#xf0b2; arrows-alt',
						'fa-arrows-h' => '&#xf07e; arrows-h',
						'fa-arrows-v' => '&#xf07d; arrows-v',
						'fa-assistive-listening-systems' => '&#xf2a2; assistive-listening-systems',
						'fa-asterisk' => '&#xf069; asterisk',
						'fa-at' => '&#xf1fa; at',
						'fa-audio-description' => '&#xf29e; audio-description',
						'fa-backward' => '&#xf04a; backward',
						'fa-balance-scale' => '&#xf24e; balance-scale',
						'fa-ban' => '&#xf05e; ban',
						'fa-bandcamp' => '&#xf2d5; bandcamp',
						'fa-bar-chart' => '&#xf080; bar-chart',
						'fa-barcode' => '&#xf02a; barcode',
						'fa-bars' => '&#xf0c9; bars',
						'fa-bath' => '&#xf2cd; bath',
						'fa-battery-empty' => '&#xf244; battery-empty',
						'fa-battery-full' => '&#xf240; battery-full',
						'fa-battery-half' => '&#xf242; battery-half',
						'fa-battery-quarter' => '&#xf243; battery-quarter',
						'fa-battery-three-quarters' => '&#xf241; battery-three-quarters',
						'fa-bed' => '&#xf236; bed',
						'fa-beer' => '&#xf0fc; beer',
						'fa-behance' => '&#xf1b4; behance',
						'fa-behance-square' => '&#xf1b5; behance-square',
						'fa-bell' => '&#xf0f3; bell',
						'fa-bell-o' => '&#xf0a2; bell-o',
						'fa-bell-slash' => '&#xf1f6; bell-slash',
						'fa-bell-slash-o' => '&#xf1f7; bell-slash-o',
						'fa-bicycle' => '&#xf206; bicycle',
						'fa-binoculars' => '&#xf1e5; binoculars',
						'fa-birthday-cake' => '&#xf1fd; birthday-cake',
						'fa-bitbucket' => '&#xf171; bitbucket',
						'fa-bitbucket-square' => '&#xf172; bitbucket-square',
						'fa-black-tie' => '&#xf27e; black-tie',
						'fa-blind' => '&#xf29d; blind',
						'fa-bluetooth' => '&#xf293; bluetooth',
						'fa-bluetooth-b' => '&#xf294; bluetooth-b',
						'fa-bold' => '&#xf032; bold',
						'fa-bolt' => '&#xf0e7; bolt',
						'fa-bomb' => '&#xf1e2; bomb',
						'fa-book' => '&#xf02d; book',
						'fa-bookmark' => '&#xf02e; bookmark',
						'fa-bookmark-o' => '&#xf097; bookmark-o',
						'fa-braille' => '&#xf2a1; braille',
						'fa-briefcase' => '&#xf0b1; briefcase',
						'fa-btc' => '&#xf15a; btc',
						'fa-bug' => '&#xf188; bug',
						'fa-building' => '&#xf1ad; building',
						'fa-building-o' => '&#xf0f7; building-o',
						'fa-bullhorn' => '&#xf0a1; bullhorn',
						'fa-bullseye' => '&#xf140; bullseye',
						'fa-bus' => '&#xf207; bus',
						'fa-buysellads' => '&#xf20d; buysellads',
						'fa-calculator' => '&#xf1ec; calculator',
						'fa-calendar' => '&#xf073; calendar',
						'fa-calendar-check-o' => '&#xf274; calendar-check-o',
						'fa-calendar-minus-o' => '&#xf272; calendar-minus-o',
						'fa-calendar-o' => '&#xf133; calendar-o',
						'fa-calendar-plus-o' => '&#xf271; calendar-plus-o',
						'fa-calendar-times-o' => '&#xf273; calendar-times-o',
						'fa-camera' => '&#xf030; camera',
						'fa-camera-retro' => '&#xf083; camera-retro',
						'fa-car' => '&#xf1b9; car',
						'fa-caret-down' => '&#xf0d7; caret-down',
						'fa-caret-left' => '&#xf0d9; caret-left',
						'fa-caret-right' => '&#xf0da; caret-right',
						'fa-caret-square-o-down' => '&#xf150; caret-square-o-down',
						'fa-caret-square-o-left' => '&#xf191; caret-square-o-left',
						'fa-caret-square-o-right' => '&#xf152; caret-square-o-right',
						'fa-caret-square-o-up' => '&#xf151; caret-square-o-up',
						'fa-caret-up' => '&#xf0d8; caret-up',
						'fa-cart-arrow-down' => '&#xf218; cart-arrow-down',
						'fa-cart-plus' => '&#xf217; cart-plus',
						'fa-cc' => '&#xf20a; cc',
						'fa-cc-amex' => '&#xf1f3; cc-amex',
						'fa-cc-diners-club' => '&#xf24c; cc-diners-club',
						'fa-cc-discover' => '&#xf1f2; cc-discover',
						'fa-cc-jcb' => '&#xf24b; cc-jcb',
						'fa-cc-mastercard' => '&#xf1f1; cc-mastercard',
						'fa-cc-paypal' => '&#xf1f4; cc-paypal',
						'fa-cc-stripe' => '&#xf1f5; cc-stripe',
						'fa-cc-visa' => '&#xf1f0; cc-visa',
						'fa-certificate' => '&#xf0a3; certificate',
						'fa-chain-broken' => '&#xf127; chain-broken',
						'fa-check' => '&#xf00c; check',
						'fa-check-circle' => '&#xf058; check-circle',
						'fa-check-circle-o' => '&#xf05d; check-circle-o',
						'fa-check-square' => '&#xf14a; check-square',
						'fa-check-square-o' => '&#xf046; check-square-o',
						'fa-chevron-circle-down' => '&#xf13a; chevron-circle-down',
						'fa-chevron-circle-left' => '&#xf137; chevron-circle-left',
						'fa-chevron-circle-right' => '&#xf138; chevron-circle-right',
						'fa-chevron-circle-up' => '&#xf139; chevron-circle-up',
						'fa-chevron-down' => '&#xf078; chevron-down',
						'fa-chevron-left' => '&#xf053; chevron-left',
						'fa-chevron-right' => '&#xf054; chevron-right',
						'fa-chevron-up' => '&#xf077; chevron-up',
						'fa-child' => '&#xf1ae; child',
						'fa-chrome' => '&#xf268; chrome',
						'fa-circle' => '&#xf111; circle',
						'fa-circle-o' => '&#xf10c; circle-o',
						'fa-circle-o-notch' => '&#xf1ce; circle-o-notch',
						'fa-circle-thin' => '&#xf1db; circle-thin',
						'fa-clipboard' => '&#xf0ea; clipboard',
						'fa-clock-o' => '&#xf017; clock-o',
						'fa-clone' => '&#xf24d; clone',
						'fa-cloud' => '&#xf0c2; cloud',
						'fa-cloud-download' => '&#xf0ed; cloud-download',
						'fa-cloud-upload' => '&#xf0ee; cloud-upload',
						'fa-code' => '&#xf121; code',
						'fa-code-fork' => '&#xf126; code-fork',
						'fa-codepen' => '&#xf1cb; codepen',
						'fa-codiepie' => '&#xf284; codiepie',
						'fa-coffee' => '&#xf0f4; coffee',
						'fa-cog' => '&#xf013; cog',
						'fa-cogs' => '&#xf085; cogs',
						'fa-columns' => '&#xf0db; columns',
						'fa-comment' => '&#xf075; comment',
						'fa-comment-o' => '&#xf0e5; comment-o',
						'fa-commenting' => '&#xf27a; commenting',
						'fa-commenting-o' => '&#xf27b; commenting-o',
						'fa-comments' => '&#xf086; comments',
						'fa-comments-o' => '&#xf0e6; comments-o',
						'fa-compass' => '&#xf14e; compass',
						'fa-compress' => '&#xf066; compress',
						'fa-connectdevelop' => '&#xf20e; connectdevelop',
						'fa-contao' => '&#xf26d; contao',
						'fa-copyright' => '&#xf1f9; copyright',
						'fa-creative-commons' => '&#xf25e; creative-commons',
						'fa-credit-card' => '&#xf09d; credit-card',
						'fa-credit-card-alt' => '&#xf283; credit-card-alt',
						'fa-crop' => '&#xf125; crop',
						'fa-crosshairs' => '&#xf05b; crosshairs',
						'fa-css3' => '&#xf13c; css3',
						'fa-cube' => '&#xf1b2; cube',
						'fa-cubes' => '&#xf1b3; cubes',
						'fa-cutlery' => '&#xf0f5; cutlery',
						'fa-dashcube' => '&#xf210; dashcube',
						'fa-database' => '&#xf1c0; database',
						'fa-deaf' => '&#xf2a4; deaf',
						'fa-delicious' => '&#xf1a5; delicious',
						'fa-desktop' => '&#xf108; desktop',
						'fa-deviantart' => '&#xf1bd; deviantart',
						'fa-diamond' => '&#xf219; diamond',
						'fa-digg' => '&#xf1a6; digg',
						'fa-dot-circle-o' => '&#xf192; dot-circle-o',
						'fa-download' => '&#xf019; download',
						'fa-dribbble' => '&#xf17d; dribbble',
						'fa-dropbox' => '&#xf16b; dropbox',
						'fa-drupal' => '&#xf1a9; drupal',
						'fa-edge' => '&#xf282; edge',
						'fa-eercast' => '&#xf2da; eercast',
						'fa-eject' => '&#xf052; eject',
						'fa-ellipsis-h' => '&#xf141; ellipsis-h',
						'fa-ellipsis-v' => '&#xf142; ellipsis-v',
						'fa-empire' => '&#xf1d1; empire',
						'fa-envelope' => '&#xf0e0; envelope',
						'fa-envelope-o' => '&#xf003; envelope-o',
						'fa-envelope-open' => '&#xf2b6; envelope-open',
						'fa-envelope-open-o' => '&#xf2b7; envelope-open-o',
						'fa-envelope-square' => '&#xf199; envelope-square',
						'fa-envira' => '&#xf299; envira',
						'fa-eraser' => '&#xf12d; eraser',
						'fa-etsy' => '&#xf2d7; etsy',
						'fa-eur' => '&#xf153; eur',
						'fa-exchange' => '&#xf0ec; exchange',
						'fa-exclamation' => '&#xf12a; exclamation',
						'fa-exclamation-circle' => '&#xf06a; exclamation-circle',
						'fa-exclamation-triangle' => '&#xf071; exclamation-triangle',
						'fa-expand' => '&#xf065; expand',
						'fa-expeditedssl' => '&#xf23e; expeditedssl',
						'fa-external-link' => '&#xf08e; external-link',
						'fa-external-link-square' => '&#xf14c; external-link-square',
						'fa-eye' => '&#xf06e; eye',
						'fa-eye-slash' => '&#xf070; eye-slash',
						'fa-eyedropper' => '&#xf1fb; eyedropper',
						'fa-facebook' => '&#xf09a; facebook',
						'fa-facebook-official' => '&#xf230; facebook-official',
						'fa-facebook-square' => '&#xf082; facebook-square',
						'fa-fast-backward' => '&#xf049; fast-backward',
						'fa-fast-forward' => '&#xf050; fast-forward',
						'fa-fax' => '&#xf1ac; fax',
						'fa-female' => '&#xf182; female',
						'fa-fighter-jet' => '&#xf0fb; fighter-jet',
						'fa-file' => '&#xf15b; file',
						'fa-file-archive-o' => '&#xf1c6; file-archive-o',
						'fa-file-audio-o' => '&#xf1c7; file-audio-o',
						'fa-file-code-o' => '&#xf1c9; file-code-o',
						'fa-file-excel-o' => '&#xf1c3; file-excel-o',
						'fa-file-image-o' => '&#xf1c5; file-image-o',
						'fa-file-o' => '&#xf016; file-o',
						'fa-file-pdf-o' => '&#xf1c1; file-pdf-o',
						'fa-file-powerpoint-o' => '&#xf1c4; file-powerpoint-o',
						'fa-file-text' => '&#xf15c; file-text',
						'fa-file-text-o' => '&#xf0f6; file-text-o',
						'fa-file-video-o' => '&#xf1c8; file-video-o',
						'fa-file-word-o' => '&#xf1c2; file-word-o',
						'fa-files-o' => '&#xf0c5; files-o',
						'fa-film' => '&#xf008; film',
						'fa-filter' => '&#xf0b0; filter',
						'fa-fire' => '&#xf06d; fire',
						'fa-fire-extinguisher' => '&#xf134; fire-extinguisher',
						'fa-firefox' => '&#xf269; firefox',
						'fa-first-order' => '&#xf2b0; first-order',
						'fa-flag' => '&#xf024; flag',
						'fa-flag-checkered' => '&#xf11e; flag-checkered',
						'fa-flag-o' => '&#xf11d; flag-o',
						'fa-flask' => '&#xf0c3; flask',
						'fa-flickr' => '&#xf16e; flickr',
						'fa-floppy-o' => '&#xf0c7; floppy-o',
						'fa-folder' => '&#xf07b; folder',
						'fa-folder-o' => '&#xf114; folder-o',
						'fa-folder-open' => '&#xf07c; folder-open',
						'fa-folder-open-o' => '&#xf115; folder-open-o',
						'fa-font' => '&#xf031; font',
						'fa-font-awesome' => '&#xf2b4; font-awesome',
						'fa-fonticons' => '&#xf280; fonticons',
						'fa-fort-awesome' => '&#xf286; fort-awesome',
						'fa-forumbee' => '&#xf211; forumbee',
						'fa-forward' => '&#xf04e; forward',
						'fa-foursquare' => '&#xf180; foursquare',
						'fa-free-code-camp' => '&#xf2c5; free-code-camp',
						'fa-frown-o' => '&#xf119; frown-o',
						'fa-futbol-o' => '&#xf1e3; futbol-o',
						'fa-gamepad' => '&#xf11b; gamepad',
						'fa-gavel' => '&#xf0e3; gavel',
						'fa-gbp' => '&#xf154; gbp',
						'fa-genderless' => '&#xf22d; genderless',
						'fa-get-pocket' => '&#xf265; get-pocket',
						'fa-gg' => '&#xf260; gg',
						'fa-gg-circle' => '&#xf261; gg-circle',
						'fa-gift' => '&#xf06b; gift',
						'fa-git' => '&#xf1d3; git',
						'fa-git-square' => '&#xf1d2; git-square',
						'fa-github' => '&#xf09b; github',
						'fa-github-alt' => '&#xf113; github-alt',
						'fa-github-square' => '&#xf092; github-square',
						'fa-gitlab' => '&#xf296; gitlab',
						'fa-glass' => '&#xf000; glass',
						'fa-glide' => '&#xf2a5; glide',
						'fa-glide-g' => '&#xf2a6; glide-g',
						'fa-globe' => '&#xf0ac; globe',
						'fa-google' => '&#xf1a0; google',
						'fa-google-plus' => '&#xf0d5; google-plus',
						'fa-google-plus-official' => '&#xf2b3; google-plus-official',
						'fa-google-plus-square' => '&#xf0d4; google-plus-square',
						'fa-google-wallet' => '&#xf1ee; google-wallet',
						'fa-graduation-cap' => '&#xf19d; graduation-cap',
						'fa-gratipay' => '&#xf184; gratipay',
						'fa-grav' => '&#xf2d6; grav',
						'fa-h-square' => '&#xf0fd; h-square',
						'fa-hacker-news' => '&#xf1d4; hacker-news',
						'fa-hand-lizard-o' => '&#xf258; hand-lizard-o',
						'fa-hand-o-down' => '&#xf0a7; hand-o-down',
						'fa-hand-o-left' => '&#xf0a5; hand-o-left',
						'fa-hand-o-right' => '&#xf0a4; hand-o-right',
						'fa-hand-o-up' => '&#xf0a6; hand-o-up',
						'fa-hand-paper-o' => '&#xf256; hand-paper-o',
						'fa-hand-peace-o' => '&#xf25b; hand-peace-o',
						'fa-hand-pointer-o' => '&#xf25a; hand-pointer-o',
						'fa-hand-rock-o' => '&#xf255; hand-rock-o',
						'fa-hand-scissors-o' => '&#xf257; hand-scissors-o',
						'fa-hand-spock-o' => '&#xf259; hand-spock-o',
						'fa-handshake-o' => '&#xf2b5; handshake-o',
						'fa-hashtag' => '&#xf292; hashtag',
						'fa-hdd-o' => '&#xf0a0; hdd-o',
						'fa-header' => '&#xf1dc; header',
						'fa-headphones' => '&#xf025; headphones',
						'fa-heart' => '&#xf004; heart',
						'fa-heart-o' => '&#xf08a; heart-o',
						'fa-heartbeat' => '&#xf21e; heartbeat',
						'fa-history' => '&#xf1da; history',
						'fa-home' => '&#xf015; home',
						'fa-hospital-o' => '&#xf0f8; hospital-o',
						'fa-hourglass' => '&#xf254; hourglass',
						'fa-hourglass-end' => '&#xf253; hourglass-end',
						'fa-hourglass-half' => '&#xf252; hourglass-half',
						'fa-hourglass-o' => '&#xf250; hourglass-o',
						'fa-hourglass-start' => '&#xf251; hourglass-start',
						'fa-houzz' => '&#xf27c; houzz',
						'fa-html5' => '&#xf13b; html5',
						'fa-i-cursor' => '&#xf246; i-cursor',
						'fa-id-badge' => '&#xf2c1; id-badge',
						'fa-id-card' => '&#xf2c2; id-card',
						'fa-id-card-o' => '&#xf2c3; id-card-o',
						'fa-ils' => '&#xf20b; ils',
						'fa-imdb' => '&#xf2d8; imdb',
						'fa-inbox' => '&#xf01c; inbox',
						'fa-indent' => '&#xf03c; indent',
						'fa-industry' => '&#xf275; industry',
						'fa-info' => '&#xf129; info',
						'fa-info-circle' => '&#xf05a; info-circle',
						'fa-inr' => '&#xf156; inr',
						'fa-instagram' => '&#xf16d; instagram',
						'fa-internet-explorer' => '&#xf26b; internet-explorer',
						'fa-ioxhost' => '&#xf208; ioxhost',
						'fa-italic' => '&#xf033; italic',
						'fa-joomla' => '&#xf1aa; joomla',
						'fa-jpy' => '&#xf157; jpy',
						'fa-jsfiddle' => '&#xf1cc; jsfiddle',
						'fa-key' => '&#xf084; key',
						'fa-keyboard-o' => '&#xf11c; keyboard-o',
						'fa-krw' => '&#xf159; krw',
						'fa-language' => '&#xf1ab; language',
						'fa-laptop' => '&#xf109; laptop',
						'fa-lastfm' => '&#xf202; lastfm',
						'fa-lastfm-square' => '&#xf203; lastfm-square',
						'fa-leaf' => '&#xf06c; leaf',
						'fa-leanpub' => '&#xf212; leanpub',
						'fa-lemon-o' => '&#xf094; lemon-o',
						'fa-level-down' => '&#xf149; level-down',
						'fa-level-up' => '&#xf148; level-up',
						'fa-life-ring' => '&#xf1cd; life-ring',
						'fa-lightbulb-o' => '&#xf0eb; lightbulb-o',
						'fa-line-chart' => '&#xf201; line-chart',
						'fa-link' => '&#xf0c1; link',
						'fa-linkedin' => '&#xf0e1; linkedin',
						'fa-linkedin-square' => '&#xf08c; linkedin-square',
						'fa-linode' => '&#xf2b8; linode',
						'fa-linux' => '&#xf17c; linux',
						'fa-list' => '&#xf03a; list',
						'fa-list-alt' => '&#xf022; list-alt',
						'fa-list-ol' => '&#xf0cb; list-ol',
						'fa-list-ul' => '&#xf0ca; list-ul',
						'fa-location-arrow' => '&#xf124; location-arrow',
						'fa-lock' => '&#xf023; lock',
						'fa-long-arrow-down' => '&#xf175; long-arrow-down',
						'fa-long-arrow-left' => '&#xf177; long-arrow-left',
						'fa-long-arrow-right' => '&#xf178; long-arrow-right',
						'fa-long-arrow-up' => '&#xf176; long-arrow-up',
						'fa-low-vision' => '&#xf2a8; low-vision',
						'fa-magic' => '&#xf0d0; magic',
						'fa-magnet' => '&#xf076; magnet',
						'fa-male' => '&#xf183; male',
						'fa-map' => '&#xf279; map',
						'fa-map-marker' => '&#xf041; map-marker',
						'fa-map-o' => '&#xf278; map-o',
						'fa-map-pin' => '&#xf276; map-pin',
						'fa-map-signs' => '&#xf277; map-signs',
						'fa-mars' => '&#xf222; mars',
						'fa-mars-double' => '&#xf227; mars-double',
						'fa-mars-stroke' => '&#xf229; mars-stroke',
						'fa-mars-stroke-h' => '&#xf22b; mars-stroke-h',
						'fa-mars-stroke-v' => '&#xf22a; mars-stroke-v',
						'fa-maxcdn' => '&#xf136; maxcdn',
						'fa-meanpath' => '&#xf20c; meanpath',
						'fa-medium' => '&#xf23a; medium',
						'fa-medkit' => '&#xf0fa; medkit',
						'fa-meetup' => '&#xf2e0; meetup',
						'fa-meh-o' => '&#xf11a; meh-o',
						'fa-mercury' => '&#xf223; mercury',
						'fa-microchip' => '&#xf2db; microchip',
						'fa-microphone' => '&#xf130; microphone',
						'fa-microphone-slash' => '&#xf131; microphone-slash',
						'fa-minus' => '&#xf068; minus',
						'fa-minus-circle' => '&#xf056; minus-circle',
						'fa-minus-square' => '&#xf146; minus-square',
						'fa-minus-square-o' => '&#xf147; minus-square-o',
						'fa-mixcloud' => '&#xf289; mixcloud',
						'fa-mobile' => '&#xf10b; mobile',
						'fa-modx' => '&#xf285; modx',
						'fa-money' => '&#xf0d6; money',
						'fa-moon-o' => '&#xf186; moon-o',
						'fa-motorcycle' => '&#xf21c; motorcycle',
						'fa-mouse-pointer' => '&#xf245; mouse-pointer',
						'fa-music' => '&#xf001; music',
						'fa-neuter' => '&#xf22c; neuter',
						'fa-newspaper-o' => '&#xf1ea; newspaper-o',
						'fa-object-group' => '&#xf247; object-group',
						'fa-object-ungroup' => '&#xf248; object-ungroup',
						'fa-odnoklassniki' => '&#xf263; odnoklassniki',
						'fa-odnoklassniki-square' => '&#xf264; odnoklassniki-square',
						'fa-opencart' => '&#xf23d; opencart',
						'fa-openid' => '&#xf19b; openid',
						'fa-opera' => '&#xf26a; opera',
						'fa-optin-monster' => '&#xf23c; optin-monster',
						'fa-outdent' => '&#xf03b; outdent',
						'fa-pagelines' => '&#xf18c; pagelines',
						'fa-paint-brush' => '&#xf1fc; paint-brush',
						'fa-paper-plane' => '&#xf1d8; paper-plane',
						'fa-paper-plane-o' => '&#xf1d9; paper-plane-o',
						'fa-paperclip' => '&#xf0c6; paperclip',
						'fa-paragraph' => '&#xf1dd; paragraph',
						'fa-pause' => '&#xf04c; pause',
						'fa-pause-circle' => '&#xf28b; pause-circle',
						'fa-pause-circle-o' => '&#xf28c; pause-circle-o',
						'fa-paw' => '&#xf1b0; paw',
						'fa-paypal' => '&#xf1ed; paypal',
						'fa-pencil' => '&#xf040; pencil',
						'fa-pencil-square' => '&#xf14b; pencil-square',
						'fa-pencil-square-o' => '&#xf044; pencil-square-o',
						'fa-percent' => '&#xf295; percent',
						'fa-phone' => '&#xf095; phone',
						'fa-phone-square' => '&#xf098; phone-square',
						'fa-picture-o' => '&#xf03e; picture-o',
						'fa-pie-chart' => '&#xf200; pie-chart',
						'fa-pied-piper' => '&#xf2ae; pied-piper',
						'fa-pied-piper-alt' => '&#xf1a8; pied-piper-alt',
						'fa-pied-piper-pp' => '&#xf1a7; pied-piper-pp',
						'fa-pinterest' => '&#xf0d2; pinterest',
						'fa-pinterest-p' => '&#xf231; pinterest-p',
						'fa-pinterest-square' => '&#xf0d3; pinterest-square',
						'fa-plane' => '&#xf072; plane',
						'fa-play' => '&#xf04b; play',
						'fa-play-circle' => '&#xf144; play-circle',
						'fa-play-circle-o' => '&#xf01d; play-circle-o',
						'fa-plug' => '&#xf1e6; plug',
						'fa-plus' => '&#xf067; plus',
						'fa-plus-circle' => '&#xf055; plus-circle',
						'fa-plus-square' => '&#xf0fe; plus-square',
						'fa-plus-square-o' => '&#xf196; plus-square-o',
						'fa-podcast' => '&#xf2ce; podcast',
						'fa-power-off' => '&#xf011; power-off',
						'fa-print' => '&#xf02f; print',
						'fa-product-hunt' => '&#xf288; product-hunt',
						'fa-puzzle-piece' => '&#xf12e; puzzle-piece',
						'fa-qq' => '&#xf1d6; qq',
						'fa-qrcode' => '&#xf029; qrcode',
						'fa-question' => '&#xf128; question',
						'fa-question-circle' => '&#xf059; question-circle',
						'fa-question-circle-o' => '&#xf29c; question-circle-o',
						'fa-quora' => '&#xf2c4; quora',
						'fa-quote-left' => '&#xf10d; quote-left',
						'fa-quote-right' => '&#xf10e; quote-right',
						'fa-random' => '&#xf074; random',
						'fa-ravelry' => '&#xf2d9; ravelry',
						'fa-rebel' => '&#xf1d0; rebel',
						'fa-recycle' => '&#xf1b8; recycle',
						'fa-reddit' => '&#xf1a1; reddit',
						'fa-reddit-alien' => '&#xf281; reddit-alien',
						'fa-reddit-square' => '&#xf1a2; reddit-square',
						'fa-refresh' => '&#xf021; refresh',
						'fa-registered' => '&#xf25d; registered',
						'fa-renren' => '&#xf18b; renren',
						'fa-repeat' => '&#xf01e; repeat',
						'fa-reply' => '&#xf112; reply',
						'fa-reply-all' => '&#xf122; reply-all',
						'fa-retweet' => '&#xf079; retweet',
						'fa-road' => '&#xf018; road',
						'fa-rocket' => '&#xf135; rocket',
						'fa-rss' => '&#xf09e; rss',
						'fa-rss-square' => '&#xf143; rss-square',
						'fa-rub' => '&#xf158; rub',
						'fa-safari' => '&#xf267; safari',
						'fa-scissors' => '&#xf0c4; scissors',
						'fa-scribd' => '&#xf28a; scribd',
						'fa-search' => '&#xf002; search',
						'fa-search-minus' => '&#xf010; search-minus',
						'fa-search-plus' => '&#xf00e; search-plus',
						'fa-sellsy' => '&#xf213; sellsy',
						'fa-server' => '&#xf233; server',
						'fa-share' => '&#xf064; share',
						'fa-share-alt' => '&#xf1e0; share-alt',
						'fa-share-alt-square' => '&#xf1e1; share-alt-square',
						'fa-share-square' => '&#xf14d; share-square',
						'fa-share-square-o' => '&#xf045; share-square-o',
						'fa-shield' => '&#xf132; shield',
						'fa-ship' => '&#xf21a; ship',
						'fa-shirtsinbulk' => '&#xf214; shirtsinbulk',
						'fa-shopping-bag' => '&#xf290; shopping-bag',
						'fa-shopping-basket' => '&#xf291; shopping-basket',
						'fa-shopping-cart' => '&#xf07a; shopping-cart',
						'fa-shower' => '&#xf2cc; shower',
						'fa-sign-in' => '&#xf090; sign-in',
						'fa-sign-language' => '&#xf2a7; sign-language',
						'fa-sign-out' => '&#xf08b; sign-out',
						'fa-signal' => '&#xf012; signal',
						'fa-simplybuilt' => '&#xf215; simplybuilt',
						'fa-sitemap' => '&#xf0e8; sitemap',
						'fa-skyatlas' => '&#xf216; skyatlas',
						'fa-skype' => '&#xf17e; skype',
						'fa-slack' => '&#xf198; slack',
						'fa-sliders' => '&#xf1de; sliders',
						'fa-slideshare' => '&#xf1e7; slideshare',
						'fa-smile-o' => '&#xf118; smile-o',
						'fa-snapchat' => '&#xf2ab; snapchat',
						'fa-snapchat-ghost' => '&#xf2ac; snapchat-ghost',
						'fa-snapchat-square' => '&#xf2ad; snapchat-square',
						'fa-snowflake-o' => '&#xf2dc; snowflake-o',
						'fa-sort' => '&#xf0dc; sort',
						'fa-sort-alpha-asc' => '&#xf15d; sort-alpha-asc',
						'fa-sort-alpha-desc' => '&#xf15e; sort-alpha-desc',
						'fa-sort-amount-asc' => '&#xf160; sort-amount-asc',
						'fa-sort-amount-desc' => '&#xf161; sort-amount-desc',
						'fa-sort-asc' => '&#xf0de; sort-asc',
						'fa-sort-desc' => '&#xf0dd; sort-desc',
						'fa-sort-numeric-asc' => '&#xf162; sort-numeric-asc',
						'fa-sort-numeric-desc' => '&#xf163; sort-numeric-desc',
						'fa-soundcloud' => '&#xf1be; soundcloud',
						'fa-space-shuttle' => '&#xf197; space-shuttle',
						'fa-spinner' => '&#xf110; spinner',
						'fa-spoon' => '&#xf1b1; spoon',
						'fa-spotify' => '&#xf1bc; spotify',
						'fa-square' => '&#xf0c8; square',
						'fa-square-o' => '&#xf096; square-o',
						'fa-stack-exchange' => '&#xf18d; stack-exchange',
						'fa-stack-overflow' => '&#xf16c; stack-overflow',
						'fa-star' => '&#xf005; star',
						'fa-star-half' => '&#xf089; star-half',
						'fa-star-half-o' => '&#xf123; star-half-o',
						'fa-star-o' => '&#xf006; star-o',
						'fa-steam' => '&#xf1b6; steam',
						'fa-steam-square' => '&#xf1b7; steam-square',
						'fa-step-backward' => '&#xf048; step-backward',
						'fa-step-forward' => '&#xf051; step-forward',
						'fa-stethoscope' => '&#xf0f1; stethoscope',
						'fa-sticky-note' => '&#xf249; sticky-note',
						'fa-sticky-note-o' => '&#xf24a; sticky-note-o',
						'fa-stop' => '&#xf04d; stop',
						'fa-stop-circle' => '&#xf28d; stop-circle',
						'fa-stop-circle-o' => '&#xf28e; stop-circle-o',
						'fa-street-view' => '&#xf21d; street-view',
						'fa-strikethrough' => '&#xf0cc; strikethrough',
						'fa-stumbleupon' => '&#xf1a4; stumbleupon',
						'fa-stumbleupon-circle' => '&#xf1a3; stumbleupon-circle',
						'fa-subscript' => '&#xf12c; subscript',
						'fa-subway' => '&#xf239; subway',
						'fa-suitcase' => '&#xf0f2; suitcase',
						'fa-sun-o' => '&#xf185; sun-o',
						'fa-superpowers' => '&#xf2dd; superpowers',
						'fa-superscript' => '&#xf12b; superscript',
						'fa-table' => '&#xf0ce; table',
						'fa-tablet' => '&#xf10a; tablet',
						'fa-tachometer' => '&#xf0e4; tachometer',
						'fa-tag' => '&#xf02b; tag',
						'fa-tags' => '&#xf02c; tags',
						'fa-tasks' => '&#xf0ae; tasks',
						'fa-taxi' => '&#xf1ba; taxi',
						'fa-telegram' => '&#xf2c6; telegram',
						'fa-television' => '&#xf26c; television',
						'fa-tencent-weibo' => '&#xf1d5; tencent-weibo',
						'fa-terminal' => '&#xf120; terminal',
						'fa-text-height' => '&#xf034; text-height',
						'fa-text-width' => '&#xf035; text-width',
						'fa-th' => '&#xf00a; th',
						'fa-th-large' => '&#xf009; th-large',
						'fa-th-list' => '&#xf00b; th-list',
						'fa-themeisle' => '&#xf2b2; themeisle',
						'fa-thermometer-empty' => '&#xf2cb; thermometer-empty',
						'fa-thermometer-full' => '&#xf2c7; thermometer-full',
						'fa-thermometer-half' => '&#xf2c9; thermometer-half',
						'fa-thermometer-quarter' => '&#xf2ca; thermometer-quarter',
						'fa-thermometer-three-quarters' => '&#xf2c8; thermometer-three-quarters',
						'fa-thumb-tack' => '&#xf08d; thumb-tack',
						'fa-thumbs-down' => '&#xf165; thumbs-down',
						'fa-thumbs-o-down' => '&#xf088; thumbs-o-down',
						'fa-thumbs-o-up' => '&#xf087; thumbs-o-up',
						'fa-thumbs-up' => '&#xf164; thumbs-up',
						'fa-ticket' => '&#xf145; ticket',
						'fa-times' => '&#xf00d; times',
						'fa-times-circle' => '&#xf057; times-circle',
						'fa-times-circle-o' => '&#xf05c; times-circle-o',
						'fa-tint' => '&#xf043; tint',
						'fa-toggle-off' => '&#xf204; toggle-off',
						'fa-toggle-on' => '&#xf205; toggle-on',
						'fa-trademark' => '&#xf25c; trademark',
						'fa-train' => '&#xf238; train',
						'fa-transgender' => '&#xf224; transgender',
						'fa-transgender-alt' => '&#xf225; transgender-alt',
						'fa-trash' => '&#xf1f8; trash',
						'fa-trash-o' => '&#xf014; trash-o',
						'fa-tree' => '&#xf1bb; tree',
						'fa-trello' => '&#xf181; trello',
						'fa-tripadvisor' => '&#xf262; tripadvisor',
						'fa-trophy' => '&#xf091; trophy',
						'fa-truck' => '&#xf0d1; truck',
						'fa-try' => '&#xf195; try',
						'fa-tty' => '&#xf1e4; tty',
						'fa-tumblr' => '&#xf173; tumblr',
						'fa-tumblr-square' => '&#xf174; tumblr-square',
						'fa-twitch' => '&#xf1e8; twitch',
						'fa-twitter' => '&#xf099; twitter',
						'fa-twitter-square' => '&#xf081; twitter-square',
						'fa-umbrella' => '&#xf0e9; umbrella',
						'fa-underline' => '&#xf0cd; underline',
						'fa-undo' => '&#xf0e2; undo',
						'fa-universal-access' => '&#xf29a; universal-access',
						'fa-university' => '&#xf19c; university',
						'fa-unlock' => '&#xf09c; unlock',
						'fa-unlock-alt' => '&#xf13e; unlock-alt',
						'fa-upload' => '&#xf093; upload',
						'fa-usb' => '&#xf287; usb',
						'fa-usd' => '&#xf155; usd',
						'fa-user' => '&#xf007; user',
						'fa-user-circle' => '&#xf2bd; user-circle',
						'fa-user-circle-o' => '&#xf2be; user-circle-o',
						'fa-user-md' => '&#xf0f0; user-md',
						'fa-user-o' => '&#xf2c0; user-o',
						'fa-user-plus' => '&#xf234; user-plus',
						'fa-user-secret' => '&#xf21b; user-secret',
						'fa-user-times' => '&#xf235; user-times',
						'fa-users' => '&#xf0c0; users',
						'fa-venus' => '&#xf221; venus',
						'fa-venus-double' => '&#xf226; venus-double',
						'fa-venus-mars' => '&#xf228; venus-mars',
						'fa-viacoin' => '&#xf237; viacoin',
						'fa-viadeo' => '&#xf2a9; viadeo',
						'fa-viadeo-square' => '&#xf2aa; viadeo-square',
						'fa-video-camera' => '&#xf03d; video-camera',
						'fa-vimeo' => '&#xf27d; vimeo',
						'fa-vimeo-square' => '&#xf194; vimeo-square',
						'fa-vine' => '&#xf1ca; vine',
						'fa-vk' => '&#xf189; vk',
						'fa-volume-control-phone' => '&#xf2a0; volume-control-phone',
						'fa-volume-down' => '&#xf027; volume-down',
						'fa-volume-off' => '&#xf026; volume-off',
						'fa-volume-up' => '&#xf028; volume-up',
						'fa-weibo' => '&#xf18a; weibo',
						'fa-weixin' => '&#xf1d7; weixin',
						'fa-whatsapp' => '&#xf232; whatsapp',
						'fa-wheelchair' => '&#xf193; wheelchair',
						'fa-wheelchair-alt' => '&#xf29b; wheelchair-alt',
						'fa-wifi' => '&#xf1eb; wifi',
						'fa-wikipedia-w' => '&#xf266; wikipedia-w',
						'fa-window-close' => '&#xf2d3; window-close',
						'fa-window-close-o' => '&#xf2d4; window-close-o',
						'fa-window-maximize' => '&#xf2d0; window-maximize',
						'fa-window-minimize' => '&#xf2d1; window-minimize',
						'fa-window-restore' => '&#xf2d2; window-restore',
						'fa-windows' => '&#xf17a; windows',
						'fa-wordpress' => '&#xf19a; wordpress',
						'fa-wpbeginner' => '&#xf297; wpbeginner',
						'fa-wpexplorer' => '&#xf2de; wpexplorer',
						'fa-wpforms' => '&#xf298; wpforms',
						'fa-wrench' => '&#xf0ad; wrench',
						'fa-xing' => '&#xf168; xing',
						'fa-xing-square' => '&#xf169; xing-square',
						'fa-y-combinator' => '&#xf23b; y-combinator',
						'fa-yahoo' => '&#xf19e; yahoo',
						'fa-yelp' => '&#xf1e9; yelp',
						'fa-yoast' => '&#xf2b1; yoast',
						'fa-youtube' => '&#xf167; youtube',
						'fa-youtube-play' => '&#xf16a; youtube-play',
						'fa-youtube-square' => '&#xf166; youtube-square',
					),
				),
				array(
					'key' => 'field_5b5f0dbdc9752',
					'label' => 'Text',
					'name' => 'text',
					'type' => 'text',
					'instructions' => '',
					'required' => 0,
					'conditional_logic' => 0,
					'wrapper' => array(
						'width' => '',
						'class' => '',
						'id' => '',
					),
					'default_value' => '',
					'placeholder' => '',
					'prepend' => '',
					'append' => '',
					'maxlength' => '',
				),
			),
		),
	),
	'location' => array(
		array(
			array(
				'param' => 'page_template',
				'operator' => '==',
				'value' => 'templates/page-jobs.php',
			),
		),
	),
	'menu_order' => 0,
	'position' => 'normal',
	'style' => 'default',
	'label_placement' => 'top',
	'instruction_placement' => 'label',
	'hide_on_screen' => '',
	'active' => 1,
	'description' => '',
));

endif;