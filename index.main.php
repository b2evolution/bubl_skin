<?php
/**
 * This is the main/default page template.
 *
 * For a quick explanation of b2evo 2.0 skins, please start here:
 * {@link http://manual.b2evolution.net/Skins_2.0}
 *
 * It is used to display the blog when no specific page template is available to handle the request.
 *
 * @package evoskins
 * @subpackage custom
 *
 * @version $Id: index.main.php,v 1.3 2007/05/27 00:35:26 fplanque Exp $
 */
if( !defined('EVO_MAIN_INIT') ) die( 'Please, do not access this page directly.' );

// This is the main template; it may be used to display very different things.
// Do inits depending on current $disp:
skin_init( $disp );


// -------------------------- HTML HEADER INCLUDED HERE --------------------------
skin_include( '_html_header.inc.php' );
// Note: You can customize the default HTML header by copying the
// _html_header.inc.php file into the current skin folder.
// -------------------------------- END OF HEADER --------------------------------
?>

<div id="wrapper">

<div class="pageHeader">

<div class="PageTop">
	<?php
		// Display container and contents:
		skin_container( NT_('Page Top'), array(
				// The following params will be used as defaults for widgets included in this container:
				'block_start' => '<div class="$wi_class$">',
				'block_end' => '</div>',
				'block_display_title' => false,
				'list_start' => '<ul>',
				'list_end' => '</ul>',
				'item_start' => '<li>',
				'item_end' => '</li>',
			) );
	?>
</div>


	<?php
		// Display container and contents:
		skin_container( NT_('Header'), array(
				// The following params will be used as defaults for widgets included in this container:
				'block_start' => '<div class="$wi_class$">',
				'block_end' => '</div>',
				'block_title_start' => '<h1>',
				'block_title_end' => '</h1>',
			) );
	?>

</div>

<div class="page_main_area">


<!-- =================================== START OF MAIN AREA =================================== -->
<div class="bPosts">


<?php
	// ------------------------- MESSAGES GENERATED FROM ACTIONS -------------------------
	messages( array(
			'block_start' => '<div class="action_messages">',
			'block_end'   => '</div>',
		) );
	// --------------------------------- END OF MESSAGES ---------------------------------
?>


	<?php
		// -------------------- PREV/NEXT PAGE LINKS (POST LIST MODE) --------------------
		mainlist_page_links( array(
				'block_start' => '<div class="floatright">',
				'block_end' => '</div>',
				'links_format' => '$prev$ $page$ / $total_pages$ $next$',
				'prev_text' => '<img src="img/prev.gif" width="28" height="32" alt="'.T_('Previous').'" title="'.T_('Previous').'" class="middle" />',
				'next_text' => '<img src="img/next.gif" width="28" height="32" alt="'.T_('Next').'" title="'.T_('Next').'" class="middle" />',
				'no_prev_text' => '',
				'no_next_text' => '<img src="'.$rsc_url.'/img/blank.gif" width="29" height="29" alt="" class="middle" />',
			) );
		// ------------------------- END OF PREV/NEXT PAGE LINKS -------------------------
	?>


<?php
	// ------------------------------------ START OF POSTS ----------------------------------------
	// Display message if no post:
	display_if_empty();

	while( $Item = & mainlist_get_item() )
	{	// For each blog post, do everything below up to the closing curly brace "}"
	?>
	<div id="<?php $Item->anchor_id() ?>" class="bPost bPost<?php $Item->status_raw() ?>" lang="<?php $Item->lang() ?>">

		<?php
			$Item->locale_temp_switch(); // Temporarily switch to post locale (useful for multilingual blogs)
		?>

		<?php
			// Display images that are linked to this post:
			$Item->images( array(
					'before' =>              '<div class="bImages">',
					'before_image' =>        '<table cellspacing="0" cellpadding="0" class="image_block"><tr><td class="image">
																		<table cellspacing="0" cellpadding="0" class="shadow_b"><tr><td class="shadow_r"><div class="shadow_tr"><div class="shadow_bl"><div class="shadow_br">',
					'before_image_legend' => '<div class="image_legend">',
					'after_image_legend' =>  '</div>',
					'after_image' =>         '</div></div></div></td></tr></table>
																		</td></tr></table>',
					'after' =>               '</div>',
					'image_size' =>          'fit-640x480'
				) );
		?>


		<div class="bDetails">

			<?php
				// Link to comments, trackbacks, etc.:
				$Item->feedback_link( array(
								'type' => 'feedbacks',
								'link_before' => '<div class="action_right">',
								'link_after' => '</div>',
								'link_text_zero' => get_icon( 'nocomment' ),
								'link_text_one' => get_icon( 'comments' ),
								'link_text_more' => get_icon( 'comments' ),
								'link_title' => '#',
								'use_popup' => false,
							) );
			 ?>

			<?php
				$Item->edit_link( array( // Link to backoffice for editing
						'before'    => '<div class="action_right">',
						'after'     => '</div>',
						'text'      => T_('Edit...'),
            'title'     => T_('Edit title/description...'),
					) );
			?>

			<h2 class="bTitle"><?php $Item->title(); ?></h2>

			<div class="bSmallPrint">
				<?php
					$Item->issue_date( array(
							'before'      => '<span class="timestamp">',
							'after'       => '</span>',
							'date_format' => '#',
						) );

					$Item->categories( array(
						'before'          => ' | '.T_('Categories').': ',
						'after'           => ' ',
						'include_main'    => true,
						'include_other'   => true,
						'include_external'=> true,
						'link_categories' => true,
					) );
				?>
			</div>

			<?php
				// ---------------------- POST CONTENT INCLUDED HERE ----------------------
				skin_include( '_item_content.inc.php', array(
						'image_size'	=>	'',
					) );
				// Note: You can customize the default item feedback by copying the generic
				// /skins/_item_feedback.inc.php file into the current skin folder.
				// -------------------------- END OF POST CONTENT -------------------------
			?>

		</div>

		<?php
			// ------------------ FEEDBACK (COMMENTS/TRACKBACKS) INCLUDED HERE ------------------
			skin_include( '_item_feedback.inc.php', array(
					'before_section_title' => '<h4>',
					'after_section_title'  => '</h4>',
				) );
			// Note: You can customize the default item feedback by copying the generic
			// /skins/_item_feedback.inc.php file into the current skin folder.
			// ---------------------- END OF FEEDBACK (COMMENTS/TRACKBACKS) ---------------------
		?>

		<?php
			locale_restore_previous();	// Restore previous locale (Blog locale)
		?>
	</div>
	<?php
	} // ---------------------------------- END OF POSTS ------------------------------------
	?>


	<?php
		// -------------- MAIN CONTENT TEMPLATE INCLUDED HERE (Based on $disp) --------------
		skin_include( '$disp$', array(
				'disp_posts'  => '',		// We already handled this case above
				'disp_single' => '',		// We already handled this case above
				'disp_page'   => '',		// We already handled this case above
			) );
		// Note: you can customize any of the sub templates included here by
		// copying the matching php file into your skin directory.
		// ------------------------- END OF MAIN CONTENT TEMPLATE ---------------------------
	?>

</div>


<!-- =================================== START OF SIDEBAR =================================== -->
<div class="bSideBar">

	<?php
		// Display container contents:
		skin_container( NT_('Sidebar'), array(
				// The following (optional) params will be used as defaults for widgets included in this container:
				// This will enclose each widget in a block:
				'block_start' => '<div class="bSideItem $wi_class$">',
				'block_end' => '</div>',
				// This will enclose the title of each widget:
				'block_title_start' => '<h3>',
				'block_title_end' => '</h3>',
				// If a widget displays a list, this will enclose that list:
				'list_start' => '<ul>',
				'list_end' => '</ul>',
				// This will enclose each item in a list:
				'item_start' => '<li>',
				'item_end' => '</li>',
				// This will enclose sub-lists in a list:
				'group_start' => '<ul>',
				'group_end' => '</ul>',
				// This will enclose (foot)notes:
				'notes_start' => '<div class="notes">',
				'notes_end' => '</div>',
			) );
	?>

</div>

<div class="clear"></div>

</div>


<!-- =================================== START OF FOOTER =================================== -->
<div class="pageFooter">

	<?php
		// Display container and contents:
		skin_container( NT_("Footer"), array(
				// The following (optional) params will be used as defaults for widgets included in this container:
				// This will enclose each widget in a block:
				'block_start' => '<div class="bFootItem $wi_class$">',
				'block_end' => '</div>',
				// This will enclose the title of each widget:
				'block_title_start' => '<h3>',
				'block_title_end' => '</h3>',
				// If a widget displays a list, this will enclose that list:
				'list_start' => '<ul>',
				'list_end' => '</ul>',
				// This will enclose each item in a list:
				'item_start' => '<li>',
				'item_end' => '</li>',
				// This will enclose sub-lists in a list:
				'group_start' => '<ul>',
				'group_end' => '</ul>',
				// This will enclose (foot)notes:
				'notes_start' => '<div class="notes">',
				'notes_end' => '</div>',
			) );
		// Note: Double quotes have been used around "Footer" only for test purposes.
	?>

	<div class="clear">
	<p class="baseline">
    <?php
			// Display a link to contact the owner of this blog (if owner accepts messages):
			$Blog->contact_link( array(
					'before'      => '',
					'after'       => '',
					'text'   => T_('Contact'),
					'title'  => T_('Send a message to the owner of this blog...'),
				) );
		?>
		&bull;
		<a href="http://severinelandrieu.com/">&copy; severinelandrieu.com</a>
		&bull;
		Powered by <a href="http://b2evolution.net/">b2evolution</a>
	</p>
	</div>

</div>

<?php
// ------------------------- HTML FOOTER INCLUDED HERE --------------------------
skin_include( '_html_footer.inc.php' );
// Note: You can customize the default HTML footer by copying the
// _html_footer.inc.php file into the current skin folder.
// ------------------------------- END OF FOOTER --------------------------------
?>