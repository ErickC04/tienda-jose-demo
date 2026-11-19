<?php
/**
 * Respaldo general (blog, búsquedas que no son de productos)
 */
get_header();
?>
<div class="wrap page-content">
	<h1 class="h-l"><?php echo is_search() ? 'Resultados para “' . esc_html( get_search_query() ) . '”' : esc_html( wp_get_document_title() ); ?></h1>
	<?php if ( have_posts() ) : ?>
		<div class="rte">
			<?php while ( have_posts() ) : the_post(); ?>
				<article style="padding:20px 0;border-bottom:1px solid var(--line)">
					<h2 class="h-m"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>
					<?php the_excerpt(); ?>
				</article>
			<?php endwhile; ?>
		</div>
		<?php the_posts_pagination(); ?>
	<?php else : ?>
		<p class="lede">No hay resultados.</p>
	<?php endif; ?>
</div>
<?php
get_footer();
