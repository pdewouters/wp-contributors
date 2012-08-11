<?php
/*
Plugin Name: WP Contributors
Plugin URI: http://wpconsult.net/wp-contributors
Description: display more than one author-name on a post.
Version: 0.1
Author: Paul de Wouters
Author Email: pauldewouters@gmail.com
License:

  Copyright 2011 Paul de Wouters (pauldewouters@gmail.com)

  This program is free software; you can redistribute it and/or modify
  it under the terms of the GNU General Public License, version 2, as 
  published by the Free Software Foundation.

  This program is distributed in the hope that it will be useful,
  but WITHOUT ANY WARRANTY; without even the implied warranty of
  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
  GNU General Public License for more details.

  You should have received a copy of the GNU General Public License
  along with this program; if not, write to the Free Software
  Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA
  
*/

  class WP_Contributors_Load {

    function __construct(){

      add_action( 'plugins_loaded', array( &$this, 'constants') );

      add_action( 'plugins_loaded', array( &$this, 'includes') );

      add_filter( 'the_content', array( &$this, 'wpc_get_post_authors' ) );
    }

    // Define the constants
    function constants(){

      // Plugin version
      define( 'WP_CONTRIB_VERSION', '0.1');
      define( 'WP_CONTRIB_DB_VERSION', 1);

      define( 'WP_CONTRIB_DIR', trailingslashit( plugin_dir_path( __FILE__ ) ) );
      define( 'WP_CONTRIB_URL', trailingslashit( plugin_dir_url( __FILE__ ) ) );

      define( 'WP_CONTRIB_INCLUDES', WP_CONTRIB_DIR . trailingslashit( 'includes' ) );
    }

    function includes(){

      require_once( WP_CONTRIB_INCLUDES . 'metabox.php');
    }

    function wpc_get_post_authors( $content ) {
      global $post;
      if( is_singular() && is_main_query() ){
        $author_ids = get_post_meta( $post->ID, '_wpc_author_multicheckbox', false );
        $authors .= '<h4>Contributors: </h4><ul>';
        foreach ( $author_ids as $author_id ) {
          $authors .= '<li><span>' . get_avatar( $author_id, 32 ) . '</span><a href="' . get_author_posts_url( $author_id ) . '">' . get_the_author_meta( 'user_nicename', $author_id ) . '</a></li>';
        }
        $authors .= '</ul>';
        $content .= $authors;
      }

      return $content;
    }
  }

  $wp_contributors = new WP_Contributors_Load();