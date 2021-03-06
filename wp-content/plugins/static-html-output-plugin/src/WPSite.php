<?php

namespace StaticHTMLOutput;

class WPSite {

    /**
     * @var string
     */
    public $uploads_url;
    /**
     * @var string
     */
    public $site_url;
    /**
     * @var string
     */
    public $parent_theme_url;
    /**
     * @var string
     */
    public $wp_content_url;
    /**
     * @var string
     */
    public $site_path;
    /**
     * @var string
     */
    public $plugins_path;
    /**
     * @var string
     */
    public $wp_uploads_path;
    /**
     * @var string
     */
    public $wp_includes_path;
    /**
     * @var string
     */
    public $wp_content_path;
    /**
     * @var string
     */
    public $theme_root_path;
    /**
     * @var string
     */
    public $parent_theme_path;
    /**
     * @var string
     */
    public $child_theme_path;
    /**
     * @var bool
     */
    public $child_theme_active;
    /**
     * @var mixed
     */
    public $permalink_structure;
    /**
     * @var string
     */
    public $wp_inc;
    /**
     * @var string
     */
    public $wp_content;
    /**
     * @var string
     */
    public $wp_uploads;
    /**
     * @var string
     */
    public $wp_plugins;
    /**
     * @var string
     */
    public $wp_themes;
    /**
     * @var string
     */
    public $wp_active_theme;
    /**
     * @var string
     */
    public $subdirectory;
    /**
     * @var string
     */
    public $wp_site_subdir;
    /**
     * @var string
     */
    public $wp_site_path;
    /**
     * @var string
     */
    public $wp_site_url;
    /**
     * @var string
     */
    public $wp_uploads_url;
    /**
     * @var bool
     */
    public $uploads_writable;
    /**
     * @var bool
     */
    public $permalinks_set;
    /**
     * @var bool
     */
    public $curl_enabled;

    public function __construct() {
        $wp_upload_path_and_url = wp_upload_dir();
        $this->uploads_url = $wp_upload_path_and_url['baseurl'];
        $this->site_url = get_home_url() . '/';
        $this->parent_theme_url = get_template_directory_uri();
        $this->wp_content_url = content_url();
        $this->site_path = wp_normalize_path( ABSPATH );
        $this->plugins_path = wp_normalize_path( $this->getWPDirFullPath( 'plugins' ) );
        $this->wp_uploads_path = wp_normalize_path( $this->getWPDirFullPath( 'uploads' ) );
        $this->wp_includes_path = wp_normalize_path( $this->getWPDirFullPath( 'wp-includes' ) );
        $this->wp_content_path = wp_normalize_path( $this->getWPDirFullPath( 'wp-content' ) );
        $this->theme_root_path = wp_normalize_path( $this->getWPDirFullPath( 'theme-root' ) );
        $this->parent_theme_path = wp_normalize_path( $this->getWPDirFullPath( 'parent-theme' ) );
        $this->child_theme_path = wp_normalize_path( $this->getWPDirFullPath( 'child-theme' ) );
        $this->child_theme_active =
            $this->parent_theme_path !== $this->child_theme_path;

        $this->permalink_structure = get_option( 'permalink_structure' );

        $this->wp_inc = '/' . WPINC;

        $this->wp_content = wp_normalize_path( WP_CONTENT_DIR );
        $this->wp_uploads =
                str_replace( ABSPATH, '/', $this->wp_uploads_path );
        $this->wp_plugins = str_replace( ABSPATH, '/', WP_PLUGIN_DIR );
        $this->wp_themes = str_replace( ABSPATH, '/', get_theme_root() );
        $this->wp_active_theme =
            str_replace( home_url(), '', get_template_directory_uri() );

        $this->detect_base_url();

        $this->subdirectory = $this->isSiteInstalledInSubDirectory();

        // TODO: rm these once refactored to use consistent naming
        $this->wp_site_subdir = $this->subdirectory;
        $this->wp_site_url = $this->site_url;
        $this->wp_site_path = $this->site_path;
        $this->wp_uploads_url = $this->uploads_url;

        $this->uploads_writable = $this->uploadsPathIsWritable();
        $this->permalinks_set = $this->permalinksAreDefined();
        $this->curl_enabled = $this->hasCurlSupport();
    }

    public function __toString() {
        $wpsite_string = "";

        $wpsite_string .= "Site Path: $this->site_path" . PHP_EOL;
        $wpsite_string .= "WP Uploads URL: $this->wp_uploads_url" . PHP_EOL;
        $wpsite_string .= "WP Uploads Path: $this->wp_uploads_path" . PHP_EOL;
        $wpsite_string .= "WP Uploads ??: $this->wp_uploads" . PHP_EOL;
        $wpsite_string .= "WP Site Path: $this->wp_site_path" . PHP_EOL;
        $wpsite_string .= "WP Site Subdirectory: $this->wp_site_subdir" . PHP_EOL;
        $wpsite_string .= "Uploads URL: $this->uploads_url" . PHP_EOL;
        $wpsite_string .= "Site URL: $this->site_url" . PHP_EOL;
        $wpsite_string .= "Parent Theme URL: $this->parent_theme_url" . PHP_EOL;
        $wpsite_string .= "Parent Theme Path: $this->parent_theme_path" . PHP_EOL;
        $wpsite_string .= "Child Theme Path: $this->child_theme_path" . PHP_EOL;
        $wpsite_string .= "Child Theme Active: $this->child_theme_active" . PHP_EOL;
        $wpsite_string .= "Theme Root Path: $this->theme_root_path" . PHP_EOL;
        $wpsite_string .= "Themes ??: $this->wp_themes" . PHP_EOL;
        $wpsite_string .= "Active Theme ??: $this->wp_active_theme" . PHP_EOL;
        $wpsite_string .= "WP Content URL: $this->wp_content_url" . PHP_EOL;
        $wpsite_string .= "WP Content Path: $this->wp_content_path" . PHP_EOL;
        $wpsite_string .= "WP Content ??: $this->wp_content" . PHP_EOL;
        $wpsite_string .= "Plugins Path: $this->plugins_path" . PHP_EOL;
        $wpsite_string .= "WP Plugins ??: $this->wp_plugins" . PHP_EOL;
        $wpsite_string .= "WP Includes Path: $this->wp_includes_path" . PHP_EOL;
        $wpsite_string .= "Permalink Structure: $this->permalink_structure" . PHP_EOL;
        $wpsite_string .= "WP Inc Path: $this->wp_inc" . PHP_EOL;
        $wpsite_string .= "Subdirectory install?: $this->subdirectory" . PHP_EOL;

        return $wpsite_string;
    }

    public function isSiteInstalledInSubDirectory() : string {
        $parsed_site_url = parse_url( rtrim( $this->site_url, '/' ) );

        if ( ! is_array( $parsed_site_url ) ) {
            return '';
        }

        if ( array_key_exists( 'path', $parsed_site_url ) ) {
            return $parsed_site_url['path'];
        }

        return '';
    }

    public function uploadsPathIsWritable() : bool {
        return $this->wp_uploads_path && is_writable( $this->wp_uploads_path );
    }

    public function hasCurlSupport() : bool {
        return extension_loaded( 'curl' );
    }

    public function permalinksAreDefined() : bool {
        return strlen( get_option( 'permalink_structure' ) ) > 0;
    }

    public function detect_base_url() : void {
        $site_url = get_option( 'siteurl' );
        $home = get_option( 'home' );
    }

    /*
        Function below assumes people may have changed the default
        paths for WP directories

        ie,
            don't assume wp-contents is a subdir of ABSPATH
            don't asssume uploads is a subdir of wp-contents or even 'uploads'
    */
    public function getWPDirFullPath( string $wp_dir ) : string {
        $full_path = '';

        switch ( $wp_dir ) {
            case 'wp-content':
                $full_path = WP_CONTENT_DIR;

                break;

            case 'uploads':
                $upload_dir_info = wp_upload_dir();
                $full_path = $upload_dir_info['basedir'];

                break;

            case 'wp-includes':
                $full_path = ABSPATH . WPINC;

                break;

            case 'plugins':
                $full_path = WP_PLUGIN_DIR;

                break;

            case 'theme-root':
                $full_path = get_theme_root();

                break;

            case 'parent-theme':
                $full_path = get_template_directory();

                break;

            case 'child-theme':
                $full_path = get_stylesheet_directory();

                break;
        }

        return rtrim( $full_path, '/' );
    }

    public function getWPDirNameOnly( string $wp_dir ) : string {
        $wp_dir_name = '';

        switch ( $wp_dir ) {
            case 'child-theme':
            case 'parent-theme':
            case 'wp-content':
            case 'wp-includes':
            case 'uploads':
            case 'theme-root':
            case 'plugins':
                $wp_dir_name = $this->getLastPathSegment(
                    $this->getWPDirFullPath( $wp_dir )
                );

                break;

        }

        return rtrim( $wp_dir_name, '/' );
    }

    public function getLastPathSegment( string $path ) : string {
        $path_segments = explode( '/', $path );

        return (string) end( $path_segments );
    }

    /*
        For when we have a site like domain.com
        and wp-content themes and plugins are under /wp/
    */
    public function getWPContentSubDirectory() : string {
        $parsed_url = parse_url( $this->parent_theme_url );

        if ( ! is_array( $parsed_url ) ) {
            return '';
        }

        if ( ! array_key_exists( 'path', $parsed_url ) ) {
            return '';
        }

        $path_segments = explode( '/', $parsed_url['path'] );

        /*
            Returns:

            [0] =>
            [1] => wp
            [2] => wp-content
            [3] => themes
            [4] => twentyseventeen

        */

        if ( count( $path_segments ) === 5 ) {
            return $path_segments[1] . '/';
        } else {
            return '';
        }
    }
}

