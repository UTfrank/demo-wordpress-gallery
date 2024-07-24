<?php

/**
 * Justified Image Grid Widget.
 * Elementor widget that inserts an Justified Image Grid into the page.
 */

namespace Firsh\JustifiedImageGrid;

class Elementor_Widget extends \Elementor\Widget_Base
{
    /**
     * Constructor that loads frontend assets.
     *
     * @param array      $data Widget data. Default is an empty array.
     * @param array|null $args Optional. Widget default arguments. Default is null.
     *
     * @return void
     */
    public function __construct(array $data = [], $args = null)
    {
        \Elementor\Widget_Base::__construct($data, $args);
    }

    /**
     * Provides a link and creates the Need Help (?) link at the bottom.
     *
     * @return string
     */
    public function get_custom_help_url()
    {
        return "https://justifiedgrid.com/support/";
    }

    /**
     * Get widget name.
     *
     * @return string Widget name.
     */
    public function get_name()
    {
        return 'justified-image-grid-elementor-widget';
    }

    /**
     * Get widget title.
     *
     * @return string Widget title.
     */
    public function get_title()
    {
        /* translators: Widget title. */
        return esc_html__('Justified Image Grid', 'jig_td');
    }

    /**
     * Get widget icon.
     *
     * @return string Widget icon.
     */
    public function get_icon()
    {
        return 'eicon-gallery-justified';
    }

    /**
     * Get quicksearch keywords.
     *
     * @return array Alternative names.
     */
    public function get_keywords()
    {
        return ['jig'];
    }

    /**
     * Get widget categories.
     *
     * @return array Widget categories.
     */
    public function get_categories()
    {
        return ['general'];
    }
    /**
     * Register widget controls.
     *
     * Adds different input fields to allow the user to change and customize the widget settings.
     *
     * @return void
     */
    protected function register_controls()
    {
        $grids = $this->grid_list();

        $this->start_controls_section(
            'grid-selection',
            [
                'label' => esc_html__('Grid Selection', 'jig_td')
            ]
        );
        $this->add_control(
            'gallery',
            [
                'label' => esc_html__('Choose a Justified Image Grid', 'jig_td'),
                'label_block' => true,
                'type' => \Elementor\Controls_Manager::SELECT,
                'options' => $grids,
                'default' => '',
            ]
        );
        $this->add_control(
            'grid-count',
            [
                'type' => \Elementor\Controls_Manager::HIDDEN,
                'default' => count($grids),
            ]
        );

        $button_js = 'jQuery("#edit-grid").attr("href","'.admin_url('post.php').'?post="+jQuery(".elementor-control-gallery select").val().replace("grid-","")+"&action=edit");';

        $this->add_control(
            'edit-grid',
            [
                'label' => '',
                'show_label' => false,
                'type' => \Elementor\Controls_Manager::RAW_HTML,
                'raw' => "
                    <a onmouseover='{$button_js}' id='edit-grid' target='_blank' class='elementor-button elementor-button-default'>Edit Grid</a>
                    <style type='text/css'>
                        #edit-grid,
                        #edit-grid:hover{
                            border-width: 0;
                        }
                        .elementor-control-grid-selection{
                            pointer-events: none;
                        }
                        .elementor-control-grid-selection .elementor-section-toggle{
                            display: none;
                        }
                    </style>",
                'conditions' => [
                    'terms' => [
                        [
                            'name' => 'gallery',
                            'operator' => '!in',
                            'value' => ['', [], 'null', null]
                        ]
                    ]
                ]
            ]
        );

        $this->end_controls_section();
    }

    private function grid_list()
    {
        $grids = get_posts([
            'post_type' => 'justified-image-grid',
            'posts_per_page' => -1,
            'orderby' => 'ID',
            'order' => 'desc'
        ]);
        $options = [];
        if (!empty($grids)) {
            foreach ($grids as $grid) {
                $options['grid-'.$grid->ID] = ($grid->post_title ? $grid->post_title : __('(Untitled Grid)', 'jig_td'))." (#".$grid->ID.")";
            }
        }
        return $options;
    }
    /**
     * Echo generated final HTML in the frontend (also in the backend).
     *
     * @return void
     */
    protected function render()
    {
        $s = $this->get_settings_for_display();
        if ($s['grid-count'] === 0) {
            _e("You don't have any grids yet, please create one in the Dashboard: JIG -> Create New Grid.", 'jig_td');
            return;
        }
        if (empty($s['gallery'])) {
            _e("Please use the dropdown on the left to choose a Grid you already created.", 'jig_td');
            return;
        }
        new \JustifiedImageGrid();
        echo do_shortcode('[justified_image_grid gallery='.str_replace('grid-', '', $s['gallery']).']');
    }
}
