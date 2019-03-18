<?php get_header(); ?>

			<!-- index.php START -->
			
<?php if (is_category())
{
echo "<div class='center'><h1>Displaying Category '";
single_cat_title();
echo "'</h1></div>";
}
?>

<?php if (is_tag())
{
echo "<div class='center'><h1>Displaying Tag '";
single_tag_title();
echo "'</h1></div>";
}
?>

<?php if (is_search())
{
echo "<div class='center'><h1>Displaying Search '";
the_search_query();
echo "'</h1></div>";
}
?>

	<div id="content" class="narrowcolumn">

	<?php if (have_posts()) : ?>

	<?php while (have_posts()) : the_post(); ?>

	<div <?php post_class() ?> id="post-<?php the_ID(); ?>">



			
		<!-- Loop START -->
		  <table width="568" border="0" cellspacing="0" cellpadding="0">
            <tr>
              <td width="75" align="left" valign="top" class="box5a">
			  <div class="box5b">
			  <h3><?php the_time('j') ?></h3>
			  <?php the_time('M') ?>
			  </div>
			  </td>
              <td align="left" valign="top">
			  <div class="box5c">
			  <h1><a href="<?php the_permalink() ?>" rel="bookmark" title="Permanent Link to <?php the_title_attribute(); ?>"><?php the_title(); ?></a></h1>
			  <table width="100%" border="0" cellspacing="0" cellpadding="0"><tr><td align="left" valign="top">
			  	<div class="leftright">
					<div class="alignleft">Posted by <?php the_author() ?></div>
					<div class="alignright">Filed under <?php the_category(', ') ?></div>
				</div>
			  </td></tr></table>
			  </div>
			  <div class="box5d">&nbsp;</div>
			  </td>
            </tr>
          </table>
		  
		  <div class="box5e">
			<?php edit_post_link('Edit', '<p><small>(', ')</small></p>'); ?><?php the_content('<p><strong>Click to continue &raquo;</strong></p>'); ?>
		</div>
		
		<div class="box5f">
		<div class="box5g">
		<div class="box5h">
		<table width="568" border="0" cellspacing="0" cellpadding="0">
		  <tr>
			<td align="left" valign="top" width="515">
			<div class="box5i">
			Tags: <?php the_tags('', ', ', ''); ?>
			</div>
			</td>
			<td align="center" valign="top" class="box5j">
			<!-- Blank --><div style="height:8px;"><img src="<?php bloginfo('template_url'); ?>/images/0.gif" alt="<?php include (TEMPLATEPATH . "/template/alt.php"); ?>" /></div>
			<?php comments_popup_link('0', '1', '%'); ?>
			</td>
		  </tr>
		</table>
		</div>
		</div>
		</div>
		<!-- Blank --><div style="height:30px;"><img src="<?php bloginfo('template_url'); ?>/images/0.gif" alt="<?php include (TEMPLATEPATH . "/template/alt.php"); ?>" /></div>
		<!-- Loop END -->

	
				

	<?php endwhile; ?>

<!-- Blank --><div style="height:10px;"><img src="<?php bloginfo('template_url'); ?>/images/0.gif" alt="<?php include (TEMPLATEPATH . "/template-alt.php"); ?>" /></div>

<div class="navigation">
<div class="alignleft"><?php next_posts_link('&laquo; Older Entries') ?></div>
<div class="alignright"><?php previous_posts_link('Newer Entries &raquo;') ?></div>
</div>

<!-- Blank --><div style="height:10px;"><img src="<?php bloginfo('template_url'); ?>/images/0.gif" alt="<?php include (TEMPLATEPATH . "/template-alt.php"); ?>" /></div>
		
	<?php else : ?>

	<?php endif; ?> 

	</div>
	
	</div>

			<!-- index.php END -->
				
<?php get_sidebar(); ?>

<?php get_footer(); ?>