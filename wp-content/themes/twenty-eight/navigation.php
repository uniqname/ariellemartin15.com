<?php ?><hr />
<?php if ( is_single() ) { ?>
<div class="navigation">
	<div class="left">
		<?php previous_post( '<span>&laquo;</span> %', '', 'yes' ); ?>
	</div>
	<div class="right">
		<?php next_post( '% <span>&raquo;</span>', '', 'yes' ); ?>
	</div>
	<div class="clear"></div>
</div>
<?php } else { ?>
<div class="navigation">
	<div class="left">
		<?php next_posts_link( __( '<span>&laquo;</span> Previous Entries', 'twenty-eight' ) ); ?>
	</div>
	<div class="right">
		<?php previous_posts_link( __( 'Next Entries <span>&raquo;</span>', 'twenty-eight' ) ); ?>
	</div>
	<div class="clear"></div>
</div>
<?php } ?><hr />