<?php

class UserController extends ControllerBase
{

    public function beforeExecuteRoute($dispatcher)
    {

        $token = $this->session->get('logged_user')['success']['token'];
        $lift_user = new Lift_User();

        $user_can_create_users = Lift_Token::hasRights($token, get_class($lift_user), 'create');

        if (!empty($user_can_create_users) || $this->session->get('logged_user')['success']['group'] == 1) {
            $this->view->setVar('user_can_create_users', 1);
        } else {
            $this->view->setVar('user_can_create_users', 0);
        }

        $user_can_update_users = Lift_Token::hasRights($token, get_class($lift_user), 'update');

        if (!empty($user_can_update_users) || $this->session->get('logged_user')['success']['group'] == 1) {
            $this->view->setVar('user_can_update_users', 1);
        } else {
            $this->view->setVar('user_can_update_users', 0);
        }

        $user_can_delete_users = Lift_Token::hasRights($token, get_class($lift_user), 'delete');

        if (!empty($user_can_delete_users) || $this->session->get('logged_user')['success']['group'] == 1) {
            $this->view->setVar('user_can_delete_users', 1);
        } else {
            $this->view->setVar('user_can_delete_users', 0);
        }

        $this->view->setVar('logged_user', $this->session->get("logged_user")['success']);

    }

    public function createsuperuserAction()
    {

        $amount = Tools::amountofusers();

        if (empty($amount)) {
            Tools::createsuperuser();
            $result['success'] = true;
            $this->view->setVar('result', $result);

        } else {
            $result['error']['amount'] = $amount;
            $this->view->setVar('result', $result);
        };

    }

    public function logoutAction($email, $password)
    {
        $lift_user = new Lift_User();
        $lift_user->logout($this->session->get("logged_user")['success']['token']);
        $this->session->set("logged_user", "");
        $this->view->setVar('logged_user', "");
    }


    public function loginAction()
    {
        $amountofusers = Tools::amountofusers();
        $this->view->setVar('amountofusers', $amountofusers);

        $logged_user = $this->session->get("logged_user");

        if (empty($logged_user['success'])) {

            if ($this->request->getPost('submit')) {
                $data = array
                (
                    'email' => $this->request->getPost('email'),
                    'password' => $this->request->getPost('password'),
                    'deleted' => false
                );

                $lift_user = new Lift_User();

                session_regenerate_id();

                $result = $lift_user->login($data, $this->session->getId());

                if ($result['success']) {
                    $lift_blog = new Lift_Blog();
                    $condition_blog = array
                    (
                        'administrator' => $result['success']['id'],
                        'type' => 1
                    );

                    $token = $result['success']['token'];
                    $result['success']['blog'] = $lift_blog->read($condition_blog)[0]['id'];
                    $this->session->set("logged_user", $result);

                    $response = new \Phalcon\Http\Response();

                    if (!empty($this->request->getPost('referer')) && $this->request->getPost('referer') != '/login') {
                        return $response->redirect($this->request->getPost('referer'));
                    } else {
                        $referer = explode("/", $_SERVER['HTTP_REFERER']);
                        $referer = array_slice($referer, 3);
                        $referer = "/" . implode("/", $referer);

                        if ($referer == '/logout') {
                            return $response->redirect('/');
                        } else {
                            return $response->redirect($_SERVER['HTTP_REFERER']);
                        }
                    }
                }

                if ($result['error']) {
                    $referer = explode("/", $_SERVER['HTTP_REFERER']);
                    $referer = array_slice($referer, 3);
                    $referer = "/" . implode("/", $referer);

                    if ($referer != '/login') {
                        $this->view->setVar('referer', $referer);
                    }

                    $this->view->setVar('email', $this->request->getPost('email'));
                    $this->view->setVar('result', $result);
                };

            }

        }
    }

    public function showAction($id = null)
    {
        if (!$id) {
            if (!empty($this->session->get('logged_user')['success'])) {
                $id = $this->session->get('logged_user')['success']['id'];
            } else {
                $response = new \Phalcon\Http\Response();
                return $response->redirect('user/login');
            }
        }


        // User
        $lift_user = new Lift_User();
        $user = $lift_user->read(['id' => $id, 'deleted' => false]);

        if (empty($user[0])) {
            throw new Exception('Not found', 404);
        }

        $user = $user[0];
        $user_condition = ['user' => $id];


        // Posts
        $lift_post = new Lift_Post();
        $posts = $lift_post->read_profile($user_condition);

        $lift_post_ip = new Lift_Post_ip();
        $lift_commentary = new Lift_Commentary();

        foreach ($posts as &$post) {
            $post['commentary_amount'] = $lift_commentary->getAmountPost($post['id']);
            $post['amountOfViews'] = $lift_post_ip->amountOfViews($post['id']);

            $lift_post_heading = new Lift_Post_Heading();
            $post['headings'] = $lift_post_heading->read(['post' => $post['id']]);
        }


        // Comments
        $lift_commentary = new Lift_Commentary();
        $commentaries = $lift_commentary->read_profile($user_condition);


        // Projects
        $lift_project_access = new Lift_Project_access();
        $project_accesses = $lift_project_access->read($user_condition);

        $lift_project = new Lift_Project();
        $projects = $lift_project->readByUser($id);


        // Users
        $users = [];
        foreach ($projects as &$project) {
            $project_accesses = $lift_project_access->read(['project' => $project['id']]);

            foreach ($project_accesses as $project_access) {
                $project['users'][$project_access['level']][] = $project_access['user'];
                $users[] = $project_access['user'];
            }

            $users[] = $project['administrator'];
        }

        $lift_user = new Lift_User();
        $users = $lift_user->readCertain(array_unique($users));

        $this->view->setVars([
            'headings' => $this->getHeadings(),
            'projects' => $projects,
            'posts' => $posts,
            'commentaries' => $commentaries,
            'users' => $users,
            'user' => $user
        ]);
    }

    public function indexAction()
    {

        $lift_user = new Lift_User();

        $token = $this->session->get('logged_user')['success']['token'];

        $users = $lift_user->readAll($token)['success'];

        $this->view->setVar('users', $users);

        $user_group = new Lift_User_group();

        $user_group_result = $user_group->readAll($token);
//

        $this->view->setVar('user_groups', $user_group_result);

    }


    public function registerAction()
    {
        $lift_user = new Lift_User();

        $user_group = new Lift_User_group();
        $token = $this->session->get('logged_user')['success']['token'];
        $user_group_result = $user_group->readAll($token)['success'];
        $this->view->setVar('user_groups', $user_group_result);
        $response = new \Phalcon\Http\Response();

        if ($this->session->get('logged_user')) {
            return $response->redirect('/profile');
        }


        if (!$this->session->get('logged_user') && $this->request->getPost('submit')) {
            $data_extra = [
                'phone' => trim($this->request->getPost('phone')),
                'skype' => trim($this->request->getPost('skype')),
                'website' => trim($this->request->getPost('website')),
            ];

            $data_user = [
                'first_name' => trim($this->request->getPost('first_name')),
                'middle_name' => trim($this->request->getPost('middle_name')),
                'second_name' => trim($this->request->getPost('second_name')),
                'password' => $this->request->getPost('password'),
                'password_confirmation' => $this->request->getPost('password_confirmation'),
                'email' => trim($this->request->getPost('email')),
                'about' => trim($this->request->getPost('about')),
                'data' => $data_extra,
                'group' => 2,
                'type' => 1
            ];

            $result = $lift_user->create($token, $data_user);

            if ($result['success']) {
                // Login
                session_regenerate_id();

                $data_login = [
                    'email' => $data_user['email'],
                    'password' => $data_user['password'],
                    'deleted' => false
                ];

                $login_result = $lift_user->login($data_login, $this->session->getId());


                // Blog
                $data_blog = [
                    'type' => 1,
                    'title' => 'Личный блог пользователя ' . $login_result['success']['email'],
                    'administrator' => $login_result['success']['id']
                ];

                $lift_blog = new Lift_Blog();
                $blog_result = $lift_blog->create(null, $data_blog);
                $blog_id = $lift_blog->getLastId($login_result['success']['token']);

                $data_blog_access = [
                    "user" => $login_result['success']['id'],
                    "blog" => $blog_id,
                    "level" => 1
                ];

                $lift_blog_access = new Lift_Blog_access();
                $lift_blog_access->create(null, $data_blog_access);

                $login_result['success']['blog'] = $blog_id;


                $this->session->set('logged_user', $login_result);
                return $response->redirect('/profile');
            } else {
                $this->view->setVar('user', array_merge($data_user, $data_extra));
            }

            $this->view->setVar('result', $result);
        }
    }

    public function createAction()
    {

        $lift_user = new Lift_User();

        $user_group = new Lift_User_group();
        $user_group_result = $user_group->readAll($token)['success'];
        $this->view->setVar('user_groups', $user_group_result);
        $token = $this->session->get('logged_user')['success']['token'];

        //var_dump(Lift_Token::hasRights($token, "Lift_User", "create"));die();

        if ($this->request->getPost('submit')) {

            $data_user = array
            (
                'first_name' => $this->request->getPost('first_name'),
                'middle_name' => $this->request->getPost('middle_name'),
                'second_name' => $this->request->getPost('second_name'),
                'password' => $this->request->getPost('password'),
                'email' => $this->request->getPost('email'),
                'group' => $this->request->getPost('group'),
                'type' => $this->request->getPost('type'),
                'about' => $this->request->getPost('about'),
                'data' => $this->request->getPost('data')

            );

            if (!empty($this->request->getPost('data'))) {
                $data['data'] = $this->request->getPost('data');
            };

            $result = $lift_user->create($token, $data_user);
            $user_id = $lift_user->getLastId($token);

            ////////////////////////////////////////////////////

            if ($result['success']) {
                $data_blog = array
                (
                    'type' => 1,
                    "title" => "Личный блог пользователя " . $this->request->getPost('email'),
                    //"heading"=>1,
//                    'administrator'=>$this->session->get('logged_user')['success']['id'],
                    'administrator' => $user_id

                );

                $lift_blog = new Lift_Blog();
                $lift_blog->create($token, $data_blog);

                /////////////////////////////////////////////////

                $blog_id = $lift_blog->getLastId($token);

                $data_blog_access = array
                (
                    "user" => $user_id,
                    "blog" => $blog_id,
                    "level" => 1
                );

                $lift_blog_access = new Lift_Blog_access();
                $lift_blog_access->create($token, $data_blog_access);

            }

            if (!empty($result['error'])) {
                $this->view->setVar('result', $result);
                $this->view->setVar('user', $data_user);
            } else {
                $this->view->setVar('result', $result);
            }

        }

    }

    public function deleteAction($id)
    {

        $lift_user = new Lift_User();
        $token = $this->session->get('logged_user')['success']['token'];
        $condition = array
        (
            'id' => $id
        );

        $result = $lift_user->delete($token, $condition);

        $this->view->setVar('result', $result);

    }

    public function updateProfileAction()
    {
        $response = new \Phalcon\Http\Response();

        if (empty($this->session->get('logged_user'))) {
            return $response->redirect('/login');
        }

        $token = $this->session->get('logged_user')['success']['token'];

        $lift_user = new Lift_User();
        $user = $this->session->get('logged_user')['success'];
        $user['password'] = '';

        if (!empty($this->request->getPost('submit'))) {
            $data_extra = [
                'phone' => trim($this->request->getPost('phone')),
                'skype' => trim($this->request->getPost('skype')),
                'website' => trim($this->request->getPost('website')),
            ];

            $data_user = [
                'first_name' => trim($this->request->getPost('first_name')),
                'middle_name' => trim($this->request->getPost('middle_name')),
                'second_name' => trim($this->request->getPost('second_name')),
                'email' => trim($this->request->getPost('email')),
                'about' => trim($this->request->getPost('about')),
                'data' => $data_extra,
                'update_time' => date('Y-m-d H:i:s'),
                'background' => $this->request->getPost('background'),
                'avatar' => $this->request->getPost('avatar'),
                'type' => 1
            ];

            if (!empty($this->request->getPost('password'))) {
                $data_user['password'] = $this->request->getPost('password');
                $data_user['password_confirmation'] = $this->request->getPost('password_confirmation');
            }


            $avatar = $this->loadImage('avatar');

            if ($avatar && $avatar['status'] == 'error') {
                $error['file']['avatar'] = true;
            } else if ($avatar) {
                $data_user['avatar'] = $avatar['name'];
            }

            $background = $this->loadImage('background');

            if ($background && $background['status'] == 'error') {
                $error['file']['background'] = true;
            } else if ($background) {
                $data_user['background'] = $background['name'];
            }

            $user = array_merge($user, $data_user, $data_extra);

            if (empty($error)) {
                $result = $lift_user->update_self($token, $data_user);

                if (!empty($result['success'])) {
                    unset($user['password_confirmation']);
                    $this->session->set("logged_user", ['success' => $user]);

                    return $response->redirect('/profile');
                }
            } else {
                $result = array('error' => $error);
            }

            $this->view->setVar('result', $result);
        }

        $this->view->setVar('user', $user);
    }

    public function updateAction($id)
    {
        if (!$this->session->get('logged_user') || $this->session->get('logged_user')['success']['group'] != 1) {
            throw new Exception('Forbidden', 403);
        }

        if (!$id) {
            throw new Exception('Not found', 404);
        }

        $lift_user = new Lift_User();
        $user = $lift_user->read(['id' => $id]);

        if (empty($user[0])) {
            throw new Exception('Not found', 404);
        }

        $user = $user[0];
        $user['password'] = '';

        $token = $this->session->get('logged_user')['success']['token'];

        $lift_user_group = new Lift_User_group();
        $user_groups = $lift_user_group->readAll($token)['success'];

        if (!empty($this->request->getPost('submit'))) {
            $data_extra = [
                'phone' => trim($this->request->getPost('phone')),
                'skype' => trim($this->request->getPost('skype')),
                'website' => trim($this->request->getPost('website')),
            ];

            $data_user = [
                'first_name' => trim($this->request->getPost('first_name')),
                'middle_name' => trim($this->request->getPost('middle_name')),
                'second_name' => trim($this->request->getPost('second_name')),
                'email' => trim($this->request->getPost('email')),
                'about' => trim($this->request->getPost('about')),
                'group' => $this->request->getPost('group'),
                'data' => $data_extra,
                'update_time' => date('Y-m-d H:i:s'),
                'type' => 1
            ];

            if (!empty($this->request->getPost('password'))) {
                $data_user['password'] = $this->request->getPost('password');
                $data_user['password_confirmation'] = $this->request->getPost('password_confirmation');
            }


            $avatar = $this->loadImage('avatar');

            if ($avatar && $avatar['status'] == 'error') {
                $error['file']['avatar'] = true;
            } else if ($avatar) {
                $data_user['avatar'] = $avatar['name'];
            }

            $background = $this->loadImage('background');

            if ($background && $background['status'] == 'error') {
                $error['file']['background'] = true;
            } else if ($background) {
                $data_user['background'] = $background['name'];
            }

            $user = array_merge($user, $data_user, $data_extra);

            if (empty($error)) {
                $result = $lift_user->update($token, $data_user, ['id' => $id]);

                if (!empty($result['success'])) {
                    unset($user['password_confirmation']);

                    $response = new \Phalcon\Http\Response();
                    return $response->redirect('/users/' . $id);
                }
            } else {
                $result = array('error' => $error);
            }

            $this->view->setVar('result', $result);
        }

        $this->view->setVar('user_groups', $user_groups);
        $this->view->setVar('user', $user);
    }
}