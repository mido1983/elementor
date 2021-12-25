<?php
    
    class CustomPostType
    {
        public $post_type_name;
        public $singular;
        public $plural;
        public $slug;
        public $options;
        public $taxonomies;
        public $taxonomy_settings;
        public $exisiting_taxonomies;
        public $filters;
        public $columns;
        public $custom_populate_columns;
        public $sortable;
        public $textdomain = 'CustomPostTypeClass';
        public $supports;
        
        function __construct($post_type_names, $options = array())
        {
            $supports = $post_type_names['supports'];
            if (is_array($post_type_names)) {
                $names = array(
                    'singular',
                    'plural',
                    'slug',
                );
                $this->post_type_name = $post_type_names['post_type_name'];
                foreach ($names as $name) {
                    if (isset($post_type_names[$name])) {
                        $this->$name = $post_type_names[$name];
                    } else {
                        $method = 'get_' . $name;
                        $this->$name = $this->$method();
                    }
                }
            } else {
                $this->post_type_name = $post_type_names;
                $this->slug = $this->get_slug();
                $this->plural = $this->get_plural();
                $this->singular = $this->get_singular();
            }
            $this->options = $options;
            $this->add_action('init', array(&$this, 'register_taxonomies'));
            $this->add_action('init', array(&$this, 'register_post_type'));
            $this->add_action('init', array(&$this, 'register_exisiting_taxonomies'));
            $this->add_filter('manage_edit-' . $this->post_type_name . '_columns', array(&$this, 'add_admin_columns'));
            $this->add_action('manage_' . $this->post_type_name . '_posts_custom_column', array(&$this, 'populate_admin_columns'), 10, 2);
            $this->add_action('restrict_manage_posts', array(&$this, 'add_taxonomy_filters'));
            $this->add_filter('post_updated_messages', array(&$this, 'updated_messages'));
            $this->add_filter('bulk_post_updated_messages', array(&$this, 'bulk_updated_messages'), 10, 2);
        }
        
        function get_slug($name = null)
        {
            if (!isset($name)) {
                $name = $this->post_type_name;
            }
            $name = strtolower($name);
            $name = str_replace(" ", "-", $name);
            $name = str_replace("_", "-", $name);
            return $name;
        }
        
        function get_plural($name = null)
        {
            if (!isset($name)) {
                $name = $this->post_type_name;
            }
            return $this->get_human_friendly($name) . 's';
        }
        
        function get_human_friendly($name = null)
        {
            if (!isset($name)) {
                $name = $this->post_type_name;
            }
            return ucwords(strtolower(str_replace("-", " ", str_replace("_", " ", $name))));
        }
        
        function get_singular($name = null)
        {
            if (!isset($name)) {
                $name = $this->post_type_name;
            }
            return $this->get_human_friendly($name);
        }
        
        function add_action($action, $function, $priority = 10, $accepted_args = 1)
        {
            add_action($action, $function, $priority, $accepted_args);
        }
        
        function add_filter($action, $function, $priority = 10, $accepted_args = 1)
        {
            add_filter($action, $function, $priority, $accepted_args);
        }
        
        function get($var)
        {
            if ($this->$var) {
                return $this->$var;
            } else {
                return false;
            }
        }
        
        function set($var, $value)
        {
            $reserved = array(
                'config',
                'post_type_name',
                'singular',
                'plural',
                'slug',
                'options',
                'taxonomies',
            );
            if (!in_array($var, $reserved)) {
                $this->$var = $value;
            }
        }
        
        function register_post_type($data)
        {
            $plural = $this->plural;
            $singular = $this->singular;
            $slug = $this->slug;
            $labels = array(
                'name' => sprintf(__('%s', $this->textdomain), $plural),
                'singular_name' => sprintf(__('%s', $this->textdomain), $singular),
                'menu_name' => sprintf(__('%s', $this->textdomain), $plural),
                'all_items' => sprintf(__('%s', $this->textdomain), $plural),
                'add_new' => __('Add New', $this->textdomain),
                'add_new_item' => sprintf(__('Add New %s', $this->textdomain), $singular),
                'edit_item' => sprintf(__('Edit %s', $this->textdomain), $singular),
                'new_item' => sprintf(__('New %s', $this->textdomain), $singular),
                'view_item' => sprintf(__('View %s', $this->textdomain), $singular),
                'search_items' => sprintf(__('Search %s', $this->textdomain), $plural),
                'not_found' => sprintf(__('No %s found', $this->textdomain), $plural),
                'not_found_in_trash' => sprintf(__('No %s found in Trash', $this->textdomain), $plural),
                'parent_item_colon' => sprintf(__('Parent %s:', $this->textdomain), $singular),
            );
            $defaults = array(
                'labels' => $labels,
                'public' => true,
                'rewrite' => array(
                    'slug' => $slug,
                ),
                'supports' => $data,
            );
            
            $options = array_replace_recursive($defaults, $this->options);
            $this->options = $options;
            if (!post_type_exists($this->post_type_name)) {
                register_post_type($this->post_type_name, $options);
            }
        }
        
        function register_taxonomy($taxonomy_names, $options = array())
        {
            $post_type = $this->post_type_name;
            $names = array(
                'singular',
                'plural',
                'slug',
            );
            if (is_array($taxonomy_names)) {
                $taxonomy_name = $taxonomy_names['taxonomy_name'];
                foreach ($names as $name) {
                    if (isset($taxonomy_names[$name])) {
                        $$name = $taxonomy_names[$name];
                    } else {
                        $method = 'get_' . $name;
                        $$name = $this->$method($taxonomy_name);
                    }
                }
            } else {
                $taxonomy_name = $taxonomy_names;
                $singular = $this->get_singular($taxonomy_name);
                $plural = $this->get_plural($taxonomy_name);
                $slug = $this->get_slug($taxonomy_name);
            }
            $labels = array(
                'name' => sprintf(__('%s', $this->textdomain), $plural),
                'singular_name' => sprintf(__('%s', $this->textdomain), $singular),
                'menu_name' => sprintf(__('%s', $this->textdomain), $plural),
                'all_items' => sprintf(__('All %s', $this->textdomain), $plural),
                'edit_item' => sprintf(__('Edit %s', $this->textdomain), $singular),
                'view_item' => sprintf(__('View %s', $this->textdomain), $singular),
                'update_item' => sprintf(__('Update %s', $this->textdomain), $singular),
                'add_new_item' => sprintf(__('Add New %s', $this->textdomain), $singular),
                'new_item_name' => sprintf(__('New %s Name', $this->textdomain), $singular),
                'parent_item' => sprintf(__('Parent %s', $this->textdomain), $plural),
                'parent_item_colon' => sprintf(__('Parent %s:', $this->textdomain), $plural),
                'search_items' => sprintf(__('Search %s', $this->textdomain), $plural),
                'popular_items' => sprintf(__('Popular %s', $this->textdomain), $plural),
                'separate_items_with_commas' => sprintf(__('Seperate %s with commas', $this->textdomain), $plural),
                'add_or_remove_items' => sprintf(__('Add or remove %s', $this->textdomain), $plural),
                'choose_from_most_used' => sprintf(__('Choose from most used %s', $this->textdomain), $plural),
                'not_found' => sprintf(__('No %s found', $this->textdomain), $plural),
            );
            $defaults = array(
                'labels' => $labels,
                'hierarchical' => true,
                'rewrite' => array(
                    'slug' => $slug,
                ),
            );
            $options = array_replace_recursive($defaults, $options);
            $this->taxonomies[] = $taxonomy_name;
            $this->taxonomy_settings[$taxonomy_name] = $options;
        }
        
        function register_taxonomies()
        {
            if (is_array($this->taxonomy_settings)) {
                foreach ($this->taxonomy_settings as $taxonomy_name => $options) {
                    if (!taxonomy_exists($taxonomy_name)) {
                        register_taxonomy($taxonomy_name, $this->post_type_name, $options);
                    } else {
                        $this->exisiting_taxonomies[] = $taxonomy_name;
                    }
                }
            }
        }
        
        function register_exisiting_taxonomies()
        {
            if (is_array($this->exisiting_taxonomies)) {
                foreach ($this->exisiting_taxonomies as $taxonomy_name) {
                    register_taxonomy_for_object_type($taxonomy_name, $this->post_type_name);
                }
            }
        }
        
        function add_admin_columns($columns)
        {
            if (!isset($this->columns)) {
                $new_columns = array();
                if (is_array($this->taxonomies) && in_array('post_tag', $this->taxonomies) || $this->post_type_name === 'post') {
                    $after = 'tags';
                } elseif (is_array($this->taxonomies) && in_array('category', $this->taxonomies) || $this->post_type_name === 'post') {
                    $after = 'categories';
                } elseif (post_type_supports($this->post_type_name, 'author')) {
                    $after = 'author';
                } else {
                    $after = 'title';
                }
                foreach ($columns as $key => $title) {
                    $new_columns[$key] = $title;
                    if ($key === $after) {
                        if (is_array($this->taxonomies)) {
                            foreach ($this->taxonomies as $tax) {
                                if ($tax !== 'category' && $tax !== 'post_tag') {
                                    $taxonomy_object = get_taxonomy($tax);
                                    $new_columns[$tax] = sprintf(__('%s', $this->textdomain), $taxonomy_object->labels->name);
                                }
                            }
                        }
                    }
                }
                $columns = $new_columns;
            } else {
                $columns = $this->columns;
            }
            return $columns;
        }
        
        function populate_admin_columns($column, $post_id)
        {
            global $post;
            switch ($column) {
                case (taxonomy_exists($column)) :
                    $terms = get_the_terms($post_id, $column);
                    if (!empty($terms)) {
                        $output = array();
                        foreach ($terms as $term) {
                            $output[] = sprintf(
                                '<a href="%s">%s</a>',
                                esc_url(add_query_arg(array('post_type' => $post->post_type, $column => $term->slug), 'edit.php')),
                                esc_html(sanitize_term_field('name', $term->name, $term->term_id, $column, 'display'))
                            );
                        }
                        echo join(', ', $output);
                    } else {
                        $taxonomy_object = get_taxonomy($column);
                        printf(__('No %s', $this->textdomain), $taxonomy_object->labels->name);
                    }
                    break;
                case 'post_id' :
                    echo $post->ID;
                    break;
                case (preg_match('/^meta_/', $column) ? true : false) :
                    $x = substr($column, 5);
                    $meta = get_post_meta($post->ID, $x);
                    echo join(", ", $meta);
                    break;
                case 'icon' :
                    $link = esc_url(add_query_arg(array('post' => $post->ID, 'action' => 'edit'), 'post.php'));
                    if (has_post_thumbnail()) {
                        echo '<a href="' . $link . '">';
                        the_post_thumbnail(array(60, 60));
                        echo '</a>';
                    } else {
                        echo '<a href="' . $link . '"><img src="' . site_url('/wp-includes/images/crystal/default.png') . '" alt="' . $post->post_title . '" /></a>';
                    }
                    break;
                default :
                    if (isset($this->custom_populate_columns) && is_array($this->custom_populate_columns)) {
                        if (isset($this->custom_populate_columns[$column]) && is_callable($this->custom_populate_columns[$column])) {
                            call_user_func_array($this->custom_populate_columns[$column], array($column, $post));
                        }
                    }
                    break;
            }
        }
        
        function filters($filters = array())
        {
            $this->filters = $filters;
        }
        
        function add_taxonomy_filters()
        {
            global $typenow;
            global $wp_query;
            if ($typenow == $this->post_type_name) {
                if (is_array($this->filters)) {
                    $filters = $this->filters;
                } else {
                    $filters = $this->taxonomies;
                }
                if (!empty($filters)) {
                    foreach ($filters as $tax_slug) {
                        $tax = get_taxonomy($tax_slug);
                        $args = array(
                            'orderby' => 'name',
                            'hide_empty' => false,
                        );
                        $terms = get_terms($tax_slug, $args);
                        if ($terms) {
                            printf(' &nbsp;<select name="%s" class="postform">', $tax_slug);
                            printf('<option value="0">%s</option>', sprintf(__('Show all %s', $this->textdomain), $tax->label));
                            foreach ($terms as $term) {
                                if (isset($_GET[$tax_slug]) && $_GET[$tax_slug] === $term->slug) {
                                    printf('<option value="%s" selected="selected">%s (%s)</option>', $term->slug, $term->name, $term->count);
                                } else {
                                    printf('<option value="%s">%s (%s)</option>', $term->slug, $term->name, $term->count);
                                }
                            }
                            print('</select>&nbsp;');
                        }
                    }
                }
            }
        }
        
        function columns($columns)
        {
            if (isset($columns)) {
                $this->columns = $columns;
            }
        }
        
        function populate_column($column_name, $callback)
        {
            $this->custom_populate_columns[$column_name] = $callback;
        }
        
        function sortable($columns = array())
        {
            $this->sortable = $columns;
            $this->add_filter('manage_edit-' . $this->post_type_name . '_sortable_columns', array(&$this, 'make_columns_sortable'));
            $this->add_action('load-edit.php', array(&$this, 'load_edit'));
        }
        
        function make_columns_sortable($columns)
        {
            foreach ($this->sortable as $column => $values) {
                $sortable_columns[$column] = $values[0];
            }
            $columns = array_merge($sortable_columns, $columns);
            return $columns;
        }
        
        function load_edit()
        {
            $this->add_filter('request', array(&$this, 'sort_columns'));
        }
        
        function sort_columns($vars)
        {
            foreach ($this->sortable as $column => $values) {
                $meta_key = $values[0];
                if (taxonomy_exists($meta_key)) {
                    $key = "taxonomy";
                } else {
                    $key = "meta_key";
                }
                if (isset($values[1]) && true === $values[1]) {
                    $orderby = 'meta_value_num';
                } else {
                    $orderby = 'meta_value';
                }
                if (isset($vars['post_type']) && $this->post_type_name == $vars['post_type']) {
                    if (isset($vars['orderby']) && $meta_key == $vars['orderby']) {
                        $vars = array_merge(
                            $vars,
                            array(
                                'meta_key' => $meta_key,
                                'orderby' => $orderby,
                            )
                        );
                    }
                }
            }
            return $vars;
        }
        
        function menu_icon($icon = "dashicons-admin-page")
        {
            if (is_string($icon) && stripos($icon, "dashicons") !== false) {
                $this->options["menu_icon"] = $icon;
            } else {
                $this->options["menu_icon"] = "dashicons-admin-page";
            }
        }
        
        function set_textdomain($textdomain)
        {
            $this->textdomain = $textdomain;
        }
        
        function updated_messages($messages)
        {
            $post = get_post();
            $singular = $this->singular;
            $messages[$this->post_type_name] = array(
                0 => '',
                1 => sprintf(__('%s updated.', $this->textdomain), $singular),
                2 => __('Custom field updated.', $this->textdomain),
                3 => __('Custom field deleted.', $this->textdomain),
                4 => sprintf(__('%s updated.', $this->textdomain), $singular),
                5 => isset($_GET['revision']) ? sprintf(__('%2$s restored to revision from %1$s', $this->textdomain), wp_post_revision_title((int)$_GET['revision'], false), $singular) : false,
                6 => sprintf(__('%s updated.', $this->textdomain), $singular),
                7 => sprintf(__('%s saved.', $this->textdomain), $singular),
                8 => sprintf(__('%s submitted.', $this->textdomain), $singular),
                9 => sprintf(
                    __('%2$s scheduled for: <strong>%1$s</strong>.', $this->textdomain),
                    date_i18n(__('M j, Y @ G:i', $this->textdomain), strtotime($post->post_date)),
                    $singular
                ),
                10 => sprintf(__('%s draft updated.', $this->textdomain), $singular),
            );
            return $messages;
        }
        
        function bulk_updated_messages($bulk_messages, $bulk_counts)
        {
            $singular = $this->singular;
            $plural = $this->plural;
            $bulk_messages[$this->post_type_name] = array(
                'updated' => _n('%s ' . $singular . ' updated.', '%s ' . $plural . ' updated.', $bulk_counts['updated']),
                'locked' => _n('%s ' . $singular . ' not updated, somebody is editing it.', '%s ' . $plural . ' not updated, somebody is editing them.', $bulk_counts['locked']),
                'deleted' => _n('%s ' . $singular . ' permanently deleted.', '%s ' . $plural . ' permanently deleted.', $bulk_counts['deleted']),
                'trashed' => _n('%s ' . $singular . ' moved to the Trash.', '%s ' . $plural . ' moved to the Trash.', $bulk_counts['trashed']),
                'untrashed' => _n('%s ' . $singular . ' restored from the Trash.', '%s ' . $plural . ' restored from the Trash.', $bulk_counts['untrashed']),
            );
            return $bulk_messages;
        }
        
        function flush()
        {
            flush_rewrite_rules();
        }
    }
