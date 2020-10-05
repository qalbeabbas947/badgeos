<?php 
    $badgeos_settings = get_option( 'badgeos_settings' );
    
    //load settings
    $minimum_role = ( isset( $badgeos_settings['minimum_role'] ) ) ? $badgeos_settings['minimum_role'] : 'manage_options';
    $debug_mode = ( isset( $badgeos_settings['debug_mode'] ) ) ? $badgeos_settings['debug_mode'] : 'disabled';
    $log_entries = ( isset( $badgeos_settings['log_entries'] ) ) ? $badgeos_settings['log_entries'] : 'disabled';
    $ms_show_all_achievements = ( isset( $badgeos_settings['ms_show_all_achievements'] ) ) ? $badgeos_settings['ms_show_all_achievements'] : 'disabled';
    $ms_show_all_ranks = ( isset( $badgeos_settings['ms_show_all_ranks'] ) ) ? $badgeos_settings['ms_show_all_ranks'] : 'disabled';
    $ms_show_all_points = ( isset( $badgeos_settings['ms_show_all_points'] ) ) ? $badgeos_settings['ms_show_all_points'] : 'disabled';
    $ms_show_all_settings = ( isset( $badgeos_settings['ms_show_all_settings'] ) ) ? $badgeos_settings['ms_show_all_settings'] : 'disabled';
            
    $remove_data_on_uninstall = ( isset( $badgeos_settings['remove_data_on_uninstall'] ) ) ? $badgeos_settings['remove_data_on_uninstall'] : '';
    $badgeos_achievement_global_image_width 	= ( ! empty ( $badgeos_settings['badgeos_achievement_global_image_width'] ) ) ? $badgeos_settings['badgeos_achievement_global_image_width'] : '50';
    $badgeos_achievement_global_image_height = ( ! empty ( $badgeos_settings['badgeos_achievement_global_image_height'] ) ) ? $badgeos_settings['badgeos_achievement_global_image_height'] : '50';
    $badgeos_rank_global_image_width 		= ( ! empty ( $badgeos_settings['badgeos_rank_global_image_width'] ) ) ? $badgeos_settings['badgeos_rank_global_image_width'] : '50';
    $badgeos_rank_global_image_height 		= ( ! empty ( $badgeos_settings['badgeos_rank_global_image_height'] ) ) ? $badgeos_settings['badgeos_rank_global_image_height'] : '50';
    $badgeos_point_global_image_width 		= ( ! empty ( $badgeos_settings['badgeos_point_global_image_width'] ) ) ? $badgeos_settings['badgeos_point_global_image_width'] : '32';
    $badgeos_point_global_image_height 		= ( ! empty ( $badgeos_settings['badgeos_point_global_image_height'] ) ) ? $badgeos_settings['badgeos_point_global_image_height'] : '32';
     
    $achievement_list_default_view 	= ( ! empty ( $badgeos_settings['achievement_list_shortcode_default_view'] ) ) ? $badgeos_settings['achievement_list_shortcode_default_view'] : 'list';
    $earned_achievements_shortcode_default_view 	= ( ! empty ( $badgeos_settings['earned_achievements_shortcode_default_view'] ) ) ? $badgeos_settings['earned_achievements_shortcode_default_view'] : 'list';
    $earned_ranks_shortcode_default_view 	= ( ! empty ( $badgeos_settings['earned_ranks_shortcode_default_view'] ) ) ? $badgeos_settings['earned_ranks_shortcode_default_view'] : 'list';
    $badgeos_admin_side_tab 	= ( ! empty ( $badgeos_settings['side_tab'] ) ) ? $badgeos_settings['side_tab'] : '#badgeos_settings_general_settings';
    $date_of_birth_from 	= ( ! empty ( $badgeos_settings['date_of_birth_from'] ) ) ? $badgeos_settings['date_of_birth_from'] : 'profile';
    ob_start();
    do_action( 'badgeos_settings', $badgeos_settings );
    $addon_contents = ob_get_clean();
?>
<div id="badgeos-setting-tabs">
    <div class="tab-title"><?php _e( 'General', 'badgeos' ); ?></div>
    <?php settings_errors(); ?>
    <form method="POST" name="badgeos_frm_general_tab" id="badgeos_frm_general_tab" action="options.php">
        <input type="hidden" id="tab_action" name="badgeos_settings[tab_action]" value="general" />
        <input type="hidden" id="badgeos_admin_side_tab" name="badgeos_settings[side_tab]" value="<?php echo $badgeos_admin_side_tab;?>" />
        <ul class="badgeos_sidebar_tab_links">
            <li>
                <a href="#badgeos_settings_general_settings">
                    &nbsp;&nbsp;&nbsp;&nbsp;<i class="fa fa-table" aria-hidden="true"></i>&nbsp;&nbsp;
                    <?php _e( 'General Settings', 'badgeos' ); ?>
                </a>
            </li>
            <li>
                <a href="#badgeos_settings_default_views">
                    &nbsp;&nbsp;&nbsp;&nbsp;<i class="fa fa-street-view" aria-hidden="true"></i>&nbsp;&nbsp;
                    <?php _e( 'Default Views', 'badgeos' ); ?>
                </a>
            </li>
            <li>
                <a href="#badgeos_settings_thumb_sizes">
                    &nbsp;&nbsp;&nbsp;&nbsp;<i class="fa fa-futbol-o" aria-hidden="true"></i>&nbsp;&nbsp;
                    <?php _e( 'Thumbnail Sizes', 'badgeos' ); ?>
                </a>
            </li> 
            <?php 
            if ( is_super_admin() ){
                if ( is_multisite() ) { ?>
                    <li>
                        <a href="#badgeos_settings_multisite_settings">
                            &nbsp;&nbsp;&nbsp;&nbsp;<i class="fa fa-empire" aria-hidden="true"></i>&nbsp;&nbsp;
                            <?php _e( "Multisite", 'badgeos' ); ?>
                        </a>
                    </li>
                <?php } ?>
            <?php } ?>
            <?php if( ! empty( $addon_contents ) ) { ?>
                <li>
                    <a href="#badgeos_settings_addon_settings">
                        &nbsp;&nbsp;&nbsp;&nbsp;<i class="fa fa-empire" aria-hidden="true"></i>&nbsp;&nbsp;
                        <?php _e( "Addon's Settings", 'badgeos' ); ?>
                    </a>
                </li>
            <?php } ?>
            <?php do_action( 'badgeos_general_settings_tab_header', $badgeos_settings ); ?>
        </ul>
        <div id="badgeos_settings_general_settings">
            <?php 
                settings_fields( 'badgeos_settings_group' ); 
                wp_nonce_field( 'badgeos_settings_nonce', 'badgeos_settings_nonce' );
            ?>
            <table cellspacing="0" width="100%">
                <tbody>
                    <?php if ( current_user_can( 'manage_options' ) ) { ?>
                        <tr valign="top"><th scope="row" width="50%"><label for="minimum_role"><?php _e( 'Minimum Role to Administer BadgeOS plugin: ', 'badgeos' ); ?></label></th>
                            <td width="50%">
                                <select id="minimum_role" name="badgeos_settings[minimum_role]">
                                    <option value="manage_options" <?php selected( $minimum_role, 'manage_options' ); ?>><?php _e( 'Administrator', 'badgeos' ); ?></option>
                                    <option value="delete_others_posts" <?php selected( $minimum_role, 'delete_others_posts' ); ?>><?php _e( 'Editor', 'badgeos' ); ?></option>
                                    <option value="publish_posts" <?php selected( $minimum_role, 'publish_posts' ); ?>><?php _e( 'Author', 'badgeos' ); ?></option>
                                </select>
                            </td>
                        </tr>
                    <?php } ?>
                    <tr valign="top"><th scope="row"><label for="remove_data_on_uninstall"><?php _e( 'Delete Data on Uninstall:', 'badgeos' ); ?></label></th>
                        <td>
                            <input id="remove_data_on_uninstall" name="badgeos_settings[remove_data_on_uninstall]" type="checkbox" <?php echo ( $remove_data_on_uninstall == "on" ) ? "checked" : ""; ?> class="regular-text" />
                            <p class="description"><?php _e( 'It will delete all BadgeOS DB entries on uninstall including posts, setting options, usermeta', 'badgeos' ); ?></p>
                        </td>
                    </tr>
                    <tr valign="top"><th scope="row"><label for="debug_mode"><?php _e( 'Debug Mode:', 'badgeos' ); ?></label></th>
                        <td>
                            <select id="debug_mode" name="badgeos_settings[debug_mode]">
                                <option value="disabled" <?php selected( $debug_mode, 'disabled' ); ?>><?php _e( 'Disabled', 'badgeos' ) ?></option>
                                <option value="enabled" <?php selected( $debug_mode, 'enabled' ); ?>><?php _e( 'Enabled', 'badgeos' ) ?></option>
                            </select>
                        </td>
                    </tr>
                    <tr valign="top"><th scope="row"><label for="log_entries"><?php _e( 'Log Entries:', 'badgeos' ); ?></label></th>
                        <td>
                            <select id="log_entries" name="badgeos_settings[log_entries]">
                                <option value="disabled" <?php selected( $log_entries, 'disabled' ); ?>><?php _e( 'Disabled', 'badgeos' ) ?></option>
                                <option value="enabled" <?php selected( $log_entries, 'enabled' ); ?>><?php _e( 'Enabled', 'badgeos' ) ?></option>
                            </select>
                        </td>
                    </tr>
                    <?php if( class_exists( 'BuddyPress' )  ) { ?>
                        <tr valign="top">
                            <th scope="row"><label for="date_of_birth_from"><?php _e( 'DOB From:', 'badgeos' ); ?></label></th>
                            <td>
                                <select id="badgeos_date_of_birth_from" name="badgeos_settings[date_of_birth_from]">
                                    <option value="profile" selected><?php _e( 'Profile Page', 'badgeos' ) ?></option>
                                    <option value="buddypress" <?php selected( $date_of_birth_from, 'buddypress' ); ?>><?php _e( 'Buddypress', 'badgeos' ) ?></option>
                                </select>
                            </td>
                        </tr>
                    <?php } ?>
                    <?php do_action( 'badgeos_general_settings_fields', $badgeos_settings ); ?>
                </tbody>
            </table>
            <input type="submit" name="badgeos_settings_update_btn" class="button button-primary" value="<?php _e( 'Save Settings', 'badgeos' ); ?>">
        </div>
        <div id="badgeos_settings_default_views">
            <table cellspacing="0">
                <tbody>
                    <tr valign="top">
                        <th scope="row"><label for="achievement_list_shortcode_default_view"><?php _e( 'Achievement List Shortcode Default View:', 'badgeos' ); ?></label></th>
                        <td>
                            <select id="achievement_list_shortcode_default_view" name="badgeos_settings[achievement_list_shortcode_default_view]">
                                <option value="list" <?php selected( $achievement_list_default_view, "list" ); ?>><?php _e( 'List', 'badgeos' ); ?></option>
                                <option value="grid" <?php selected( $achievement_list_default_view, "grid" ); ?>><?php _e( 'Grid', 'badgeos' ); ?></option>
                            </select>
                        </td>
                    </tr>
                    <tr valign="top">
                        <th scope="row"><label for="earned_achievements_shortcode_default_view"><?php _e( 'Earned Achievements Shortcode Default View:', 'badgeos' ); ?></label></th>
                        <td>
                            <select id="earned_achievements_shortcode_default_view" name="badgeos_settings[earned_achievements_shortcode_default_view]">
                                <option value="list" <?php selected( $earned_achievements_shortcode_default_view, "list" ); ?>><?php _e( 'List', 'badgeos' ); ?></option>
                                <option value="grid" <?php selected( $earned_achievements_shortcode_default_view, "grid" ); ?>><?php _e( 'Grid', 'badgeos' ); ?></option>
                            </select>
                        </td>
                    </tr>
                    <tr valign="top">
                        <th scope="row"><label for="earned_ranks_shortcode_default_view"><?php _e( 'Earned Ranks List Shortcode Default View:', 'badgeos' ); ?></label></th>
                        <td>
                            <select id="earned_ranks_shortcode_default_view" name="badgeos_settings[earned_ranks_shortcode_default_view]">
                                <option value="list" <?php selected( $earned_ranks_shortcode_default_view, "list" ); ?>><?php _e( 'List', 'badgeos' ); ?></option>
                                <option value="grid" <?php selected( $earned_ranks_shortcode_default_view, "grid" ); ?>><?php _e( 'Grid', 'badgeos' ); ?></option>
                            </select>
                        </td>
                    </tr>
                    <?php do_action( 'badgeos_general_settings_default_view_fields', $badgeos_settings ); ?>
                </tbody>
            </table>
            <input type="submit" name="badgeos_settings_update_btn" class="button button-primary" value="<?php _e( 'Save Settings', 'badgeos' ); ?>">
        </div>
        <div id="badgeos_settings_thumb_sizes">
            <table cellspacing="0">
                <tbody>
                    <tr valign="top">
                        <th scope="row"><label for="badgeos_achievement_global_image_width"><?php _e( 'Achievement Image Size:', 'badgeos' ); ?></label></th>
                        <td>
                            <label>
                                <?php _e( 'Width:', 'badgeos' ); ?>
                                <input type="number" id="badgeos_achievement_global_image_width" value="<?php echo $badgeos_achievement_global_image_width;?>" name="badgeos_settings[badgeos_achievement_global_image_width]" />
                            </label>
                            <label>
                                <?php _e( 'Height:', 'badgeos' ); ?>
                                <input type="number" id="badgeos_achievement_global_image_height" value="<?php echo $badgeos_achievement_global_image_height;?>" name="badgeos_settings[badgeos_achievement_global_image_height]" />
                            </label>
                        </td>
                    </tr>
                    <tr valign="top">
                        <th scope="row"><label for="badgeos_rank_global_image_width"><?php _e( 'Rank Image Size:', 'badgeos' ); ?></label></th>
                        <td>
                            <label>
                                <?php _e( 'Width:', 'badgeos' ); ?>
                                <input type="number" id="badgeos_rank_global_image_width" value="<?php echo $badgeos_rank_global_image_width;?>" name="badgeos_settings[badgeos_rank_global_image_width]" />
                            </label>
                            <label>
                                <?php _e( 'Height:', 'badgeos' ); ?>
                                <input type="number" id="badgeos_rank_global_image_height" value="<?php echo $badgeos_rank_global_image_height;?>" name="badgeos_settings[badgeos_rank_global_image_height]" />
                            </label>
                        </td>
                    </tr>
                    
                    <tr valign="top">
                        <th scope="row"><label for="badgeos_point_global_image_width"><?php _e( 'Point Image Size:', 'badgeos' ); ?></label></th>
                        <td>
                            <label>
                                <?php _e( 'Width:', 'badgeos' ); ?>
                                <input type="number" id="badgeos_point_global_image_width" value="<?php echo $badgeos_point_global_image_width;?>" name="badgeos_settings[badgeos_point_global_image_width]" />
                            </label>
                            <label>
                                <?php _e( 'Height:', 'badgeos' ); ?>
                                <input type="number" id="badgeos_point_global_image_height" value="<?php echo $badgeos_point_global_image_height;?>" name="badgeos_settings[badgeos_point_global_image_height]" />
                            </label>
                        </td>
                    </tr>
                    <?php do_action( 'badgeos_general_settings_thumb_size_fields', $badgeos_settings ); ?>
                </tbody>
            </table>
            <input type="submit" name="badgeos_settings_update_btn" class="button button-primary" value="<?php _e( 'Save Settings', 'badgeos' ); ?>">
        </div>
        <?php 
            if ( is_super_admin() ){
                if ( is_multisite() ) { ?>
                <div id="badgeos_settings_multisite_settings">
                    <table cellspacing="0">
                        <tbody>
                            <tr valign="top">
                                <th scope="row"><label for="ms_show_all_achievements"><?php _e( 'Show achievements earned across all sites:', 'badgeos' ); ?></label></th>
                                <td>
                                    <select id="ms_show_all_achievements" name="badgeos_settings[ms_show_all_achievements]">
                                        <option value="disabled" <?php selected( $ms_show_all_achievements, 'disabled' ); ?>><?php _e( 'Disabled', 'badgeos' ) ?></option>
                                        <option value="enabled" <?php selected( $ms_show_all_achievements, 'enabled' ); ?>><?php _e( 'Enabled', 'badgeos' ) ?></option>
                                    </select>
                                </td>
                            </tr>
                            <tr valign="top">
                                <th scope="row"><label for="ms_show_all_ranks"><?php _e( 'Show ranks earned across all sites:', 'badgeos' ); ?></label></th>
                                <td>
                                    <select id="ms_show_all_ranks" name="badgeos_settings[ms_show_all_ranks]">
                                        <option value="disabled" <?php selected( $ms_show_all_ranks, 'disabled' ); ?>><?php _e( 'Disabled', 'badgeos' ) ?></option>
                                        <option value="enabled" <?php selected( $ms_show_all_ranks, 'enabled' ); ?>><?php _e( 'Enabled', 'badgeos' ) ?></option>
                                    </select>
                                </td>
                            </tr>
                            <tr valign="top">
                                <th scope="row"><label for="ms_show_all_points"><?php _e( 'Show points earned across all sites:', 'badgeos' ); ?></label></th>
                                <td>
                                    <select id="ms_show_all_points" name="badgeos_settings[ms_show_all_points]">
                                        <option value="disabled" <?php selected( $ms_show_all_points, 'disabled' ); ?>><?php _e( 'Disabled', 'badgeos' ) ?></option>
                                        <option value="enabled" <?php selected( $ms_show_all_points, 'enabled' ); ?>><?php _e( 'Enabled', 'badgeos' ) ?></option>
                                    </select>
                                </td>
                            </tr>
                            <tr valign="top">
                                <th scope="row"><label for="ms_show_all_settings"><?php _e( 'Same BadgeOS settings across all sites:', 'badgeos' ); ?></label></th>
                                <td>
                                    <select id="ms_show_all_settings" name="badgeos_settings[ms_show_all_settings]">
                                        <option value="disabled" <?php selected( $ms_show_all_settings, 'disabled' ); ?>><?php _e( 'Disabled', 'badgeos' ) ?></option>
                                        <option value="enabled" <?php selected( $ms_show_all_settings, 'enabled' ); ?>><?php _e( 'Enabled', 'badgeos' ) ?></option>
                                    </select>
                                </td>
                            </tr>
                            <?php do_action( 'badgeos_general_settings_multisite_fields', $badgeos_settings ); ?>
                        </tbody>
                    </table>
                    <input type="submit" name="badgeos_settings_update_btn" class="button button-primary" value="<?php _e( 'Save Settings', 'badgeos' ); ?>">
                </div>
            <?php } ?>
        <?php } ?>
        <?php if( ! empty( $addon_contents ) ) { ?>
            <div id="badgeos_settings_addon_settings">
                <table cellspacing="0">
                    <tbody>
                        <?php do_action( 'badgeos_settings', $badgeos_settings ); ?>
                    </tbody>
                </table>
                <input type="submit" name="badgeos_settings_update_btn" class="button button-primary" value="<?php _e( 'Save Settings', 'badgeos' ); ?>">
            </div>
        <?php } ?>
        <?php do_action( 'badgeos_general_settings_tab_content', $badgeos_settings ); ?>
    </form>
</div>