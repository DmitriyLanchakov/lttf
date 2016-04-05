<?php

class IndexController extends ControllerBase
{
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
        $from = null;
        $to = null;

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

        $posts = $lift_post->readAll_filter($headings_checked, $subjects_checked, 'new', $from, $to) ['success'];

        $lift_prpost = new Lift_Prpost();
        $prposts = $lift_prpost->readAll_filter($headings_checked, $subjects_checked, 'new', $from, $to);

        if (is_array($posts) && !empty($prposts['success'])) {
            foreach ($prposts['success'] as $prpost) {
                $posts[] = $prpost;
            }
        } else if (!empty($prposts['success'])) {
            $posts = $prposts['success'];
        }

        $amount = intval(sizeof($posts));
        $pagination = $this->makePagination($amount, 5, $this->request->get('page'));

        foreach ($posts as $key => $post) {

            $creation_time[$key] = $post['creation_time'];
        }

        array_multisort($creation_time, SORT_DESC, $posts);

        $posts = array_slice($posts, $pagination['start'], $pagination['max']);

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
        }

        $heading = new Lift_Heading();
        $headings = $heading->readAll()['success'];
        $this->view->setVar('headings', $headings);

        $subject = new Lift_Subject();
        $subjects = $subject->readAll()['success'];
        $this->view->setVar('subjects', $subjects);

        $this->view->setVar('posts', $posts);
        $this->view->setVar('pagination', $pagination);

        $lift_subject = new Lift_Subject();
        $subjects = $lift_subject->readAll()['success'];
        $this->view->setVar('subjects', $subjects);

        $request = new Phalcon\Http\Request();
        if ($request->isAjax()) {
            $this->view->pick('index/index.ajax');
        }

    }
}

