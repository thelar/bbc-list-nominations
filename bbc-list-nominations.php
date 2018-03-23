<?php
/*
Plugin Name: BBC List Nominations
Description: Custom plugin to add an admin menu for listing and PDF'ing nominations
Author: Kevin Price-Ward
Version: 2.0
*/
add_action('admin_menu', 'test_plugin_setup_menu');

function test_plugin_setup_menu(){
    add_menu_page( 'Print Nominations', 'PDF Nominations', 'manage_options', 'pdf-nominations', 'print_nominations' );
}

function print_nominations(){
    echo "<h1>Hello World!</h1>";
}