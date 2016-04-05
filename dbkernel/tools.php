<?php

class Tools
{
    static function amountofusers()
    {
        global $connection;
        $result = pg_query($connection, 'select count(*) as amount from "Lift_User"');
        $result = pg_fetch_row($result)[0];
        return $result;
    }

    static function createsuperuser()
    {
        global $connection;

        $data = [
            "id"   => "1",
            "name" => "admins",
        ];

        $result = pg_insert($connection, "Lift_User_group", $data);

        $data = [
            "id"   => "2",
            "name" => "users",
        ];

        $result = pg_insert($connection, "Lift_User_group", $data);

        $data = [
            "group"    => 1,
            "class"    => "Lift_User",
            "function" => "read",
        ];

        $result = pg_insert($connection, "Lift_ACL", $data);

        $data = [
            "group"    => 1,
            "class"    => "Lift_User",
            "function" => "create",
        ];

        $result = pg_insert($connection, "Lift_ACL", $data);

        $data = [
            "group"    => 1,
            "class"    => "Lift_User",
            "function" => "update",
        ];

        $result = pg_insert($connection, "Lift_ACL", $data);

        $data = [
            "group"    => 1,
            "class"    => "Lift_User",
            "function" => "delete",
        ];

        $result = pg_insert($connection, "Lift_ACL", $data);


        $data = [
            "group"    => 1,
            "class"    => "Lift_User",
            "function" => "readAll",
        ];

        $result = pg_insert($connection, "Lift_ACL", $data);

        $data = [
            "group"    => 1,
            "class"    => "Lift_User",
            "function" => "readLimitOffset",
        ];

        $result = pg_insert($connection, "Lift_ACL", $data);

        $data = [
            "group"    => 1,
            "class"    => "Lift_User",
            "function" => "amount",
        ];

        $result = pg_insert($connection, "Lift_ACL", $data);

        $data = [
            "group"    => 1,
            "class"    => "Lift_User_group",
            "function" => "readAll",
        ];

        $result = pg_insert($connection, "Lift_ACL", $data);

        $data = [
            "group"    => 2,
            "class"    => "Lift_User_group",
            "function" => "readAll",
        ];

        $result = pg_insert($connection, "Lift_ACL", $data);

        $data = [
            "group"    => 1,
            "class"    => "Lift_User",
            "function" => "amount",
        ];

        $result = pg_insert($connection, "Lift_ACL", $data);

        $data = [
            "group"    => 1,
            "class"    => "Lift_User",
            "function" => "update_self",
        ];

        $result = pg_insert($connection, "Lift_ACL", $data);

        $data = [
            "group"    => 2,
            "class"    => "Lift_User",
            "function" => "update_self",
        ];

        $result = pg_insert($connection, "Lift_ACL", $data);

        $data = [
            "group"    => 2,
            "class"    => "Lift_User",
            "function" => "update_self",

        ];

        $result = pg_insert($connection, "Lift_ACL", $data);

        $data = [
            "group"    => 2,
            "class"    => "Lift_User",
            "function" => "read",
        ];

        $result = pg_insert($connection, "Lift_ACL", $data);

        $data = [
            "group"    => 2,
            "class"    => "Lift_User",
            "function" => "readAll",
        ];

        $result = pg_insert($connection, "Lift_ACL", $data);

        $data = [
            "group"    => 2,
            "class"    => "Lift_User",
            "function" => "amount",
        ];

        $result = pg_insert($connection, "Lift_ACL", $data);

        $data = [
            "group"    => 2,
            "class"    => "Lift_User",
            "function" => "readLimitOffset",

        ];

        $result = pg_insert($connection, "Lift_ACL", $data);

        $password = md5("488272jjh8LJLHls!u2@kloshgaljXh_sSihaadmin");
        $data = [
            "first_name"        => "admin",
            "middle_name"       => "admin",
            "second_name"       => "admin",
            "email"             => "admin@admin.admin",
            "password"          => $password,
            "group"             => 1,
            "type"              => 1,
            "registration_time" => date('Y-m-d'),
            "update_time"       => date('Y-m-d')
        ];


        $result = pg_insert($connection, "Lift_User", $data);

        $lift_user = new Lift_User();
        $user_id = $lift_user->getLastId();

        $data_blog = [
            'type' => 1,
            'title' => 'Личный блог пользователя admin@admin.admin',
            'administrator' => $user_id
        ];

        $lift_blog = new Lift_Blog();
        $blog_result = $lift_blog->create(null, $data_blog);
        $blog_id = $lift_blog->getLastId();

        $data_blog_access = [
            "user" => $user_id,
            "blog" => $blog_id,
            "level" => 1
        ];

        $lift_blog_access = new Lift_Blog_access();
        $lift_blog_access->create(null, $data_blog_access);

        return $result;
    }
}