<?php

class ApiController extends ControllerBase
{
    private $lift_post_heading;
    private $lift_heading;
    private $lift_project;

    public function indexAction()
    {
        die();
    }

    private function getPostHeadings($post)
    {
        if (!$this->lift_heading) {
            $this->lift_heading = new Lift_Heading();
        }

        if (empty($post['project'])) {
            if (!$this->lift_post_heading) {
                $this->lift_post_heading = new Lift_Post_Heading();
            }

            $post_headings = $this->lift_post_heading->read([
                'post' => $post['id']
            ]);
        } else {
            if (!$this->lift_project) {
                $this->lift_project = new Lift_Project();
            }

            $project = $this->lift_project->read_([
                'id' => $post['project']
            ])[0];

            $post_headings = [
                [
                    'heading' => $project['heading']
                ]
            ];

        }

        if (empty($post_headings)) {
            return [];
        }

        $post_headings = array_column($post_headings, 'heading');
        $headings = $this->lift_heading->readAll()['success'];
        $result = [];

        foreach ($headings as $heading) {
            if (in_array($heading['id'], $post_headings)) {
                $heading['heading'] = $heading['id'];
                $result[] = $heading;
            }
        }

        return $result;
    }

    public function postsAction($areas = null, $format = 'json', $type = 'blog_posts,project_posts', $limit = 0)
    {
        if (!empty($areas)) {
            $areas_array = explode(',', $areas);

            if (!is_numeric($areas[0])) {
                if ($type != 'blog_posts,project_posts') {
                    $limit = $type;
                }

                if ($format != 'json') {
                    $type = $format;
                }

                $format = $areas;
            } else {
                $area_condition = [];
                foreach ($areas_array as $area) {
                    $area_condition[$area] = $area;
                }
            }
        } else {
            $area_condition = [];
        }


        $type = explode(',', $type);
        if (in_array('blog_posts', $type)) {
            $lift_post = new Lift_Post();
            $blog_posts = $lift_post->readLimitOffset_filter($limit, 0, $area_condition, [], 'new', [], [])['success'];
        }

        if (empty($blog_posts)) {
            $blog_posts = [];
        }

        if (in_array('project_posts', $type)) {
            $lift_prpost = new Lift_Prpost();
            $project_posts = $lift_prpost->readAll_filter($area_condition, [], 'new', [], [], $limit, 0)['success'];
        }

        if (empty($project_posts)) {
            $project_posts = [];
        }

        $posts = array_merge($blog_posts, $project_posts);

        if ($limit) {
            $posts = array_slice($posts, 0, $limit);
        }

        foreach ($posts as &$post) {
            if (empty($post['project'])) {
                unset($post['text']);
            }

            $post['headings'] = $this->getPostHeadings($post);
        }

        switch ($format) {
            case 'json':
                $this->view->setRenderLevel(1);
                echo json_encode($posts);
                die();
                break;

            case 'iframe':
            default:
                $this->view->disableLevel(3);
                $this->view->setVar('posts', $posts);
                break;
        }
    }

    public function blog_postAction($id, $format = 'json')
    {
        $lift_post = new Lift_Post();
        $post = $lift_post->read([
            'id' => $id,
            'deleted' => false
        ]);

        if (empty($post[0])) {
            throw new Exception('Non-existent post', 404);
        }

        $post = $post[0];
        $post['headings'] = $this->getPostHeadings($post);

        $lift_post_subject = new Lift_Post_Subject();
        $post_subjects = $lift_post_subject->read([
            'post' => $id
        ]);

        if (!empty($post_subjects)) {
            $post_subjects = array_column($post_subjects, 'subject');
        } else {
            $post_subjects = [];
        }

        $post['subjects'] = [];

        $lift_subject = new Lift_Subject();
        $subjects = $lift_subject->readAll()['success'];

        foreach ($subjects as $subject) {
            if (in_array($subject['id'], $post_subjects)) {
                $post['subjects'][] = $subject;
            }
        }


        $lift_user = new Lift_User();
        $user = $lift_user->read(['id' => $post['user']])[0];
        unset($user['password']);
        $post['user'] = $user;


        $lift_post_ip = new Lift_Post_ip();
        $post['views'] = $lift_post_ip->amountOfViews($id);


        switch ($format) {
            case 'json':
                $this->view->setRenderLevel(1);
                echo json_encode($post);
                die();
                break;

            case 'iframe':
            default:
                $this->view->disableLevel(3);
                $this->view->setVar('post', $post);
                break;
        }
    }

    public function project_postAction($id, $format = 'json')
    {
        $lift_prpost = new Lift_Prpost();
        $post = $lift_prpost->read([
            'id' => $id,
            'deleted' => false
        ]);

        if (empty($post[0])) {
            throw new Exception('Non-existent post', 404);
        }

        $post = $post[0];
        $post['headings'] = $this->getPostHeadings($post);

        $lift_user = new Lift_User();
        $user = $lift_user->read(['id' => $post['user']])[0];
        unset($user['password']);
        $post['user'] = $user;


        $lift_post_ip = new Lift_Prpost_ip();
        $post['views'] = $lift_post_ip->amountOfViews($id);

        switch ($format) {
            case 'json':
                $this->view->setRenderLevel(1);
                echo json_encode($post);
                die();
                break;

            case 'iframe':
            default:
                $this->view->disableLevel(3);
                $this->view->setVar('post', $post);
                break;
        }
    }
}