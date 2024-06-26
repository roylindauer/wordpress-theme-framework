<?php

namespace Royl\WpThemeBase\Wp;

use \Royl\WpThemeBase\Util;
use Doctrine\Inflector\InflectorFactory;

/**
 * WordPress Post Type base class
 *
 * @package     WpThemeBase
 * @subpackage  Wp
 * @author      Roy Lindauer <hello@roylindauer.com>
 * @version     1.0
 */
class PostType
{

    /**
     * ID of this post type. aka the all lowercase no spaces version of $name
     *
     * @var string $name
     */
    public $id = '';

    /**
     * Name of this post type.
     *
     * @var string $name
     */
    public $name = '';
    
    /**
     * The type of post type. Or the post types type...
     *
     * @var string $post
     */
    public $type = 'post';
    
    /**
     * Post type support features.
     *
     * @var array $supports
     */
    public $supports = [
        'title',
        'editor',
        'page-attributes',
        'author',
        'thumbnail',
        'custom-fields',
        'revisions',
        'page-attributes',
        'post-formats',
    ];

    /**
     * Default args.
     *
     * @var array $args
     */
    public $args = [];
    
    /**
     * Label sets.
     *
     * @var array $labels
     */
    public $labels = [];

    /**
     * Class Constructor. Does the heavy lifting of registering posttype
     * @param string $name   Name of the post type to generate
     * @param array  $params Array of options to configure posttype
     */
    public function __construct($name, $params = [])
    {
        $this->name = $name;
        $this->id   = strtolower($this->name);

        if (in_array($this->id, ['post', 'page', 'attachment', 'revision', 'nav_menu_item'])) {
            Util\Debug::addThemeError(sprintf('Post type "%s" is reserved', $this->id));
            return;
        }

        $_default_params = [
            'labels' => []
        ];

        $params = array_merge($_default_params, $params);

        if (isset($params['supports'])) {
            $this->supports = $params['supports'];
        }

        
        $this->Inflector = InflectorFactory::create()->build();
        
        // Convention over configuration!
        $singular = \Royl\WpThemeBase\Util\Text::humanize($this->name);
        $plural   = \Royl\WpThemeBase\Util\Text::humanize($this->Inflector->pluralize($this->name));
        
        $this->labels = [
            'name' =>                   $plural,
            'singular_name' =>          $singular,
            'add_new' =>                sprintf(\Royl\WpThemeBase\Util\Text::translate('Add New %s'), $singular),
            'add_new_item' =>           sprintf(\Royl\WpThemeBase\Util\Text::translate('Add New %s'), $singular),
            'edit_item' =>              sprintf(\Royl\WpThemeBase\Util\Text::translate('Edit %s'), $singular),
            'new_item' =>               sprintf(\Royl\WpThemeBase\Util\Text::translate('New %s'), $singular),
            'all_items' =>              sprintf(\Royl\WpThemeBase\Util\Text::translate('All %s'), $plural),
            'view_item' =>              sprintf(\Royl\WpThemeBase\Util\Text::translate('View %s'), $singular),
            'search_items' =>           sprintf(\Royl\WpThemeBase\Util\Text::translate('Search %s'), $plural),
            'not_found' =>              sprintf(\Royl\WpThemeBase\Util\Text::translate('No %s found'), $plural),
            'not_found_in_trash' =>     sprintf(\Royl\WpThemeBase\Util\Text::translate('No %s found in trash'), $plural),
            'parent_item_colon' =>      '',
            'menu_name' =>              $plural
        ];
        
        // Post type defaults
        $this->args = [
            'description' => '',
            'public' => true,
            'exclude_from_search ' => false,
            'publicly_queryable' => true,
            'show_ui' => true,
            'show_in_nav_menus' => true,
            'show_in_menu' => true,
            'query_var' => true,
            'rewrite' => true,
            'capability_type' => $this->type,
            'has_archive' => true,
            'hierarchical' => false,
            'supports' => $this->supports,
            'slug' => $singular,
            'taxonomies' => array(),
        ];

        // Merge user args
        $this->args = array_merge($this->args, $params['args']);

        // Merge user custom labels
        if (!isset($params['args']['labels']) || !is_array($params['args']['labels'])) {
            $params['args']['labels'] = [];
        }
        $this->args['labels'] = array_merge($this->labels, $params['args']['labels']);

        register_post_type($this->id, $this->args);
    }
}
