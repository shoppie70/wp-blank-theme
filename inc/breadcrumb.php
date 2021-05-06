<?php
//////////////////////////////////////////////////
//オリジナルパンくずリストを作成
//////////////////////////////////////////////////
function fit_breadcrumb( $args = array() ){
	global $post;
	$str ='';
	$defaults = array(
		'class' => "breadcrumb",
		'home' => "トップ",
		'search' => "の検索結果 ",
		'tag' => "",
		'author' => "",
		'notfound' => "404 Not Found",
	);

	$args = wp_parse_args( $args, $defaults );
	extract( $args, EXTR_SKIP );

		if( !is_home() && !is_front_page() && !is_admin() ){
			$str.= '<div class="'. $class .'" >';
			$str.= '<div class="container" >';
			$str.= '<ul class="breadcrumb__list">';
			$str.= '<li class="breadcrumb__item" itemscope itemtype="http://data-vocabulary.org/Breadcrumb"><a href="'. home_url() .'/" itemprop="url"><span class="icon-home" itemprop="title">'. $home .'</span></a></li>';
			$my_taxonomy = get_query_var( 'taxonomy' );
			$cpt = get_query_var( 'post_type' );

		if( $my_taxonomy && is_tax( $my_taxonomy ) ) {
			$my_tax = get_queried_object();
			$post_types = get_taxonomy( $my_taxonomy )->object_type;
			$cpt = $post_types[0];
			$str.='<li class="breadcrumb__item" itemscope itemtype="http://data-vocabulary.org/Breadcrumb"><a href="' .get_post_type_archive_link( $cpt ).'" itemprop="url"><span itemprop="title">'. get_post_type_object( $cpt )->label.'</span></a></li>';

		if( $my_tax -> parent != 0 ) {
			$ancestors = array_reverse( get_ancestors( $my_tax -> term_id, $my_tax->taxonomy ) );

			foreach( $ancestors as $ancestor ){
				$str.='<li class="breadcrumb__item" itemscope itemtype="http://data-vocabulary.org/Breadcrumb"><a href="'. get_term_link( $ancestor, $my_tax->taxonomy ) .'" itemprop="url"><span itemprop="title">'. get_term( $ancestor, $my_tax->taxonomy )->name .'</span></a></li>';
			}
		}
			$str.='<li class="breadcrumb__item">'. $my_tax -> name . '</li>';
		}

		elseif( is_category() ) {
			$cat = get_queried_object();
			$post_type = get_post_type_object( $post->post_type );
			$str.='<li class="breadcrumb__item" itemscope itemtype="http://data-vocabulary.org/Breadcrumb"><a href="'. get_post_type_archive_link( $post->post_type ). '" itemprop="url"><span itemprop="title">'. $post_type -> label . '</span></a></li>';
			if( $cat -> parent != 0 ){
				$ancestors = array_reverse( get_ancestors( $cat -> cat_ID, 'category' ));
				foreach( $ancestors as $ancestor ){
					$str.='<li class="breadcrumb__item" itemscope itemtype="http://data-vocabulary.org/Breadcrumb"><a href="'. get_category_link( $ancestor ) .'" itemprop="url"><span itemprop="title">'. get_cat_name( $ancestor ) .'</span></a></li>';
				}
			}
			$str.='<li class="breadcrumb__item">'. $cat -> name . '</li>';
		}

		elseif( is_post_type_archive() ) {
			$cpt = get_query_var( 'post_type' );
			$str.='<li class="breadcrumb__item">'. get_post_type_object( $cpt )->label . '</li>';
		}

		elseif( $cpt && is_singular( $cpt ) ){
			$taxes = get_object_taxonomies( $cpt );
			$mytax = $taxes[0];
			$str.='<li class="breadcrumb__item" itemscope itemtype="http://data-vocabulary.org/Breadcrumb"><a href="' .get_post_type_archive_link( $cpt ).'" itemprop="url"><span itemprop="title">'. get_post_type_object( $cpt )->label.'</span></a></li>';
			$taxes = get_the_terms( $post->ID, $mytax ) ?: [];
			$tax = get_youngest_tax( $taxes, $mytax );

			if( $tax -> parent != 0 ){
				$ancestors = array_reverse( get_ancestors( $tax -> term_id, $mytax ) );
				foreach( $ancestors as $ancestor ){
					$str.='<li class="breadcrumb__item" itemscope itemtype="http://data-vocabulary.org/Breadcrumb"><a href="'. get_term_link( $ancestor, $mytax ).'" itemprop="url"><span itemprop="title">'. get_term( $ancestor, $mytax )->name . '</span></a></li>';
				}
			}
			if($mytax) $str.='<li class="breadcrumb__item" itemscope itemtype="http://data-vocabulary.org/Breadcrumb"><a href="'. get_term_link( $tax, $mytax ) .'" itemprop="url"><span itemprop="title">'. $tax -> name . '</span></a></li>';
			$str.= '<li class="breadcrumb__item">'. $post -> post_title .'</li>';
		}

		elseif( is_single() ){
			$categories = get_the_category( $post->ID );
			$post_type = get_post_type_object( $post->post_type );
			$cat = get_youngest_cat( $categories );
			$str.='<li class="breadcrumb__item" itemscope itemtype="http://data-vocabulary.org/Breadcrumb"><a href="'. get_post_type_archive_link( $post->post_type ). '" itemprop="url"><span itemprop="title">'. $post_type -> label . '</span></a></li>';
			if( $cat -> parent != 0 ){
				$ancestors = array_reverse( get_ancestors( $cat -> cat_ID, 'category' ) );
				foreach( $ancestors as $ancestor ){
					$str.='<li class="breadcrumb__item" itemscope itemtype="http://data-vocabulary.org/Breadcrumb"><a href="'. get_category_link( $ancestor ).'" itemprop="url"><span itemprop="title">'. get_cat_name( $ancestor ). '</span></a></li>';
				}
			}
			$str.='<li class="breadcrumb__item" itemscope itemtype="http://data-vocabulary.org/Breadcrumb"><a href="'. get_category_link( $cat -> term_id ). '" itemprop="url"><span itemprop="title">'. $cat-> cat_name . '</span></a></li>';
			$str.= '<li class="breadcrumb__item">'. $post -> post_title .'</li>';
    }

		elseif( is_page() ){
			if( $post -> post_parent != 0 ){
				$ancestors = array_reverse( get_post_ancestors( $post->ID ) );
				foreach( $ancestors as $ancestor ){
					$str.='<li class="breadcrumb__item" itemscope itemtype="http://data-vocabulary.org/Breadcrumb"><a href="'. get_permalink( $ancestor ).'" itemprop="url"><span itemprop="title">'. get_the_title( $ancestor ) .'</span></a></li>';
				}
			}
			$str.= '<li class="breadcrumb__item">'. $post -> post_title .'</li>';
		}

		elseif( is_date() ){
			if( get_query_var( 'day' ) != 0){
				$str.='<li class="breadcrumb__item" itemscope itemtype="http://data-vocabulary.org/Breadcrumb"><a href="'. get_year_link(get_query_var('year')). '" itemprop="url"><span itemprop="title">' . get_query_var( 'year' ). '年</span></a></li>';
				$str.='<li class="breadcrumb__item" itemscope itemtype="http://data-vocabulary.org/Breadcrumb"><a href="'. get_month_link(get_query_var( 'year' ), get_query_var( 'monthnum' ) ). '" itemprop="url"><span itemprop="title">'. get_query_var( 'monthnum' ) .'月</span></a></li>';
				$str.='<li class="breadcrumb__item">'. get_query_var('day'). '日</li>';
		}

		elseif( get_query_var('monthnum' ) != 0){
			$str.='<li class="breadcrumb__item" itemscope itemtype="http://data-vocabulary.org/Breadcrumb"><a href="'. get_year_link( get_query_var('year') ) .'" itemprop="url"><span itemprop="title">'. get_query_var( 'year' ) .'年</span></a></li>';
			$str.='<li class="breadcrumb__item">'. get_query_var( 'monthnum' ). '月</li>';
		}

		else {
			$str.='<li class="breadcrumb__item">'. get_query_var( 'year' ) .'年</li>';
		}
		}

		elseif( is_search() ) {
			$str.='<li class="breadcrumb__item">「'. get_search_query() .'」'. $search .'</li>';
		}

		elseif( is_author() ){
			$str .='<li class="breadcrumb__item">'. $author . get_the_author_meta('display_name', get_query_var( 'author' )).'</li>';
		}

		elseif( is_tag() ){
			$str.='<li class="breadcrumb__item">'. $tag . single_tag_title( '' , false ). '</li>';
		}

		elseif( is_attachment() ){
			$str.= '<li class="breadcrumb__item">'. $post -> post_title .'</li>';
		}

		elseif( is_404() ){
			$str.='<li class="breadcrumb__item">'.$notfound.'</li>';
		}

		else{
			$str.='<li class="breadcrumb__item">'. wp_title( '', true ) .'</li>';
		}

			$str.='</ul>';
			$str.='</div>';
			$str.='</div>';
		}
	echo $str;
}

function get_youngest_cat( $categories ){
	global $post;
	if(count( $categories ) == 1 ){
		$youngest = $categories[0];
	}
	else{
		$count = 0;
		foreach( $categories as $category ){
			$children = get_term_children( $category -> term_id, 'category' );
			if($children){
				if ( $count < count( $children ) ){
					$count = count( $children );
					$lot_children = $children;
					foreach( $lot_children as $child ){
						if( in_category( $child, $post -> ID ) ){
							$youngest = get_category( $child );
						}
					}
				}
			}
			else{
				$youngest = $category;
			}
		}
	}
	return $youngest;
}

function get_youngest_tax( $taxes, $mytaxonomy ){
	global $post;
	if( count( $taxes ) == 1 ){
		$youngest = $taxes[ key( $taxes )];
	}
	else{
		$count = 0;
		foreach( $taxes as $tax ){
			$children = get_term_children( $tax -> term_id, $mytaxonomy );
			if($children){
				if ( $count < count($children) ){
					$count = count($children);
					$lot_children = $children;
					foreach($lot_children as $child){
						if( is_object_in_term( $post -> ID, $mytaxonomy ) ){
							$youngest = get_term($child, $mytaxonomy);
						}
					}
				}
			}
			else{
				$youngest = $tax;
			}
		}
	}
	return $youngest;
}
