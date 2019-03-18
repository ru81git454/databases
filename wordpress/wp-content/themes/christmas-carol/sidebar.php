		<!-- Blank --><div style="height:20px;"><img src="<?php bloginfo('template_url'); ?>/images/0.gif" alt="<?php include (TEMPLATEPATH . "/template/alt.php"); ?>" /></div>
		</div>
		</div>
		</div>
		<!-- White END -->
		
		</td><td width="20">&nbsp;</td><td width="324" align="left" valign="top">
		
		<!-- sidebar.php START -->
		
<div id="sidebar" role="complementary">

<!-- begin widget -->
<div id="menu">			
		
		<!-- Widget START -->
		<div class="widget1">
		<div class="widget2">
		<div class="widget3">
		<div class="widget4">
		<h3>About<span class="lightcolor">Me</span></h3>
		<?php include (TEMPLATEPATH . "/template/profile.php"); ?>
		</div>
		</div>
		</div>
		</div>
		<!-- Widget END -->

<?php 	/* Widgetized sidebar, if you have the plugin installed. */
		if ( !function_exists('dynamic_sidebar') || !dynamic_sidebar() ) : ?>
				
		<!-- Widget START -->
		<div class="widget1">
		<div class="widget2">
		<div class="widget3">
		<div class="widget4">
		<h3>The<span class="lightcolor">Categories</span></h3>
		<?php wp_list_categories('show_count=1'); ?>
		</div>
		</div>
		</div>
		</div>		
		<!-- Widget END -->
		
		<!-- Widget START -->
		<div class="widget1">
		<div class="widget2">
		<div class="widget3">
		<div class="widget4">
		<h3>Old<span class="lightcolor">Archives</span></h3>
		<ul>
		<?php wp_get_archives('type=monthly'); ?>
		</ul>
		</div>
		</div>
		</div>
		</div>		
		<!-- Widget END -->
		
		<!-- Widget START -->
		<div class="widget1">
		<div class="widget2">
		<div class="widget3">
		<div class="widget4">
		<h3>Blog<span class="lightcolor">Meta</span></h3>
		<ul>
		<?php wp_register(); ?>
		<li><?php wp_loginout(); ?></li>
		<li><a href="http://validator.w3.org/check/referer" title="This page validates as XHTML 1.0 Transitional">Valid <abbr title="eXtensible HyperText Markup Language">XHTML</abbr></a></li>
		<li><a href="http://gmpg.org/xfn/"><abbr title="XHTML Friends Network">XFN</abbr></a></li>
		<li><a href="http://wordpress.org/" title="Powered by WordPress, state-of-the-art semantic personal publishing platform.">WordPress</a></li>
		</ul>
		</div>
		</div>
		</div>
		</div>		
		<!-- Widget END -->		
		
<?php endif; ?>				

</div>
<!-- end widget -->		

</div>		