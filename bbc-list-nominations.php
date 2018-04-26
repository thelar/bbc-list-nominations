<?php
/*
Plugin Name: BBC List Nominations
Description: Custom plugin to add an admin menu for listing and PDF'ing nominations
Author: Kevin Price-Ward
Version: 2.1
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
                <option value="community-project">Community Project</option>
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

function do_pdf($path){
    include plugin_dir_path(__FILE__) . 'inc/pdfcrowd.php';

    $url = home_url('print-nominations/' . $path . '/');

    try
    {
        // create an API client instance
        //$client = new \Pdfcrowd("BBC_trial", "a87cf224311a0e107a23d876857db519");
        $client = new \Pdfcrowd("bbc_info", "68313bc28cb3cb84bf6bb0236b275fd4");

        // convert a web page and store the generated PDF into a $pdf variable

        $pdf = $client->convertURI($url);

        // set HTTP response headers
        header("Content-Type: application/pdf");
        header("Cache-Control: max-age=0");
        header("Accept-Ranges: none");
        header("Content-Disposition: attachment; filename=\"Jewson_BBC_nominations.pdf\"");

        // send the generated PDF
        echo $pdf;
    }
    catch(\PdfcrowdException $why)
    {
        echo "Pdfcrowd Error: " . $why;
    }
}