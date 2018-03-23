<?php
/*
Plugin Name: BBC List Nominations
Description: Custom plugin to add an admin menu for listing and PDF'ing nominations
Author: Kevin Price-Ward
Version: 2.0
*/
add_action('admin_menu', 'test_plugin_setup_menu');

function test_plugin_setup_menu(){
    add_menu_page( 'Print Nominations', 'PDF Nominations', 'manage_options', 'pdf-nominations', 'print_nominations', '
dashicons-media-text' );
}

function bbc_list_nominations_script()
{
    wp_enqueue_script( 'bbc_nom_script', plugin_dir_url( __FILE__ ) . 'scripts/common.js', ['jquery'] );
}
add_action('admin_enqueue_scripts', 'bbc_list_nominations_script');

function print_nominations(){
    echo '<div class="wrap">';
    echo "<h1>PDF nominations</h1>";
    echo '<p>Use the drop down menu\'s below to select which nominations will appear on your PDF:</p>';
?>
    <form id="bbc_list_nomination_form">
        <div class="row">
            <label for="type-select">Nomination type:</label>
            <select name="type-select" id="type-select">
                <option selected="selected" value="">- Select type -</option>
                <option value="trade-hero">Trade Hero</option>
                <option value="community-project">Trade Hero</option>
                <option value="top-community-prize">Top Community Prize</option>
            </select>
        </div>
        <div class="row">
            <label for="region-select">Region:</label>
            <?php
                wp_dropdown_categories([
                    'taxonomy' => 'nomination-region',
                    'value_field' => 'slug',
                    'id' => 'region-select',
                    'show_option_none' => '- Select region -',
                    'option_none_value' => '',
                ]);
            ?>
        </div><br><br>
        <input class="button-primary" type="submit" name="Example" value="<?php esc_attr_e( 'Print PDF' ); ?>" />
    </form>
<?php
    echo '</div>';
}