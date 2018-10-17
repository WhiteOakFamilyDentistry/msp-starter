<?php

////////////////////////////////////////////////////////////////////
// REGISTER THE SIDEBAR(S) & WIDGET AREAS
////////////////////////////////////////////////////////////////////


        register_sidebar(
            array(
            'name' => 'Blog Sidebar',
            'id' => 'blog-sidebar',
            'before_widget' => '<aside id="%1$s" class="widget %2$s">',
            'after_widget' => '</aside>',
            'before_title' => '<h3>',
            'after_title' => '</h3>',
        ));

        register_sidebar(
            array(
            'name' => 'Inner Sidebar',
            'id' => 'inner-sidebar',
            'before_widget' => '<aside id="%1$s" class="widget %2$s">',
            'after_widget' => '</aside>',
            'before_title' => '<h3>',
            'after_title' => '</h3>',
        ));

?>