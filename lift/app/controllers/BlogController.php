<?php

class BlogController extends ControllerBase
{
    private function crazysort(&$comments, $parentComment = 0, $level = 0, $count = null)
    {
        if (is_array($comments) && count($comments)) {

            $return = array();
            if (is_null($count)) {
                $c = count($comments);
            } else {
                $c = $count;
            }
            for ($i = 0; $i < $c; $i++) {
                if (!isset($comments[$i])) continue;
                $comment = $comments[$i];
                $parentId = $comment['parent'];
                if ($parentId == $parentComment) {
                    $comment['level'] = $level;
                    $commentId = $comment['id'];
                    $return[] = $comment;
                    unset($comments[$i]);
                    while ($nextReturn = $this->crazysort($comments, $commentId, $level + 1, $c)) {
                        $return = array_merge($return, $nextReturn);
                    }
                }
            }
            return $return;
        }
        return false;
    }

    public function indexAction()
    {
        $headings_checked = $this->request->get('headings');
        $subjects_checked = $this->request->get('subjects');
        $most_checked = $this->request->get('most');
        $date_checked = $this->request->get('date');

        $day_checked = $this->request->get('day');
        $month_checked = $this->request->get('month');
        $year_checked = $this->request->get('year');
        $period_checked = $this->request->get('period');
        $from_checked = $this->request->get('from');
        $to_checked = $this->request->get('to');

        if (!empty($day_checked)) {

            $from = date("Y-m-d", strtotime(date('Y') . "-" . date('m') . "-" . $day_checked));
            $to = date('Y-m-d', strtotime($from . '+1 day'));
        };

        if (!empty($month_checked)) {

            $from = date("Y-m-d", strtotime(date('Y') . "-" . $month_checked . "-01"));
            $to = date('Y-m-d', strtotime($from . '+1 month'));
        };

        if (!empty($year_checked)) {

            $from = date("Y-m-d", strtotime($year_checked . "-01-01"));
            $to = date('Y-m-d', strtotime($from . '+1 year'));
        };

        if (!empty($from_checked)) {
            $from = $from_checked;
        };

        if (!empty($to_checked)) {
            $to = $to_checked;
        };

        $this->view->setVar('uri', $uri);
        $this->view->setVar('headings_checked', $headings_checked);
        $this->view->setVar('subjects_checked', $subjects_checked);
        $this->view->setVar('most_checked', $most_checked);
        $this->view->setVar('date_checked', $date_checked);

        $this->view->setVar('day_checked', $day_checked);
        $this->view->setVar('month_checked', $month_checked);
        $this->view->setVar('year_checked', $year_checked);
        $this->view->setVar('period_checked', $period_checked);
        $this->view->setVar('from_checked', $from_checked);
        $this->view->setVar('to_checked', $to_checked);

        $lift_post = new Lift_Post();

        $amount = intval($lift_post->amountOfPosts_filter($headings_checked, $subjects_checked, $from, $to));

        $pagination = $this->makePagination($amount, 5, $this->request->get('page'));

        $posts = $lift_post->readLimitOffset_filter($pagination['max'], $pagination['start'], $headings_checked, $subjects_checked, 'new', $from, $to)['success'];

        $token = $this->session->get('logged_user')['success']['token'];
        foreach ($posts as &$post) {
            $condition = array
            (
                'post' => $post['id']
            );

            $lift_post_heading = new Lift_Post_Heading();
            $post_headings = $lift_post_heading->read($condition);

            $lift_post_subject = new Lift_Post_Subject();
            $post_subjects = $lift_post_subject->read($condition);

            $post['headings'] = $post_headings;
            $post['subjects'] = $post_subjects;

            $condition_follow_blog = array
            (
                'blog' => $post['blog'],
                'user' => $this->session->get("logged_user")['success']['id']
            );

            $lift_blog_follow = new Lift_Blog_Follow();
            $blog_follow = $lift_blog_follow->read($token, $condition_follow_blog)[0];

            if (!empty($blog_follow)) {
                $post['followed_blog'] = true;
            }
        }

        $this->view->setVars([
            'headings' => $this->getHeadings(),
            'posts' => $posts,
            'pagination' => $pagination
        ]);

        $request = new Phalcon\Http\Request();
        if ($request->isAjax()) {
            $this->view->pick('index/index.ajax');
        }
    }

    public function deleteCommentaryAction()
    {
        $this->view->setRenderLevel(1);

        $token = $this->session->get('logged_user')['success']['token'];

        $condition = array
        (
            'id' => $this->request->getPost('commentary_id')
        );

        $lift_commentary = new Lift_Commentary();
        $commentary = $lift_commentary->read($condition)[0];

        $condition = array
        (
            'id' => $commentary['post']
        );

        $lift_post = new Lift_Post();
        $post = $lift_post->read($condition)[0];

        $condition = array
        (
            'id' => $post['blog']
        );

        $lift_blog = new Lift_Blog();
        $blog = $lift_blog->read($token, $condition)[0];

        if ($this->session->get('logged_user')['success']['group'] == 1 || $blog['administrator'] == $this->session->get('logged_user')['success']['id']) {

            $data['id'] = $this->request->getPost('commentary_id');

            $lift_commentary = new Lift_Commentary();

            $result = $lift_commentary->delete($token, $data);

            if (!empty($result['success'])) {
                $this->response->setStatusCode(200, "OK");

            } else {
                $this->response->setStatusCode(500, var_dump($result));
            };
        } else {
            $error = array('hasRights' => true);
            $result['error'] = $error;
            $this->response->setStatusCode(500, var_dump($result));

        };
    }

    public function writeCommentaryAction()
    {
        $this->view->setRenderLevel(1);

        $token = $this->session->get('logged_user')['success']['token'];

        $data['creation_time'] = date('Y-m-d H:i:s');
        $data['text'] = $this->request->getPost('text');
        $data['post'] = $this->request->getPost('post');
        $data['user'] = $this->session->get('logged_user')['success']['id'];

        if (!empty($this->request->getPost('post'))) {
            $data['post'] = $this->request->getPost('post');
        };

        if (!empty($this->request->getPost('parent'))) {
            $data['parent'] = $this->request->getPost('parent');
        } else {
            $data['parent'] = "";
        };

        $lift_commentary = new Lift_Commentary();

        $result = $lift_commentary->create($token, $data);

        $condition_commentary_getLast_id = array
        (

            'post' => $this->request->getPost('post')
        );

        $last_id = $lift_commentary->getLastId($token, $condition_commentary_getLast_id);

        $condition_read = array
        (
            'id' => $last_id,
        );

        $commentary = $lift_commentary->read_LastId($condition_read);

        if ($result['success']) {
            $this->view->setVar('commentary', $commentary[0]);
        } else {
            $this->response->setStatusCode(500, var_dump($result));
        };
    }

    public function postAction($post_id)
    {
        $lift_post = new Lift_Post();
        $post = $lift_post->read([
            'id' => $post_id,
            'deleted' => false
        ]);

        if (empty($post[0])) {
            throw new Exception('Non-existent post', 404);
        }

        $post = $post[0];

        $lift_post_ip = new Lift_Post_ip();
        $lift_post_ip->create([
            'post' => $post_id,
            'ip' => $_SERVER['REMOTE_ADDR']
        ]);
        $post['views'] = $lift_post_ip->amountOfViews($post_id);

        $condition = [
            'post' => $post_id
        ];

        $lift_post_heading = new Lift_Post_Heading();
        $post_headings = $lift_post_heading->read($condition);

        $lift_post_subject = new Lift_Post_Subject();
        $post_subjects = $lift_post_subject->read($condition);

        $post['headings'] = $post_headings;
        $post['subjects'] = $post_subjects;

        $heading = new Lift_Heading();
        $headings = $heading->readAll()['success'];
        $this->view->setVar('headings', $headings);

        $subject = new Lift_Subject();
        $subjects = $subject->readAll()['success'];
        $this->view->setVar('subjects', $subjects);

        $lift_user = new Lift_User();

        $condition = array
        (
            'id' => $post['user']
        );

        $user = $lift_user->read($condition)[0];

        $post['email'] = $user['email'];
        $post['user'] = $user;

        $this->view->setVar('post', $post);

        $lift_commentary = new Lift_Commentary();
        $condition = array
        (
            'post' => $post_id
        );

        $commentaries = $lift_commentary->read_post($condition);

        $token = $this->session->get('logged_user')['success']['token'];

        $condition = array
        (
            'id' => $post['blog']
        );

        $lift_blog = new Lift_Blog();
        $blog = $lift_blog->read($condition)[0];

        foreach ($commentaries as &$commentary) {

            if (empty($commentary['text']) || $commentary['deleted'] == 't') {
                $commentary['text'] = "НЛО прилетело и опубликовало эту надпись здесь.";
            }
        }

        $commentaries = $this->crazysort($commentaries);

        $this->view->setVar('commentaries', $commentaries);
        $this->view->setVar('blog', $blog);

        if (!empty($this->session->get('logged_user')['success']['id'])) {
            $this->view->setVar('user_can_write_commentaries', 1);

        } else {
            $this->view->setVar('user_can_write_commentaries', 0);
        };

        if ($this->session->get('logged_user')['success']['group'] == 1 || $blog['administrator'] == $this->session->get('logged_user')['success']['id']) {
            $this->view->setVar('user_can_delete_commentaries', true);
        } else {
            $this->view->setVar('user_can_delete_commentaries', false);
        };
    }

    public function posts_listAction($blog_id)
    {
        die();

        $token = $this->session->get('logged_user')['success']['token'];

        $lift_post = new Lift_Post();

        $amount = $lift_post->amountOfPosts($blog_id);

        $amount = intval($amount);
        $pagination = $this->makePagination($amount, 5, $this->request->get('page'));

        $posts = $lift_post->readPosts_LimitOffset($pagination['max'], $pagination['start'], $blog_id);

        $lift_post_ip = new Lift_Post_ip();
        foreach ($posts as &$post) {

            $post['amountOfViews'] = $lift_post_ip->amountOfViews($post['id']);
        };

        $this->view->setVar('posts', $posts);

        $this->view->setVar('pagination', $pagination);

        $this->view->setVar('blog_id', $blog_id);

        $lift_blog = new Lift_Blog();
        $condition = array
        (
            'id' => $blog_id
        );
        $blog = $lift_blog->read($token, $condition)[0];
        $this->view->setVar('blog', $blog);

        $lift_blog_access = new Lift_Blog_access();
        $condition = array
        (
            'blog' => $blog_id
        );

        $blog_accesss = $lift_blog_access->read($condition);

        foreach ($blog_accesss as $blog_access) {
            $hasRights[] = $blog_access['user'];
        }

        $this->view->setVar('hasRights', $hasRights);
    }

    public function deletePostAction($post_id)
    {
        $lift_post = new Lift_Post();

        $post = $lift_post->read([
            'id' => $post_id,
            'deleted' => false
        ]);

        if (!$post[0]) {
            throw new Exception('Non-existent post', 404);
        }

        $post = $post[0];

        if (empty($this->session->get('logged_user')['success']) || $post['user'] != $this->session->get('logged_user')['success']['id']) {
            throw new Exception('Forbidden', 403);
        }

        $token = $this->session->get('logged_user')['success']['token'];
        $result = $lift_post->delete($token, ['id' => $post_id]);
        $this->view->setVar('result', $result);
    }

    public function updatePostAction($post_id)
    {
        $lift_post = new Lift_Post();
        $post = $lift_post->read([
            'id' => $post_id,
            'deleted' => false
        ]);

        if (!$post[0]) {
            throw new Exception('Non-existent post', 404);
        }

        $post = $post[0];

        if (empty($this->session->get('logged_user')['success']) || ($post['user'] != $this->session->get('logged_user')['success']['id'] && !in_array($this->session->get('logged_user')['success']['group'], [1, 3]))) {
            throw new Exception('Forbidden', 403);
        }

        $lift_user = new Lift_User();
        $user = $lift_user->read(['id' => $post['user']])[0];
        $post['user'] = $user['email'];

        $headings = $this->getHeadings();
        $this->view->setVar('headings', $headings);

        $lift_post_heading = new Lift_Post_Heading();

        if ($this->request->getPost('submit')) {
            $data = [
                'title' => trim($this->request->getPost('title')),
                'text' => trim($this->request->getPost('text')),
                'annotation' => trim($this->request->getPost('annotation')),
                'avatar' => $this->request->getPost('avatar'),
                'background' => $this->request->getPost('background'),
                'status' => 1
            ];

            if (!empty($this->request->getPost('user'))) {
                $lift_user = new Lift_User();
                $condition['email'] = trim($this->request->getPost('user'));
                $user = $lift_user->read($condition)[0];

                if (empty($user)) {
                    $error['data']['user'] = true;
                } else {
                    $data['user'] = $user['id'];
                }
            } else {
                $data['user'] = $this->session->get('logged_user')['success']['id'];
            }

            $post_heading = $this->request->getPost('heading');

            if (empty($data['title'])) {
                $error['data']['title'] = true;
            }

            if (empty($data['text'])) {
                $error['data']['text'] = true;
            }

            if (empty($data['annotation'])) {
                $error['data']['annotation'] = true;
            }

            if (empty($post_heading)) {
                $error['data']['heading'] = true;
            }

            $avatar = $this->loadImage('avatar');

            if ($avatar && $avatar['status'] == 'error') {
                $error['file']['avatar'] = true;
            } else if ($avatar) {
                $data['avatar'] = $avatar['name'];
            }

            $background = $this->loadImage('background');

            if ($background && $background['status'] == 'error') {
                $error['file']['background'] = true;
            } else if ($background) {
                $data['background'] = $background['name'];
            }


            if (empty($error)) {
                $token = $this->session->get('logged_user')['success']['token'];
                $result = $lift_post->update($token, $data, ['id' => $post['id']]);

                if (!empty($result['success'])) {
                    $lift_post_heading->delete(['post' => $post['id']]);

                    $data_heading = [
                        'post' => $post_id,
                        'heading' => $post_heading
                    ];

                    $lift_post_heading->create($data_heading);

                    $response = new \Phalcon\Http\Response();
                    return $response->redirect('/posts/' . $post['id']);
                } else {
                    $error['database']['pg_insert'] = true;
                }
            }

            $post = $data;
            $post['heading'] = $post_heading;
            $this->view->setVar('result', ['error' => $error]);
        } else {
            $post['heading'] = $lift_post_heading->read(['post' => $post['id']])[0]['heading'];
        }

        $this->view->setVar('post', $post);
    }

    public function createPostAction($blog_id = null)
    {

        if (empty($this->session->get('logged_user')['success'])) {
            throw new Exception('Forbidden', 403);
        }

        $blog_id = $blog_id ? $blog_id : $this->session->get('logged_user')['success']['blog'];
        $lift_blog = new Lift_Blog();
        $blog = $lift_blog->read(['id' => $blog_id]);

        if (empty($blog[0])) {
            throw new Exception('Non-existent blog', 404);
        }

        $blog_id = $blog[0]['id'];

        if ($this->request->getPost('submit')) {
            $data = [
                'blog' => $blog_id,
                'title' => trim($this->request->getPost('title')),
                'text' => trim($this->request->getPost('text')),
                'annotation' => trim($this->request->getPost('annotation')),
                'avatar' => trim($this->request->getPost('avatar')),
                'background' => trim($this->request->getPost('background')),
                'status' => 1

            ];

            if (!empty($this->request->getPost('user_email'))) {
                $lift_user = new Lift_User();
                $condition['email'] = trim($this->request->getPost('user_email'));
                $user = $lift_user->read($condition)[0];

                if (empty($user)) {
                    $error['data']['user'] = true;
                } else {
                    $data['user'] = $user['id'];
                }
            } else {
                $data['user'] = $this->session->get('logged_user')['success']['id'];
            }


            $post_heading = $this->request->getPost('heading');

            if (empty($data['title'])) {
                $error['data']['title'] = true;
            }

            if (empty($data['text'])) {
                $error['data']['text'] = true;
            }

            if (empty($data['annotation'])) {
                $error['data']['annotation'] = true;
            }

            if (empty($post_heading)) {
                $error['data']['heading'] = true;
            }

            $avatar = $this->loadImage('avatar');

            if ($avatar && $avatar['status'] == 'error') {
                $error['file']['avatar'] = true;
            } else if ($avatar) {
                $data['avatar'] = $avatar['name'];
            }


            $background = $this->loadImage('background');

            if ($background && $background['status'] == 'error') {
                $error['file']['background'] = true;
            } else if ($background) {
                $data['background'] = $background['name'];
            }


            if (empty($error)) {
                $token = $this->session->get('logged_user')['success']['token'];

                $lift_post = new Lift_Post();
                $result = $lift_post->create($token, $data);

                if (!empty($result['success'])) {
                    $post_id = $lift_post->getLastId($token);

                    $data_heading = [
                        'post' => $post_id,
                        'heading' => $post_heading
                    ];

                    $lift_post_heading = new Lift_Post_Heading();
                    $lift_post_heading->create($data_heading);

                    $response = new \Phalcon\Http\Response();
                    return $response->redirect('/posts/' . $post_id);
                } else {
                    $error['database']['pg_insert'] = true;
                }
            } else {
                $data['user_email'] = trim($this->request->getPost('user_email'));
            }

            $data['heading'] = $post_heading;
            $this->view->setVars([
                'result' => ['error' => $error],
                'post' => $data
            ]);
        }

        $this->view->setVar('headings', $headings = $this->getHeadings());
    }

    public function createAction()
    {

        if (!$this->session->get('logged_user')) {
            throw new Exception('Forbidden', 403);
        }

        $token = $this->session->get('logged_user')['success']['token'];

        $data = array
        (
            'title' => $this->request->getPost('title'),
            'text' => $this->request->getPost('text'),
            'administrator' => $this->session->get('logged_user')['success']['id'],
            'type' => 2

        );

        $avatar = $this->loadImage('avatar');

        if ($avatar && $avatar['status'] == 'error') {
            $error['file']['avatar'] = true;
        } else if ($avatar) {
            $data['avatar'] = $avatar['name'];
        }

        $heading = new Lift_Heading();
        $headings = $heading->readAll($token)['success'];
        $this->view->setVar('headings', $headings);

        $subject = new Lift_Subject();
        $subjects = $subject->readAll()['success'];
        $this->view->setVar('subjects', $subjects);

        $lift_blog = new Lift_Blog();
        if ($this->request->getPost('submit')) {

            $lift_user = new Lift_User();

            $emails = trim($this->request->getPost('emails'));

            if (!empty($emails)) {
                $emails = explode(" ", $emails);

                foreach ($emails as $email) {

                    $condition = array
                    (
                        'email' => $email
                    );

                    $user = $lift_user->read($condition);

                    if (empty($user)) {
                        $error['not_existed_user'] = true;

                    } else {
                        $users[] = $user;
                    }
                };
            }

            if (empty($this->request->getPost('title'))) {
                $error['data']['title'] = true;
            }

            $lift_blog_access = new Lift_Blog_access();

            if (empty($error)) {
                $result = $lift_blog->create($token, $data);

                $this->view->setVar('result', $result);

                if (!empty($result['success'])) {
                    $id = $lift_blog->getLastId($token);

                    $headings = $this->request->getPost('headings');
                    $subjects = $this->request->getPost('subjects');

                    foreach ($headings as $heading) {
                        $data = array
                        (
                            'blog' => $id,
                            'heading' => $heading
                        );

                        $lift_blog_heading = new Lift_Blog_Heading();
                        $lift_blog_heading->create($data);
                    }

                    foreach ($subjects as $subject) {
                        $data = array
                        (
                            'blog' => $id,
                            'subject' => $subject
                        );

                        $lift_blog_subject = new Lift_Blog_Subject();
                        $lift_blog_subject->create($data);
                    }

                    $data_blog_access = array
                    (
                        "user" => $this->session->get('logged_user')['success']['id'],
                        "blog" => $id,
                        "level" => 1
                    );

                    $result = $lift_blog_access->create($token, $data_blog_access);

                    foreach ($users as $user) {
                        $data_blog_access = array
                        (
                            "user" => $user[0]['id'],
                            "blog" => $id,
                            "level" => 1

                        );

                        $result = $lift_blog_access->create($token, $data_blog_access);
                    }

                };

            } else {
                $result['error'] = $error;
                $this->view->setVar('result', $result);

                $blog['emails'] = $this->request->getPost('emails');
                $blog['title'] = $this->request->getPost('title');
                $blog['heading'] = $this->request->getPost('heading');

                $this->view->setVar('blog', $blog);

            }
        }
    }

    public function listAjaxAction()
    {

        $token = $this->session->get('logged_user')['success']['token'];

        $lift_blog = new Lift_Blog();
        $blogs = $lift_blog->readAll()['success'];

        foreach ($blogs as &$blog) {
            $lift_blog_access = new Lift_Blog_access();
            $condition = array
            (
                'blog' => $blog['id']
            );

            $blog_accesss = $lift_blog_access->read($condition);

            foreach ($blog_accesss as $blog_access) {
                $blog['hasRights'][] = $blog_access['user'];
            }

            $lift_blog_heading = new Lift_Blog_Heading();
            $blog_headings = $lift_blog_heading->read($condition);

            $lift_blog_subject = new Lift_Blog_Subject();
            $blog_subjects = $lift_blog_subject->read($condition);

            $blog['headings'] = $blog_headings;
            $blog['subjects'] = $blog_subjects;
        };

        $this->view->setVar('blogs', $blogs);

        $heading = new Lift_Heading();
        $headings = $heading->readAll()['success'];
        $this->view->setVar('headings', $headings);

        $subject = new Lift_Subject();
        $subjects = $subject->readAll()['success'];
        $this->view->setVar('subjects', $subjects);

        $this->view->setRenderLevel(1);
        echo json_encode($blogs);
    }

    public function listAction()
    {
        $token = $this->session->get('logged_user')['success']['token'];

        $lift_blog = new Lift_Blog();
        $blogs = $lift_blog->readAll()['success'];

        foreach ($blogs as &$blog) {
            $lift_blog_access = new Lift_Blog_access();
            $condition = array
            (
                'blog' => $blog['id']
            );

            $blog_accesss = $lift_blog_access->read($condition);

            foreach ($blog_accesss as $blog_access) {
                $blog['hasRights'][] = $blog_access['user'];
            }

            $lift_blog_heading = new Lift_Blog_Heading();
            $blog_headings = $lift_blog_heading->read($condition);

            $lift_blog_subject = new Lift_Blog_Subject();
            $blog_subjects = $lift_blog_subject->read($condition);

            $blog['headings'] = $blog_headings;
            $blog['subjects'] = $blog_subjects;
        };

        $this->view->setVar('blogs', $blogs);

        $heading = new Lift_Heading();
        $headings = $heading->readAll()['success'];
        $this->view->setVar('headings', $headings);

        $subject = new Lift_Subject();
        $subjects = $subject->readAll()['success'];
        $this->view->setVar('subjects', $subjects);

    }

    public function deleteAction($id)
    {
        $token = $this->session->get('logged_user')['success']['token'];

        $condition = array
        (
            'id' => $id
        );

        $lift_blog = new Lift_Blog();
        $blog = $lift_blog->read($token, $condition)[0];

        $lift_blog_access = new Lift_Blog_access();
        $condition = array
        (
            'blog' => $id
        );

        $blog_accesss = $lift_blog_access->read($condition);

        foreach ($blog_accesss as $blog_access) {
            $hasRights[] = $blog_access['user'];
        }

        if (
            $this->session->get('logged_user')['success']['group'] == 1 ||
            $blog['administrator'] == $token = $this->session->get('logged_user')['success']['id'] ||
                in_array($this->session->get('logged_user')['success']['id'], $hasRights)

        ) {
            $lift_post = new Lift_Post();

            $condition_post = array
            (
                'blog' => $id
            );

            $result = $lift_post->delete($token, $condition_post);

            $lift_blog_access = new Lift_Blog_access();
            $lift_blog_access->delete($token, $condition_post);

            $condition = array
            (
                'id' => $id
            );

            $result = $lift_blog->delete($token, $condition);

            $this->view->setVar('result', $result);
        } else {
            $this->view->setVar('result', array('error' => $error));
        }
    }

    public function followBlogAction($blog_id)
    {
        $token = $this->session->get('logged_user')['success']['token'];

        $user_id = $this->session->get("logged_user")['success']['id'];

        $data = array
        (
            'blog' => $blog_id,
            'user' => $user_id
        );

        $lift_blog_follow = new Lift_Blog_Follow();
        $lift_blog_follow->create($token, $data);

    }

    public function unfollowBlogAction($blog_id)
    {
        $token = $this->session->get('logged_user')['success']['token'];

        $user_id = $this->session->get("logged_user")['success']['id'];

        $condition = array
        (
            'blog' => $blog_id,
            'user' => $user_id
        );

        $lift_blog_follow = new Lift_Blog_Follow();
        $lift_blog_follow->delete($token, $condition);

    }

    public function updateAction($id)
    {
        $token = $this->session->get('logged_user')['success']['token'];

        $lift_blog_heading = new Lift_Blog_Heading();
        $lift_blog_subject = new Lift_Blog_Subject();

        if ($this->request->getPost('submit')) {
            if (!empty($error)) {
                $result['error'] = $error;
            } else {
                $condition_blog = array
                (
                    'id' => $id
                );

                if (!empty($this->request->getPost('title'))) $data['title'] = $this->request->getPost('title');
                if (!empty($this->request->getPost('text'))) $data['text'] = $this->request->getPost('text');
                //$data['heading']=$this->request->getPost('heading');
                $emails = $this->request->getPost('emails');

                $avatar = $this->loadImage('avatar');

                if ($avatar && $avatar['status'] == 'error') {
                    $error['file']['avatar'] = true;
                } else if ($avatar) {
                    $data['avatar'] = $avatar['name'];
                }

                if (!empty($emails)) {
                    $emails = explode(" ", $emails);
                }

                $lift_user = new Lift_User();
                foreach ($emails as $email) {

                    $condition = array
                    (
                        'email' => $email
                    );

                    $user = $lift_user->read($condition)[0];

                    if (empty($user)) {
                        $error['not_existed_user'] = $condition['email'];

                    } else {
                        $users[] = $user;
                    }
                };

                if (!empty($error)) {
                    $result['error'] = $error;
                } else {
                    $lift_blog = new Lift_Blog();
                    $result = $lift_blog->update($token, $data, $condition_blog);

                    if ($result['success']) {

                        $headings = $this->request->getPost('headings');
                        $subjects = $this->request->getPost('subjects');

                        $condition = array
                        (
                            'blog' => $id
                        );
                        $lift_blog_heading->delete($condition);
                        $lift_blog_subject->delete($condition);

                        foreach ($headings as $heading) {

                            $data = array
                            (
                                'blog' => $id,
                                'heading' => $heading
                            );

                            $lift_blog_heading->create($data);

                        }

                        foreach ($subjects as $subject) {

                            $data = array
                            (
                                'blog' => $id,
                                'subject' => $subject
                            );

                            $lift_blog_subject->create($data);

                        }

                        $lift_blog_access = new Lift_Blog_access();

                        foreach ($users as $user) {

                            $condition_blog_access = array
                            (
                                'blog' => $id,
                                'user' => $user['id']
                            );

                            $data = array
                            (
                                "user" => $user['id'],
                                "blog" => $id,
                                "level" => 1
                            );

                            $result_blog_access_delete = $lift_blog_access->delete($token, $condition_blog_access);
                            $result_blog_access_create = $lift_blog_access->create($token, $data);

                        };

                    }

                }
            }
        }

        $lift_blog = new Lift_Blog();

        $heading = new Lift_Heading();
        $headings = $heading->readAll($token)['success'];
        $this->view->setVar('headings', $headings);

        $subject = new Lift_Subject();
        $subjects = $subject->readAll()['success'];
        $this->view->setVar('subjects', $subjects);

        $lift_blog_access = new Lift_Blog_access();

        $condition_blog_access = array
        (
            'blog' => $id
        );

        $blog_accesses = $lift_blog_access->read($condition_blog_access);

        $lift_user = new Lift_User();

        foreach ($blog_accesses as $blog_access) {
            $condition_user = array
            (
                'id' => $blog_access['user']
            );
            $users[] = $lift_user->read($condition_user)[0];
        }

        unset($emails);
        foreach ($users as $user) {
            $emails[] = $user['email'];
        }

        $condition_blog = array
        (
            'id' => $id
        );

        unset($blog);
        $blog = $lift_blog->read($token, $condition_blog)[0];

        $condition_administrator = array
        (
            'id' => $blog['administrator']
        );

        $administrator = $lift_user->read($condition_administrator)[0];

        $emails[] = $administrator['email'];

        $emails = array_unique($emails);

        $condition = array
        (
            'blog' => $id
        );

        $blog['headings'] = $lift_blog_heading->read($condition);

        $blog['subjects'] = $lift_blog_subject->read($condition);

        $blog['emails'] = implode(' ', $emails);
        $this->view->setVar('blog', $blog);
        $this->view->setVar('result', $result);

    }

}

