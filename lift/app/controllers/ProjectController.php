<?php

class ProjectController extends ControllerBase
{
    public function beforeExecuteRoute($dispatcher)
    {
        if($this->session->get("logged_user")['success']['group']==1 ||
            $this->session->get("logged_user")['success']['group']==3)
        {
            $this->view->setVar('user_can_create_projects', 1);
        }
        else
        {
            $this->view->setVar('user_can_create_projects', 0);
        }
    }

    private function crazysort(&$comments, $parentComment = 0, $level = 0, $count = null)
    {
        if (is_array($comments) && count($comments))
        {

            $return = array();
            if (is_null($count)){
                $c = count($comments);
            }else{
                $c = $count;
            }
            for($i=0;$i<$c;$i++)
            {
                if (!isset($comments[$i])) continue;
                $comment = $comments[$i];
                $parentId = $comment['parent'];
                if ($parentId == $parentComment)
                {
                    $comment['level'] = $level;
                    $commentId = $comment['id'];
                    $return[] = $comment;
                    unset($comments[$i]);
                    while ($nextReturn = $this->crazysort($comments, $commentId, $level+1, $c))
                    {
                        $return = array_merge($return, $nextReturn);
                    }
                }
            }
            return $return;
        }
        return false;
    }
    
    private function getProjectUsers($project_id) {
        $result = [
            1 => [],
            2 => []
        ];
        
        $lift_project_access = new Lift_project_access();
        $project_accesses = $lift_project_access->read(['project' => $project_id]);
        
        if (empty($project_accesses)) {
            return $result;
        }
        
        foreach ($project_accesses as $project_access) {
            $result[$project_access['level']][] = $project_access['user'];
        }
        
        return $result;
    }
    
    private function getTaskUsers($task_id) {
        $result = [
            1 => [],
            2 => []
        ];
        
        $lift_task_access = new Lift_task_access();
        $task_accesses = $lift_task_access->read(['task' => $task_id]);
        
        if (empty($task_accesses)) {
            return $result;
        }
        
        foreach ($task_accesses as $task_access) {
            $result[$task_access['level']][] = $task_access['user'];
        }
        
        return $result;
    }

    public function deleteTskCommentaryAction()
    {
        $this->view->setRenderLevel(1);

        $token=$this->session->get('logged_user')['success']['token'];

        $condition=array
        (
            'id'=>  $this->request->getPost('commentary_id')
        );

        $lift_commentary=new Lift_Tskcommentary();
        $commentary=$lift_commentary->read($condition)[0];

        $condition=array
        (
            'id'=>  $commentary['task']
        );

        $lift_task=new Lift_Task();
        $task=$lift_task->read($condition)[0];

        $condition=array
        (
            'id'=>  $task['project']
        );

        $lift_project=new Lift_Project();
        $project=$lift_project->read_($condition)[0];

        if($this->session->get('logged_user')['success']['group']==1 ||  $project['administrator']==$this->session->get('logged_user')['success']['id'])
        {

            $data['id']=$this->request->getPost('commentary_id');

            $lift_commentary=new Lift_Tskcommentary();

            $result=$lift_commentary->delete($token, $data);

            if(!empty($result['success']))
            {
                $this->response->setStatusCode(200, "OK");

            }
            else
            {
                $this->response->setStatusCode(500, var_dump($result));
            };

        }
        else
        {
            $error=array('hasRights'=>true);
            $result['error']=$error;
            $this->response->setStatusCode(500, var_dump($result));

        };

    }

    public function deleteCommentaryAction()
    {
        $this->view->setRenderLevel(1);

        $token=$this->session->get('logged_user')['success']['token'];

        $condition=array
        (
            'id'=>  $this->request->getPost('commentary_id')
        );

        $lift_prcommentary=new Lift_Prcommentary();
        $commentary=$lift_prcommentary->read($condition)[0];

        $condition=array
        (
            'id'=>  $commentary['post']
        );

        $lift_post=new Lift_Prpost();
        $post=$lift_post->read($condition)[0];

        $condition=array
        (
            'id'=>  $post['project']
        );

        $lift_project=new Lift_project();
        $project=$lift_project->read_($condition)[0];

        if($this->session->get('logged_user')['success']['group']==1 ||  $project['administrator']==$this->session->get('logged_user')['success']['id'])
        {

            $data['id']=$this->request->getPost('commentary_id');

            $result=$lift_prcommentary->delete($token, $data);

            var_dump($data);
            var_dump($result);
            if(!empty($result['success']))
            {
                $this->response->setStatusCode(200, "OK");

            }
            else
            {
                $this->response->setStatusCode(500, var_dump($result));
            };

        }
        else
        {
            $error=array('hasRights'=>true);
            $result['error']=$error;
            $this->response->setStatusCode(500, var_dump($result));

        };

    }

    public function writeTskCommentaryAction()
    {
        $this->view->setRenderLevel(1);

        $token=$this->session->get('logged_user')['success']['token'];

        //$data['deleted']=;
        $data['creation_time']=date('Y-m-d H:i:s');
        $data['text']=$this->request->getPost('text');
        $data['task']=$this->request->getPost('task');
        $data['user']=$this->session->get('logged_user')['success']['id'];

        //echo $this->session->get('logged_user')['success']['id'];

//
        if(!empty($this->request->getPost('post')))
        {
            $data['post']=$this->request->getPost('post');
        };

        if(!empty($this->request->getPost('parent')))
        {
            $data['parent']=$this->request->getPost('parent');
        }
        else
        {
            $data['parent']="";
        };

//        echo "<pre>";
//        var_dump($data);
//        die();

        $lift_commentary=new Lift_Tskcommentary();

        $result=$lift_commentary->create($token, $data);

        $condition_commentary_getLast_id=array
        (

            'task'=>$this->request->getPost('task')
        );

        $last_id=$lift_commentary->getLastId($token, $condition_commentary_getLast_id);

//        var_dump($last_id);

        $condition_read=array
        (
            'id'=>$last_id,
        );

        $commentary=$lift_commentary->read_LastId($condition_read);

//        var_dump($commentary);

        if($result['success'])
        {
            $this->view->setVar('commentary', $commentary[0]);
            //$this->response->setStatusCode(200, "OK");
            // echo json_encode($commentary);

            //var_dump($commentary);
        }
        else
        {
            $this->response->setStatusCode(500, var_dump($result));
        };

    }

    public function writeCommentaryAction()
    {
        $this->view->setRenderLevel(1);

        $token=$this->session->get('logged_user')['success']['token'];

        //$data['deleted']=;
        $data['creation_time']=date('Y-m-d H:i:s');
        $data['text']=$this->request->getPost('text');
        $data['post']=$this->request->getPost('post');
        $data['user']=$this->session->get('logged_user')['success']['id'];

        //echo $this->session->get('logged_user')['success']['id'];

//
        if(!empty($this->request->getPost('post')))
        {
            $data['post']=$this->request->getPost('post');
        };

        if(!empty($this->request->getPost('parent')))
        {
            $data['parent']=$this->request->getPost('parent');
        }
        else
        {
            $data['parent']="";
        };

        //echo "<pre>";
        //var_dump($data);
        //die();

        $lift_commentary=new Lift_Prcommentary();

        $result=$lift_commentary->create($token, $data);

        $condition_commentary_getLast_id=array
        (

            'post'=>$this->request->getPost('post')
        );

        $last_id=$lift_commentary->getLastId($token, $condition_commentary_getLast_id);

//        var_dump($last_id);

        $condition_read=array
        (
            'id'=>$last_id,
        );

        $commentary=$lift_commentary->read_LastId($condition_read);

        if($result['success'])
        {
            $this->view->setVar('commentary', $commentary[0]);
            //$this->response->setStatusCode(200, "OK");
            // echo json_encode($commentary);

            //var_dump($commentary);
        }
        else
        {
            $this->response->setStatusCode(500, var_dump($result));
        };

    }

    public function taskAction($task_id) {
        $lift_task = new Lift_Task();
        $task = $lift_task->read(['id' => $task_id]);
        
        if (empty($task[0])) {
            throw new Exception('Non-existent task', 404);
        }

        $task = $task[0];
        $lift_project = new Lift_project();
        $project = $lift_project->read_(['id' => $task['project']]);
        
        if (empty($project[0])) {
            throw new Exception('Non-existent project', 404);
        }
        
        $project = $project[0];
        $project['users'] = $this->getProjectUsers($task['project']);
        
        if (empty($this->session->get('logged_user')['success']) ||
            (
                $this->session->get('logged_user')['success']['id'] != $project['administrator']
                &&
                !in_array($this->session->get('logged_user')['success']['id'], $project['users'][1])
                &&
                $this->session->get('logged_user')['success']['group'] != 1
            )
           ) {
            throw new Exception('Forbidden', 403);
        }

        // Comments
        $lift_tskcommentary=new Lift_Tskcommentary();
        $commentaries = $lift_tskcommentary->read_task(['task' => $task_id]);
        $commentaries = $this->crazysort($commentaries);
        $task['commentary_amount'] = sizeof($commentaries);
        
        
        // Access
        $user_can_write_commentaries = !empty($this->session->get('logged_user')['success']['id']);
        $user_can_delete_commentaries = $this->session->get('logged_user')['success']['group'] == 1 || $project['administrator'] == $this->session->get('logged_user')['success']['id'];
        
        
        // View vars
        $this->view->setVar('headings', $this->getHeadings());
        $this->view->setVar('commentaries', $commentaries);
        $this->view->setVar('project', $project);
        $this->view->setVar('task', $task);
        $this->view->setVar('user_can_write_commentaries', $user_can_write_commentaries);
        $this->view->setVar('user_can_delete_commentaries', $user_can_delete_commentaries);
    }
    
    public function showAction($id) {
        $lift_project = new Lift_Project();
        $project = $lift_project->read_([
            'id' => $id,
            'deleted' => false
        ]);
        
        if (empty($project[0])) {
            throw new Exception('Non-existent project', 404);
        }
        
        $project = $project[0];
        $project['users'] = $this->getProjectUsers($project['id']);
        
        // Users
        $users = [];
        $users = array_merge($users, $project['users'][1], $project['users'][2]);
        $users[] = $project['administrator'];
        
        $lift_user = new Lift_User();
        $users = $lift_user->readCertain(array_unique($users));
        
        // Headings
        $lift_heading = new Lift_Heading();
        $headings = $lift_heading->readAll()['success'];
        
        // View vars
        $this->view->setVar('users', $users);
        $this->view->setVar('headings', $headings);
        $this->view->setVar('project',$project);
    }

    public function postAction($post_id) {

        $lift_post = new Lift_Prpost();
        $post = $lift_post->read([
            'id' => $post_id,
            'deleted' => false
        ]);
        
        if (empty($post[0])) {
            throw new Exception('Non-existent post', 404);
        }

        $post = $post[0];
        $lift_project = new Lift_project();
        $project = $lift_project->read_(['id' => $post['project']]);
        
        if (empty($project[0])) {
            throw new Exception('Non-existent project', 404);
        }
        
        $project = $project[0];
        $project['users'] = $this->getProjectUsers($post['project']);
        
        // if (empty($this->session->get('logged_user')['success']) ||
        //     (
        //         $this->session->get('logged_user')['success']['id'] != $project['administrator']
        //         &&
        //         !in_array($this->session->get('logged_user')['success']['id'], $project['users'][1])
        //         &&
        //         $this->session->get('logged_user')['success']['group'] != 1
        //     )
        //    ) {
        //     throw new Exception('Forbidden', 403);
        // }
        
        $lift_prpost_ip = new Lift_Prpost_ip();
        $lift_prpost_ip->create([
            'post' => $post_id,
            'ip' => $_SERVER['REMOTE_ADDR']
        ]);
        $post['views'] = $lift_prpost_ip->amountOfViews($post_id);
        
        $lift_user = new Lift_User();
        $user = $lift_user->read(['id' => $post['user']])[0];

        $post['email']=$user['email'];

        $lift_commentary=new Lift_Prcommentary();
        $condition=array
        (
            'post'=>$post_id
        );

        $commentaries=$lift_commentary->read_post($condition);

        $token=$this->session->get('logged_user')['success']['token'];

        foreach($commentaries as &$commentary)
        {

            if(empty($commentary['text']) || $commentary['deleted']=='t')
            {
                $commentary['text']="НЛО прилетело и опубликовало эту надпись здесь.";
            }
        }

        $commentaries=$this->crazysort($commentaries);

        $lift_heading = new Lift_Heading();
        $headings=$lift_heading->readAll()['success'];

        $this->view->setVar('post', $post);
        $this->view->setVar('headings', $headings);
        $this->view->setVar('commentaries', $commentaries);
        $this->view->setVar('project', $project);

        if(!empty($this->session->get('logged_user')['success']['id'] )) {
            $this->view->setVar('user_can_write_commentaries', 1);
        } else {
            $this->view->setVar('user_can_write_commentaries', 0);
        }

        if( $this->session->get('logged_user')['success']['group']==1 || $project['administrator']==$this->session->get('logged_user')['success']['id'] ) {
            $this->view->setVar('user_can_delete_commentaries', 1);
        } else {
            $this->view->setVar('user_can_delete_commentaries', 0);
        }
    }

    public function postsAction($project_id) {

        // Project
        $lift_project = new Lift_Project();
        $project = $lift_project->read_(['id' => $project_id]);
        
        if (empty($project[0])) {
            throw new Exception('Non-existent project', 404);
        }
        
        $project = $project[0];
        $project['users'] = $this->getProjectUsers($project['id']);
        
        
        // Users
        $users = [];
        $users = array_merge($users, $project['users'][1], $project['users'][2]);
        $users[] = $project['administrator'];
        
        $lift_user = new Lift_User();
        $users = $lift_user->readCertain(array_unique($users));
        
        
        // Pagination
        $lift_prpost= new Lift_Prpost();
        $amount = intval($lift_prpost->amountOfPrposts($project_id));
        $pagination = $this->makePagination($amount, 5, $this->request->get('page'));

        // Posts
        $posts = $lift_prpost->readPrposts_LimitOffset($pagination['max'], $pagination['start'], $project_id);
        
        
        // View vars
        $this->view->setVars([
            'posts' => $posts,
            'users' => $users,
            'headings' => $this->getHeadings(),
            'pagination' => $pagination,
            'project' => $project
        ]);
        
        $request = new Phalcon\Http\Request();
        if ($request->isAjax()) {
            $this->view->pick('project/posts.ajax');
        }
    }

    public function tasksAction($project_id) {
        $lift_project = new Lift_project();
        $project = $lift_project->read_(['id' => $project_id]);
        
        if (empty($project[0])) {
            throw new Exception('Non-existent project', 404);
        }
        
        $project = $project[0];
        $project['users'] = $this->getProjectUsers($project_id);
        
        if (empty($this->session->get('logged_user')['success']) ||
            (
                $this->session->get('logged_user')['success']['id'] != $project['administrator']
                &&
                !in_array($this->session->get('logged_user')['success']['id'], $project['users'][1])
                &&
                !in_array($this->session->get('logged_user')['success']['id'], $project['users'][2])
                &&
                $this->session->get('logged_user')['success']['group'] != 1
            )
           ) {
            throw new Exception('Forbidden', 403);
        }
    
        $token = $this->session->get('logged_user')['success']['token'];
        $lift_task = new Lift_Task();
        $amount = intval($lift_task->amountOfTasks($project_id));
        $pagination = $this->makePagination($amount, 10, $this->request->get('page'));
        $tasks = $lift_task->readTasks_LimitOffset($pagination['max'], $pagination['start'], $project_id);
        $headings = $this->getHeadings();

        // Users
        $users = [ $project['administrator'] ];
        foreach ($tasks as &$task) {
            $task['users'] = $this->getTaskUsers($task['id']);
            $users = array_merge($users, $task['users'][1], $task['users'][2]);
            $users[] = $task['user'];
        }
        
        $lift_user = new Lift_User();
        $users = $lift_user->readCertain(array_unique($users));
        
        
        // View vars
        $this->view->setVars([
            'tasks' => $tasks,
            'users' => $users,
            'headings' => $headings,
            'pagination' => $pagination,
            'project' => $project
        ]);
    }

    public function post_deleteAction($post_id) {
        $token = $this->session->get('logged_user')['success']['token'];
        $lift_post = new Lift_Prpost();
        $result = $lift_post->delete($token, ['id' => $post_id]);
        $this->view->setVar('result', $result);
    }

    public function task_deleteAction($task_id) {
        $token = $this->session->get('logged_user')['success']['token'];
        $lift_task = new Lift_Task();
        $result = $lift_task->delete($token, ['id' => $task_id]);
        $this->view->setVar('result', $result);
    }
    
    
    public function updateTaskAction($task_id) {
        $lift_task = new Lift_Task();
        $task = $lift_task->read(['id' => $task_id]);

        if (empty($task[0])) {
            throw new Exception('Non-existent task', 404);
        }
        
        $task = $task[0];
        
        $lift_project = new Lift_project();
        $project = $lift_project->read_(['id' => $project_id]);
        
        if (empty($project[0])) {
            throw new Exception('Non-existent project', 404);
        }
        
        $project = $project[0];
        $project['users'] = $this->getProjectUsers($post['project']);
        
        if (empty($this->session->get('logged_user')['success']) ||
            (
                $this->session->get('logged_user')['success']['id'] != $project['administrator']
                &&
                !in_array($this->session->get('logged_user')['success']['id'], $project['users'][1])
                &&
                $this->session->get('logged_user')['success']['group'] != 1
            )
           ) {
            throw new Exception('Forbidden', 403);
        }
        
        $token = $this->session->get('logged_user')['success']['token'];

        if ($this->request->getPost('submit')) {
            $data = [
                'title' => trim($this->request->getPost('title')),
                'text' => trim($this->request->getPost('text')),
                'status' => $this->request->getPost('status'),
                'start_time' => $this->request->getPost('start_time'),
                'end_time' => $this->request->getPost('end_time')
            ];

            if (empty($data['title'])) {
                $error['data']['title'] = true;
            }
            
            if (empty($data['text'])) {
                $error['data']['text'] = true;
            }
            
            if (empty($data['start_time'])) {
                $error['data']['start_time']['empty'] = true;
            }
            
            if (empty($data['end_time'])) {
                $error['data']['end_time']['empty'] = true;
            }
            
            if (!empty($data['start_time']) && !empty($data['end_time']) && $data['end_time'] < $data['start_time']) {
                $error['data']['end_time']['min'] = true;
            }

            $email = $this->request->getPost('email');
            if (!empty($email)) {
                $responsible = $this->getUsersByEmails($email);
                
                if ($responsible['status'] == 'error') {
                    $error['data']['email']['not_existed_user'] = true;
                } else {
                    $responsible = $responsible['users'][0];
                }
            } else {
                $error['data']['email']['empty'] = true;
            }
            
            $emails = $this->request->getPost('emails');
            if ($emails) {
                $participants = $this->getUsersByEmails($emails);
                
                if ($participants['status'] == 'error') {
                    $error['data']['emails']['not_existed_user'] = true;
                } else {
                    $participants = $participants['users'];
                }
            }

            if (empty($error)) {
                $result = $lift_task->update($token, $data, ['id' => $task_id]);

                if (!empty($result['success'])) {
                    $lift_task_access = new Lift_Task_access();
                    $lift_task_access->delete($token, ['task' => $task_id]);
                    
                    $lift_task_access->create($token, [
                        'user' => $responsible['id'],
                        'task' => $task_id,
                        'level' => 1
                    ]);

                    foreach ($participants as $participant) {
                        if ($participant['id'] == $task['user']) {
                            continue;
                        }
                        
                        $lift_task_access->create($token, [
                            'user' => $participant['id'],
                            'task' => $task_id,
                            'level' => 2
                        ]);
                    }

                    $response = new \Phalcon\Http\Response();
                    return $response->redirect('/projects/' . $task['project'] . '/tasks/' . $task_id);
                }
            }
            
            $data['email'] = $email;
            $data['emails'] = $emails;
            $task = $data;

            $this->view->setVar('result', ['error' => $error]);
        } else {
            $lift_user = new Lift_User();
            $users = $this->getTaskUsers($task_id);
            
            if (!empty($users[1][0])) {
                $task['email'] = $lift_user->read(['id' => $users[1][0]])[0]['email'];
            } else {
                $task['email'] = '';
            }
            
            if (!empty($users[2])) {
                $participants = $lift_user->readCertain($users[2]);
                $task['emails'] = implode(' ', array_column($participants, 'email'));
            } else {
                $task['emails'] = '';
            }
        }

        $this->view->setVars([
            'task' => $task
        ]);
    }

    public function updatePostAction($post_id) {
        $lift_prpost = new Lift_Prpost();
        $post = $lift_prpost->read(['id' => $post_id]);

        if (empty($post[0])) {
            throw new Exception('Non-existent post', 404);
        }
        
        $post = $post[0];

        $lift_project = new Lift_Project();
        $project = $lift_project->read_(['id' => $post['project']]);
        
        if (empty($project[0])) {
            throw new Exception('Non-existent project', 404);
        }
        
        $project = $project[0];
        $project['users'] = $this->getProjectUsers($post['project']);
        
        if (empty($this->session->get('logged_user')['success']) ||
            (
                $this->session->get('logged_user')['success']['id'] != $project['administrator']
                &&
                !in_array($this->session->get('logged_user')['success']['id'], $project['users'][1])
                &&
                $this->session->get('logged_user')['success']['group'] != 1
                &&
                $this->session->get('logged_user')['success']['group'] != 3
            )
           ) {
            throw new Exception('Forbidden', 403);
        }
        
        if ($this->request->getPost('submit')) {
            $data = [
                'title' => trim($this->request->getPost('title')),
                'text' => trim($this->request->getPost('text')),
                'annotation' => trim($this->request->getPost('annotation')),
                'background' => $this->request->getPost('background'),
                'avatar' => $this->request->getPost('avatar'),
                'status' => 1
            ];

            if(!empty($this->request->getPost('user_email')))
            {
                $lift_user=new Lift_User();
                $condition['email']=trim($this->request->getPost('user_email'));
                $user=$lift_user->read($condition)[0];

                if(empty($user))
                {
                    $error['data']['user']=true;
                }
                else
                {
                    $data['user']=$user['id'];
                }
            }
            else
            {
                //$data['user'] = $this->session->get('logged_user')['success']['id'];
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

            if (empty($data['title'])) {
                $error['data']['title'] = true;
            }
            
            if (empty($data['text'])) {
                $error['data']['text'] = true;
            }
            
            if (empty($data['annotation'])) {
                $error['data']['annotation'] = true;
            }

            if (empty($error)) {
                $token = $this->session->get('logged_user')['success']['token'];
                $result = $lift_prpost->update($token, $data, ['id' => $post_id]);
                
                if (!empty($result['success'])) {
                    $response = new \Phalcon\Http\Response();
                    return $response->redirect('/projects/' . $project['id'] . '/posts/' . $post_id);
                } else {
                    $this->view->setVar('debug', $data);
                    $error['database']['pg_insert'] = true;
                }
            }

            $lift_user=new Lift_User();
            $user=$lift_user->read(['id'=>$post['user']])[0];
            $data['user_email']=$user['email'];

            $post = $data;
            $this->view->setVar('result', ['error' => $error]);
        }
        else
        {
            $lift_user=new Lift_User();
            $user=$lift_user->read(['id'=>$post['user']])[0];
            $post['user_email']=$user['email'];
        }

        
        $this->view->setVar('post', $post);
    }

    public function createPostAction($project_id) {
        $lift_project = new Lift_project();
        $project = $lift_project->read_(['id' => $project_id]);
        
        if (empty($project[0])) {
            throw new Exception('Non-existent project', 404);
        }
        
        $project = $project[0];
        $project['users'] = $this->getProjectUsers($post['project']);
        
        if (empty($this->session->get('logged_user')['success']) ||
            (
                $this->session->get('logged_user')['success']['id'] != $project['administrator']
                &&
                !in_array($this->session->get('logged_user')['success']['id'], $project['users'][1])
                &&
                $this->session->get('logged_user')['success']['group'] != 1
            )
           ) {
            throw new Exception('Forbidden', 403);
        }
        
        if ($this->request->getPost('submit')) {
            $data = [
                'project' => $project_id,
                'title' => trim($this->request->getPost('title')),
                'text' => trim($this->request->getPost('text')),
                'annotation' => trim($this->request->getPost('annotation')),
                //'user' => $token=$this->session->get('logged_user')['success']['id'],
                'background' => $this->request->getPost('background'),
                'avatar' => $this->request->getPost('avatar'),
                'status' => 1
            ];

            if(!empty($this->request->getPost('user_email')))
            {
                $lift_user=new Lift_User();
                $condition['email']=trim($this->request->getPost('user_email'));
                $user=$lift_user->read($condition)[0];

                if(empty($user))
                {
                    $error['data']['user']=true;
                }
                else
                {
                    $data['user']=$user['id'];
                }
            }
            else
            {
                $data['user'] = $this->session->get('logged_user')['success']['id'];
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

            if (empty($data['title'])) {
                $error['data']['title'] = true;
            }
            
            if (empty($data['text'])) {
                $error['data']['text'] = true;
            }
            
            if (empty($data['annotation'])) {
                $error['data']['annotation'] = true;
            }

            if (empty($error)) {
                $token = $this->session->get('logged_user')['success']['token'];
                $lift_prpost = new Lift_Prpost();
                $result = $lift_prpost->create($token, $data);
                $post_id = $lift_prpost->getLastId();
                
                $response = new \Phalcon\Http\Response();
                return $response->redirect('/projects/' . $project_id . '/posts/' . $post_id);
            } else {
                $data['user_email']=trim($this->request->getPost('user_email'));
                $this->view->setVar('result', ['error' => $error]);
                $this->view->setVar('post', $data);

            }
        }
    }

    public function createTaskAction($project_id) {
        $lift_project = new Lift_project();
        $project = $lift_project->read_(['id' => $project_id]);
        
        if (empty($project[0])) {
            throw new Exception('Non-existent project', 404);
        }
        
        $project = $project[0];
        $project['users'] = $this->getProjectUsers($post['project']);
        
        if (empty($this->session->get('logged_user')['success']) ||
            (
                $this->session->get('logged_user')['success']['id'] != $project['administrator']
                &&
                !in_array($this->session->get('logged_user')['success']['id'], $project['users'][1])
                &&
                $this->session->get('logged_user')['success']['group'] != 1
            )
           ) {
            throw new Exception('Forbidden', 403);
        }
        
        if ($this->request->getPost('submit')) {
            $data = [
                'project' => $project_id,
                'title' => trim($this->request->getPost('title')),
                'text' => trim($this->request->getPost('text')),
                'user' => $this->session->get('logged_user')['success']['id'],
                'status' => $this->request->getPost('status'),
                'start_time' => $this->request->getPost('start_time'),
                'end_time' => $this->request->getPost('end_time')
            ];
            
            if (empty($data['title'])) {
                $error['data']['title'] = true;
            }
            
            if (empty($data['text'])) {
                $error['data']['text'] = true;
            }
            
            if (empty($data['start_time'])) {
                $error['data']['start_time']['empty'] = true;
            }
            
            if (empty($data['end_time'])) {
                $error['data']['end_time']['empty'] = true;
            }
            
            if (!empty($data['start_time']) && !empty($data['end_time']) && $data['end_time'] < $data['start_time']) {
                $error['data']['end_time']['min'] = true;
            }

            $lift_user = new Lift_User();
            
            $email = $this->request->getPost('email');
            if (!empty($email)) {
                $responsible = $this->getUsersByEmails($email);
                
                if ($responsible['status'] == 'error') {
                    $error['data']['email']['not_existed_user'] = true;
                } else {
                    $responsible = $responsible['users'][0];
                }
            } else {
                $error['data']['email']['empty'] = true;
            }
            
            $emails = $this->request->getPost('emails');
            if ($emails) {
                $participants = $this->getUsersByEmails($emails);
                
                if ($participants['status'] == 'error') {
                    $error['data']['emails']['not_existed_user'] = true;
                } else {
                    $participants = $participants['users'];
                }
            }
            
            if (empty($error)) {
                $token = $this->session->get('logged_user')['success']['token'];
                $lift_task = new Lift_Task();
                $result = $lift_task->create($token, $data);
                
                if (!empty($result['success'])) {
                    $id = $lift_task->getLastId($token);
                    $lift_task_access = new Lift_Task_access();
                    
                    $lift_task_access->create($token, [
                        'user' => $responsible['id'],
                        'task' => $id,
                        'level' => 1
                    ]);

                    foreach ($participants as $participant) {
                        if ($participant['id'] == $data['user']) {
                            continue;
                        }
                        
                        $lift_task_access->create($token, [
                            'user' => $participant['id'],
                            'task' => $id,
                            'level' => 2
                        ]);
                    }
                    
                    $response = new \Phalcon\Http\Response();
                    return $response->redirect('/projects/' . $project_id . '/tasks/' . $id);
                }
            }
            
            $data['email'] = $email;
            $data['emails'] = $emails;
            
            $this->view->setVars([
                'task' => $data,
                'result' => ['error' => $error]
            ]);
        }
    }

    public function createAction() {
        if (!$this->session->get("logged_user") || !in_array($this->session->get("logged_user")['success']['group'], [1, 3])) {
            throw new Exception('Forbidden', 403);
        }
            
            
        if ($this->request->getPost('submit')) {
            $token = $this->session->get('logged_user')['success']['token'];

            $data = [
                'title' => trim($this->request->getPost('title')),
                'heading' => $this->request->getPost('heading'),
                //'administrator' => $this->session->get('logged_user')['success']['id'],
                'type' => 2,
                'start_time' => $this->request->getPost('start_time'),
                'end_time' => $this->request->getPost('end_time'),
                'description' => trim($this->request->getPost('description')),
                'relevance' => trim($this->request->getPost('relevance')),
                'purpose' => trim($this->request->getPost('purpose')),
                'solutions' => trim($this->request->getPost('solutions')),
                'background' => $this->request->getPost('background'),
                'avatar' => $this->request->getPost('avatar')
            ];

            if(!empty($this->request->getPost('administrator_email')))
            {
                $lift_user=new Lift_User();
                $condition['email']=trim($this->request->getPost('administrator_email'));
                $user=$lift_user->read($condition)[0];

                if(empty($user))
                {
                    $error['data']['user']=true;
                }
                else
                {
                    $data['administrator']=$user['id'];
                }
            }
            else
            {
                $data['administrator'] = $this->session->get('logged_user')['success']['id'];
            }

            $emails1 = $this->request->getPost('emails');
            $emails2 = $this->request->getPost('emails2');

            if ($emails1) {
                $users1 = $this->getUsersByEmails($emails1);
                
                if ($users['status'] == 'error') {
                    $error['not_existed_user'] = true;
                } else {
                    $users1 = $users1['users'];
                }
            }
            
            if ($emails2) {
                $users2 = $this->getUsersByEmails($emails2);
                
                if ($users2['status'] == 'error') {
                    $error['not_existed_user'] = true;
                } else {
                    $users2 = $users2['users'];
                }
            }

            if (empty($data['title'])) {
                $error['data']['title'] = true;
            }
            
            if (empty($data['heading'])) {
                $error['data']['heading'] = true;
            }
            
            if (empty($data['description'])) {
                $error['data']['description'] = true;
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
                $lift_project = new Lift_project();
                $result = $lift_project->create($token, $data);
                
                if (!empty($result['success'])) {
                    $id = $lift_project->getLastId($token);
                    $lift_project_access = new Lift_project_access();

                    foreach ($users1 as $user) {
                        if ($user['id'] == $data['administrator']) {
                            continue;
                        }
                        
                        $data_project_access = [
                            'user' => $user['id'],
                            'project' => $id,
                            'level' => 1
                        ];

                        $lift_project_access->create($token, $data_project_access);
                    }

                    foreach ($users2 as $user) {
                        if ($user['id'] == $data['administrator']) {
                            continue;
                        }
                        
                        $data_project_access = [
                            'user' => $user['id'],
                            'project' => $id,
                            'level' => 2
                        ];

                        $lift_project_access->create($token, $data_project_access);
                    }
                    
                    $response = new \Phalcon\Http\Response();
                    return $response->redirect('/projects/' . $id);
                }
            } else {
                $result['error'] = $error;

                $project = $data;
                $project['emails'] = $this->request->getPost('emails');
                $project['emails2'] = $this->request->getPost('emails2');
                $project['administrator_email'] = trim($this->request->getPost('administrator_email'));

                $this->view->setVar('result', $result);
                $this->view->setVar('project', $project);
            }
        }
        
        $this->view->setVar('headings', $this->getHeadings());
    }

    public function indexAction() {
        $lift_project = new Lift_project();
        $headings_checked = $this->request->get('headings');
        $amount = $lift_project->amount_filter($headings_checked);
        $pagination = $this->makePagination($amount, 4, $this->request->get('page'));
        $projects = $lift_project->readLimitOffset_filter($pagination['max'], $pagination['start'], $headings_checked)['success'];
        $headings = $this->getHeadings();

        // Users
        $users = [];
        foreach ($projects as &$project) {
            $project['users'] = $this->getProjectUsers($project['id']);
            $users = array_merge($users, $project['users'][1], $project['users'][2]);
            $users[] = $project['administrator'];
        }
        
        $lift_user = new Lift_User();
        $users = $lift_user->readCertain(array_unique($users));

        
        // View vars
        $this->view->setVar('headings_checked', $headings_checked);
        $this->view->setVar('pagination', $pagination);
        $this->view->setVar('users', $users);
        $this->view->setVar('headings', $headings);
        $this->view->setVar('projects', $projects);
        
        // Ajax handling
        $request = new Phalcon\Http\Request();
        if ($request->isAjax()) {
            $this->view->pick('project/index.ajax');
        }
    }

    public function deleteAction($id)
    {
        $token=$this->session->get('logged_user')['success']['token'];

        $condition=array
        (
            'id'=>$id
        );

        $lift_project = new Lift_project();
        $project=$lift_project->read($token, $condition)[0];

        $lift_project_access = new Lift_project_access();
        $condition=array
        (
            'project'=>$id
        );

        $project_accesss=$lift_project_access->read($condition);

        foreach($project_accesss as $project_access)
        {
            $hasRights[]=$project_access['user'];
        }

        if(
            $this->session->get('logged_user')['success']['group']==1 ||
            $project['administrator']==$token=$this->session->get('logged_user')['success']['id'] ||
                in_array($this->session->get('logged_user')['success']['id'], $hasRights)

        )
        {

            $lift_post= new Lift_Prpost();

            $condition_post=array
            (
                'project'=>$id
            );

            $result=$lift_post->delete($token, $condition_post);

            $lift_project_access=new Lift_project_access();
            $lift_project_access->delete($token, $condition_post);

            $condition=array
            (
                'id'=>$id
            );

            $result=$lift_project->delete($token, $condition);

            $this->view->setVar('result', $result);

        }
        else
        {
            $this->view->setVar('result', array('error'=>$error));
        }

    }

    public function updateAction($id) {
        $lift_project = new Lift_Project();
        $project = $lift_project->read_([
            'id' => $id,
            'deleted' => false
        ]);

        if (empty($project[0])) {
            throw new Exception('Non-existent project', 404);
        }
        
        $project = $project[0];
        $project['users'] = $this->getProjectUsers($project['id']);

        if (!$this->session->get('logged_user') ||
            (
                $this->session->get('logged_user')['success']['group'] != 1
                &&
                $this->session->get('logged_user')['success']['id'] != $project['administrator']
                &&
                !in_array($this->session->get('logged_user')['success']['id'], $project['users'][1])
            )) {
            throw new Exception('Forbidden', 403);
        }
        
        // On submit
        if ($this->request->getPost('submit'))
        {
            $token = $this->session->get('logged_user')['success']['token'];

            $data = [
                'title' => trim($this->request->getPost('title')),
                'heading' => $this->request->getPost('heading'),
                //'administrator' => $this->session->get('logged_user')['success']['id'],
                'type' => 2,
                'start_time' => $this->request->getPost('start_time'),
                'end_time' => $this->request->getPost('end_time'),
                'description' => trim($this->request->getPost('description')),
                'relevance' => trim($this->request->getPost('relevance')),
                'purpose' => trim($this->request->getPost('purpose')),
                'solutions' => trim($this->request->getPost('solutions')),
                'background' => $this->request->getPost('background'),
                'avatar' => $this->request->getPost('avatar')
            ];

            if(!empty($this->request->getPost('administrator_email')))
            {

                $lift_user=new Lift_User();
                $user=$lift_user->read(['email'=>trim($this->request->getPost('administrator_email'))])[0];

                if(empty($user))
                {
                    $error['data']['user']=true;
                }
                else
                {
                    $data['administrator']=$user['id'];
                }
            }
            else
            {
               // $data['administrator'] = $this->session->get('logged_user')['success']['id'];
            }

            $emails1 = $this->request->getPost('emails');
            $emails2 = $this->request->getPost('emails2');

            if ($emails1) {
                $users1 = $this->getUsersByEmails($emails1);
                
                if ($users1['status'] == 'error') {
                    $error['not_existed_user'] = true;
                } else {
                    $users1 = $users1['users'];
                }
            }
            
            if ($emails2) {
                $users2 = $this->getUsersByEmails($emails2);
                
                if ($users2['status'] == 'error') {
                    $error['not_existed_user'] = true;
                } else {
                    $users2 = $users2['users'];
                }
            }
            
            if (empty($data['title'])) {
                $error['data']['title'] = true;
            }
            
            if (empty($data['heading'])) {
                $error['data']['heading'] = true;
            }
            
            if (empty($data['description'])) {
                $error['data']['description'] = true;
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
                $result = $lift_project->update($token, $data, ['id' => $id]);
                
                if (!empty($result['success'])) {
                    $lift_project_access = new Lift_Project_Access();
                    $lift_project_access->delete($token, ['project' => $project['id']]);
                      
                    if (!empty($users1)) {
                        foreach ($users1 as $user) {
                            if ($user['id'] == $project['administrator']) {
                                continue;
                            }
                            
                            $lift_project_access->create($token, [
                                'user' => $user['id'],
                                'project' => $project['id'],
                                'level' => 1
                            ]);
                        }
                    }

                    if (!empty($users2)) {
                        foreach ($users2 as $user) {
                            if ($user['id'] == $project['administrator']) {
                                continue;
                            }
                            
                            $lift_project_access->create($token, [
                                'user' => $user['id'],
                                'project' => $project['id'],
                                'level' => 2
                            ]);
                        }
                    }
                    
                    $response = new \Phalcon\Http\Response();
                    return $response->redirect('/projects/' . $project['id']);
                } else {
                    $error['database']['pg_insert'] = true;
                }
            }
            
            $result['error'] = $error;

            $data['administrator_email']=$lift_user->read(['id'=>$project['administrator']])[0]['email'];

            $project = $data;
            $project['emails'] = $emails1;
            $project['emails2'] = $emails2;

            $this->view->setVar('result', $result);
        }// end on submit
        else
        {

            $lift_user = new Lift_User();
            $users1 = $lift_user->readCertain($project['users'][1]);
            $users2 = $lift_user->readCertain($project['users'][2]);
            $project['emails'] = $users1 ? implode(' ', array_column($users1, 'email')) : null;
            $project['emails2'] = $users2 ? implode(' ', array_column($users2, 'email')) : null;

            $administrator_email=$lift_user->read(['id'=>$project['administrator']])[0]['email'];
            $project['administrator_email']=$administrator_email;

        }

        $this->view->setVar('project', $project);
        $this->view->setVar('headings', $this->getHeadings());
    }
}

