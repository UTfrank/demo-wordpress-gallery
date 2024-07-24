<?php
class JIG_Grids
{
    private $page_name;
    private $plugin_version;
    private $dotmin;
    private $includer_file;
    private $cpt_name = 'justified-image-grid';
    private $shortcode_role;

    public function __construct($page_name, $plugin_version, $dotmin, $includer_file, $shortcode_role)
    {
        $this->page_name = $page_name;
        $this->plugin_version = $plugin_version;
        $this->dotmin = $dotmin;
        $this->includer_file = $includer_file;
        $this->shortcode_role = $shortcode_role;
    }

    public function setup_grid_cpt()
    {
        $current_user = wp_get_current_user();
        $show_in_menu = false;

        switch ($this->shortcode_role) {
            case 'unlimited':
                $show_in_menu = $this->page_name;
                break;
            case 'contributor':
                if (array_intersect(['contributor', 'author', 'editor', 'administrator'], $current_user->roles)) {
                    $show_in_menu = $this->page_name;
                }
                break;
            case 'author':
                if (array_intersect(['author', 'editor', 'administrator'], $current_user->roles)) {
                    $show_in_menu = $this->page_name;
                }
                break;
            case 'editor':
                if (array_intersect(['editor', 'administrator'], $current_user->roles)) {
                    $show_in_menu = $this->page_name;
                }
                break;
            case 'administrator':
                if (in_array('administrator', $current_user->roles)) {
                    $show_in_menu = $this->page_name;
                }
                break;
        }

        $args = [
            'rewrite'               => false,
            'public'                => false,
            'show_in_rest'          => true,
            'show_ui'               => $show_in_menu ? true : false,
            'show_in_menu'          => $show_in_menu,
            'supports'              => ['title', 'revisions'],
            'labels'                => [
                'name'              => 'Grids',
                'singular_name'     => 'Grid',
                'add_new'           => __('Create a new Justified Image Grid', 'jig_td'),
                'add_new_item'      => __('Create a new Justified Image Grid', 'jig_td'),
                'edit_item'         => __('Edit Justified Image Grid', 'jig_td'),
                'new_item'          => __('New Justified Image Grid', 'jig_td'),
                'search_items'      => __('Search Grids', 'jig_td'),
            ],
            'register_meta_box_cb'  => [$this, 'box_cb'],
        ];
        register_post_type($this->cpt_name, $args);

        // Show Create New Grid along with the Grids, and only if that shows as well
        if ($show_in_menu !== false) {
            add_action('admin_menu', [$this, 'add_new_grid_entry_to_menu'], 11);
        }

        // Change columns shown on the custom post type edit.php view
        add_filter("manage_{$this->cpt_name}_posts_columns", [$this, 'change_columns']);
        // Add values to column
        add_action("manage_{$this->cpt_name}_posts_custom_column", [$this, 'add_values_to_columns'], 10, 2);

        add_action('wp_ajax_jig_preview', [$this, 'jig_preview']);
        add_action('admin_enqueue_scripts', [$this, 'enqueue_scripts_for_cpt']);
    }

    public function add_new_grid_entry_to_menu(){
        add_submenu_page(
            // Parent slug
            $this->page_name,
            // Page title
            __('Create New Grid', 'jig_td'),
            // Menu title
            __('Create New Grid', 'jig_td'),
            // Capability
            'edit_posts', // The adding of this entry to the menu is controlled by the CPT's $show_in_menu anyway, so this is the lowest here
            // Menu slug
            'post-new.php?post_type=justified-image-grid',
            // Function for output
            ''
        );
    }
    public function change_columns($columns)
    {
        return [
            'cb' => '<input type="checkbox" />',
            'title' => __('Name'),
            'shortcode' => __('Shortcode'),
            'date' =>__('Date')
        ];
    }

    public function add_values_to_columns($column, $post_id)
    {
        if ($column === 'shortcode') {
            echo '<input type="text" readonly class="jig-shortcode" grid-id="'.$post_id.'" value="">';
        }
    }
    public function box_cb($post)
    {
        \add_meta_box(
            // ID
            'jig_grid_editor',
            // Title
            'Shortcode Editor',
            // CB
            [$this, 'render_grid_editor'],
            // Screen
            $post->post_type,
            // Context
            'advanced',
            // Prio
            'high',
            // CB args
            $post
        );
    }

    public function render_grid_editor($post)
    {
        $admin_ajax_url = esc_url(admin_url('admin-ajax.php')); ?>
        <input type="text" name="content" id="content" value="<?php \esc_attr_e($post->post_content); ?>" />
        <div id="jig-wrap">
            <div id="jig-top">
                <div id="jig-top-left">
                    <input placeholder="<?php _e('Add a title to this Grid', 'jig_td'); ?>" id="jig-title" type="text" name="jig-title" value="">

                </div>
                <div class="jig-hidden-form" data-action="<?php echo $admin_ajax_url; ?>?action=jig_preview">
                    <input id="jig-preview-shortcode" name="jig-preview-shortcode" type="text" value="[justified_image_grid limit=10 ids=*]" />
                    <input name="security" type="text" value="<?php echo wp_create_nonce("jig_preview"); ?>" />
                </div>
                <div id="jig-top-right">
                    <input type="text" readonly class="jig-shortcode" value="[justified_image_grid gallery=123456]">
                    <a class="button-secondary" id="jig-revisions">&#62241;</a>
                    <button class="button-secondary jig-preview-button"><?php _e('Preview', 'jig_td'); ?></button>
                    <button class="button-primary jig-save-button"><?php _e('Save Changes', 'jig_td'); ?> & <span class="jig-primary-button-action"></span></button>
                </div>
            </div>
            <iframe id="jig-sce" src="<?php echo $admin_ajax_url; ?>?action=jig_shortcode_editor" width="100%" height="0"></iframe>
            <div id="jig-grabber">
                <div id="jig-grab-hot">
                    <svg id="jig-dots" viewBox="0 0 24 8" xmlns="http://www.w3.org/2000/svg" fill="#fff">
                        <circle cx="8" cy="4" r="1" />
                        <circle cx="12" cy="4" r="1" />
                        <circle cx="16" cy="4" r="1" />
                    </svg>
                </div>
            </div>
            <iframe id="jig-preview" name="jig-preview" width="100%" height="0"></iframe>
        </div>
    <?php
    }

    public function jig_preview()
    {
        if (ob_get_length()) {
            ob_end_clean();
        }

        check_ajax_referer('jig_preview', 'security');
        error_reporting(0);

        wp_enqueue_style(
            'jig-preview-style',
            plugins_url('css/jig-preview'.$this->dotmin.'.css', $this->includer_file),
            [],
            $this->plugin_version
        );

        wp_enqueue_script(
            'jig-preview',
            plugins_url('js/jig-preview'.$this->dotmin.'.js', $this->includer_file),
            ['jquery'],
            $this->plugin_version,
            true
        );

        wp_localize_script(
            'jig-preview',
            'jigPreview',
            ['inGutenberg' => !empty($_REQUEST['gutenberg']) ? 'yes' : 'no']
        );

        ?>
        <!doctype html>
        <html <?php language_attributes(); ?>>

        <head>
            <meta charset="<?php bloginfo('charset'); ?>">
            <?php wp_head(); ?>
        </head>

        <body id="jig-preview" <?php body_class(); ?>>
            <?php
            if (!empty($_REQUEST['jig-preview-shortcode'])) {
                $sc =  $_REQUEST['jig-preview-shortcode'];
                \set_transient('jig-preview-shortcode', $sc, MINUTE_IN_SECONDS);
            } else {
                $sc = \get_transient('jig-preview-shortcode');
            }
        $sc = stripslashes($sc);

        ob_start();
        echo do_shortcode($sc);
        wp_footer();

        $buff = ob_get_contents();
        ob_end_clean();

        function prepare_query_value($q)
        {
            $q = \urlencode($q);
            if (stripos($q, '%5C') === false) {
                $q = \str_replace('%2F', '%5C%2F', $q);
            }
            return $q;
        }
        $buff = preg_replace_callback(
            '/admin-ajax\.php([^\s?]*)\?[^"]*action=jig_preview([^\s"]*)"/i',
            function ($ms) {
                    $jig_query = !empty($ms[1]) ? $ms[1] : (!empty($ms[2]) ? $ms[2] : '');
                    return 'admin-ajax.php?security=' . wp_create_nonce('jig_preview') . ($jig_query ? '&jig_query=' . prepare_query_value($jig_query) : '') . '&action=jig_preview"';
                },
            $buff
        );

        global $wp;
        $home_entity_url_in_breadcrumbs = home_url(add_query_arg([], $wp->request));
        $buff = str_replace(
            [
                    'href="' . $home_entity_url_in_breadcrumbs . '"',
                    'href="' . $home_entity_url_in_breadcrumbs . '/"'
                ],
            'href="' . admin_url('admin-ajax.php') . '?security=' . wp_create_nonce('jig_preview') . '&action=jig_preview' . '"',
            $buff
        );

        echo $buff; ?>
            
        </body>
        </html>
<?php
        die();
    }

    public function enqueue_scripts_for_cpt($hook_suffix)
    {
        if (in_array($hook_suffix, ['post.php', 'post-new.php', 'edit.php'])) {
            $screen = get_current_screen();

            if (is_object($screen) && $screen->post_type == $this->cpt_name) {
                add_filter('user_can_richedit', '__return_false');
                wp_enqueue_media();
                wp_enqueue_style(
                    'jig-cpt-style',
                    plugins_url('css/jig-cpt' . $this->dotmin . '.css', $this->includer_file),
                    [],
                    $this->plugin_version
                );

                wp_enqueue_script(
                    'jig-cpt',
                    plugins_url('js/jig-cpt' . $this->dotmin . '.js', $this->includer_file),
                    ['jquery'],
                    $this->plugin_version,
                    true
                );

                wp_localize_script(
                    'jig-cpt',
                    'JIG',
                    [
                        'try_using_enter' => __('Or just hit Enter for a quick preview!', 'jig_td'),
                        'copied' => __('Copied!', 'jig_td')
                    ]
                );
            }
        }
    }
}
