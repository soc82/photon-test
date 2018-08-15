<?php $documents_page = get_field('documents_page', 'options'); ?>
<?php if(!$documents_page) {
  $documents_page = site_url('/documents');
} else {
  $documents_page = get_permalink($documents_page);
} ?>
<form method="get" action="<?php echo $documents_page; ?>" class="document-filter">
  <input value="<?php echo (isset($_GET['document-search']) ? $_GET['document-search'] : '') ?>"  id="document-search" class="document-search" type="text" name="document-search" placeholder="Search...">
    <?php
    $categories = get_terms(array(
        'taxonomy' => 'download-category',
        'hide_empty' => true,
    ));
    if($categories):
      echo '<select name="document-category" class="document-category-dropdown">';
        echo '<option value="all">All Categories</option>';
          foreach($categories as $category) : ?>
            <option
              value="<?php echo $category->slug; ?>"
              <?php if (isset($_GET['document-category']) && $_GET['document-category'] == $category->slug) { echo ' selected '; } ?>
              >
              <?php echo $category->name; ?>
            </option>
      <?php endforeach;
    echo '</select>';
  endif; ?>
  <button type="submit" class="btn"><i class="far fa-search"></i> Search</button>
</form>
