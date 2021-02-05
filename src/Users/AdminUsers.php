<?php

namespace Sideways\Classic\Users;

class AdminUsers {
    public function run(): void {
        $this->define_init_roles();
        $this->add_to_default_blog_when_created_from_network();
    }

    private function define_init_roles(): void {

        add_action(
            'init',
            static function () {
                global $wp_roles;

                if ( ! isset( $wp_roles ) ) {
                    $wp_roles = new WP_Roles();
                }

                $roles = $wp_roles->get_names();

                remove_role( 'subscriber' );
                remove_role( 'contributor' );
                remove_role( 'author' );

                if ( ! key_exists( 'sitecreator', $roles ) ) {
                    $admin_role = $wp_roles->get_role( 'administrator' );

                    add_role( 'sitecreator', 'Site Creator', $admin_role->capabilities );

                    add_role( 'cmsadmin', 'CMS Admin', $admin_role->capabilities );

                    $wp_roles->roles['editor']['name'] = 'CMS Editor';
                    $wp_roles->role_names['editor']    = 'CMS Editor';

                    /*  For adding new caps after cloning/editing... this is an example adding new cap for $admin_role
                        $admin_role->add_cap( 'h_grapql' );
                    */
                }
            },
            1
        );
    }

    private function add_to_default_blog_when_created_from_network(): void {

        add_action(
            'network_user_new_created_user',
            function ( $user_id ) {
                $blog_id = 1;
                add_user_to_blog( $blog_id, $user_id, 'editor' );
            },
            999,
            1
        );
    }

}
