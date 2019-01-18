<?php

class Prospect_volunteer_search {

	public $search_skills_list;
	public $search_results;

	public function __construct() {
		add_shortcode('volunteer-search', array($this, 'shortcode'));
	}

	public function shortcode()
	{
		$this->get_specifications_fields();
		if (isset($_GET['volunteer-search'])) {
			$this->get_search_results();
		}
		$this->show_volunteer_search();
		
	}

	public function get_specifications_fields()
	{
		$specifications_group_id = 2805; 
		$specifications_fields = array();

		$fields = acf_get_fields( $specifications_group_id );

		$skills = array();
		// Load full list of skill fields
		foreach ($fields as $field) {
			if ($field['key'] == 'field_5c0a75c803054') {
				$skills = $field['sub_fields'];
				break;
			}
		}
		$this->search_skills_list = $skills;
	}

	public function show_volunteer_search()
	{
		?>
		<div id="volunteering-skills-search" class="container volunteering-skills-search">
			<div class="row">
				<div class="col-12">
					<form id="volunteering-skills-search-form" method="get">
						<input type="hidden" name="volunteer-search" value="search">

						<?php 
						$groups = 0; 
						$count = count($this->search_skills_list);
						?>
						<?php foreach ($this->search_skills_list as $field) : ?>
							<?php if ($field['type'] == 'group') : ?>
								<?php $groups++; ?>
								<div class="accordion <?php if ($groups == 1 && !isset($_GET['volunteer-search'])) echo 'open'; ?>">
									<div class="accordion-header">
										<?php echo $field['label']; ?>
									</div>
									<div class="accordion-body">
										<div class="fields <?php echo strtolower(str_replace(' ', '_', $field['label'])); ?>">
											<?php foreach ($field['sub_fields'] as $sub_field) : ?>
												<div class="field_group">
												<label><?php echo $sub_field['label']; ?></label>
												<input type="checkbox" <?php if (isset($_GET[$sub_field['name']])) echo 'checked="checked"'; ?> name="<?php echo $sub_field['name'] ?>">
												</div>
											<?php endforeach; ?>
										</div>
										<div class="controls">
											<?php if ($groups != $count) : ?>
												<span class="btn btn-yellow next">Next</span>
											<?php else : ?>
												<input type="submit" class="btn btn-yellow" value="Next">
											<?php endif; ?>
										</div>
									</div>
								</div>
							<?php endif; ?>
						<?php endforeach; ?>
						<div class="accordion results <?php if (isset($_GET['volunteer-search'])) echo 'open'; ?> ">
							<div class="accordion-header">
								<?php echo get_field('search_text', 'options')['search_results_accordion_header']; ?>
							</div>
							<div id="search-results" class="accordion-body">
								<?php if ($this->search_results) : ?>
									<div class="results-intro">
										<?php echo get_field('search_text', 'options')['search_results_header']; ?>
									</div>
									<?php foreach ($this->search_results as $result) : ?>
										<a href="<?php echo get_permalink($result['item']->ID); ?>" class="result"><?php echo $result['item']->post_title; ?><span class="score"><?php echo ceil($result['score']); ?>%</span></a>
									<?php endforeach; ?>
									<div class="results-outro">
										<?php echo get_field('search_text', 'options')['search_results_sub_text']; ?>
									</div>
								<?php endif; ?>
							</div>
						</div>
					</form>
				</div>
			</div>
		</div>
		<?php 
	}

	public function get_search_results()
	{
		$search_skills = $_GET;
		unset($search_skills['volunteer-search']);

		$query_args = array(
			'post_type' => 'jobs',
			'posts_per_page'  => -1,
			'order' => 'DESC',
			'orderby' => 'date',
		);

		$query_args['tax_query'][] = [
      		'taxonomy' => 'jobsection',
          	'field'    => 'slug',
          	'terms'    => 'volunteer',
      	];

		$items = new WP_Query($query_args);

		$items = $items->posts;

		$results = [];

		foreach ($items as $item) {
			$skills = get_field('skills', $item->ID);
			$total_skills = 0;
			$matches = 0;
			// Loop through the items skill groups
			foreach($skills['search_skills'] as $skill_group) {
				// Loop through each skill
				foreach ($skill_group as $skill_name => $skill) {
					// We only care about skills that are set to true on the role
					if ($skill) {
						$total_skills++;	
						if (isset($search_skills[$skill_name]) && $search_skills[$skill_name] == 'on') {
							$matches++;
						} 				
					}
				}
			}

			$match_score =  $matches / $total_skills * 100;

			$search_match_criteria = get_field('search_match_criteria', 'option');

			if ($match_score > $search_match_criteria) {
				$results[] = ['item' => $item,'score' => $match_score];
			}

		}

		// Sort results by score
		usort($results, function ($item1, $item2) {
		    if ($item2['score'] == $item1['score']) return 0;
		    return $item2['score'] < $item1['score'] ? -1 : 1;
		});

		$this->search_results = $results;
	}
}