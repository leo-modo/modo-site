<?php get_header(); ?>

<div id="archive">

    <div class="container">

		<?php if ( have_posts() ) : ?>
            <div class="items">

				<?php
				while ( have_posts() ) : the_post();
					get_template_part( 'sdc_parts/teaser', 'post' );
				endwhile;
				?>
            </div>
		<?php else: ?>
            <h2><?php echo __( 'Aucun résultat à votre recherche', 'modo' ); ?></h2>
            <p><?php echo __( "Essayez de reformuler votre recherche", 'modo' ); ?></p>
            <a href="<?php echo get_site_url(); ?>" class="btn"><?php echo __( "Retour à l'accueil", 'modo' ); ?></a>
		<?php endif; ?>


		<?php echo modo_pagination(); ?>

    </div>
</div>

<?php get_footer(); ?>
