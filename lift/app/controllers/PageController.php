<?php

class PageController extends ControllerBase
{

    public function indexAction()
    {
        if (empty($this->session->get("logged_user")['success']) || $this->session->get("logged_user")['success']['group'] != 1) {
            throw new Exception('Forbidden', 403);
        }

        $lift_page = new Lift_Page();
        $pages = $lift_page->readAll();

        if (!empty($pages['success'])) {
            $this->view->setVar('pages', $pages['success']);
        } else {
            $this->view->setVar('pages', []);
        }
    }

    public function showAction($id)
    {
        if (!$id) {
            throw new Exception('Not found', 404);
        }

        $lift_page = new Lift_Page();
        $page = $lift_page->read(['id' => $id]);

        if (empty($page[0])) {
            throw new Exception('Not found', 404);
        }

        $this->view->setVar('page', $page[0]);
    }

    public function createAction()
    {
        if (empty($this->session->get("logged_user")['success']) || $this->session->get("logged_user")['success']['group'] != 1) {
            throw new Exception('Forbidden', 403);
        }

        if ($this->request->getPost('submit')) {
            $data = [
                'title' => trim($this->request->getPost('title')),
                'text' => trim($this->request->getPost('text'))
            ];

            if (empty($data['title'])) {
                $error['data']['title'] = true;
            }

            if (empty($data['text'])) {
                $error['data']['text'] = true;
            }

            if (empty($error)) {
                $token = $this->session->get('logged_user')['success']['token'];

                $lift_page = new Lift_Page();
                $result = $lift_page->create($token, $data);

                if (empty($result)) {
                    $error['database']['pg_insert'] = true;
                } else {
                    $id = $lift_page->getLastId();
                    $response = new \Phalcon\Http\Response();
                    return $response->redirect('/pages/' . $id);
                }
            }

            $this->view->setVar('result', ['error' => $error]);
            $this->view->setVar('page', $data);
        }
    }

    public function updateAction($id)
    {
        if (!$id) {
            throw new Exception('Not found', 404);
        }

        if (empty($this->session->get("logged_user")['success']) || $this->session->get("logged_user")['success']['group'] != 1) {
            throw new Exception('Forbidden', 403);
        }

        $lift_page = new Lift_Page();
        $condition = ['id' => $id];
        $page = $lift_page->read($condition);

        if (empty($page[0])) {
            throw new Exception('Not found', 404);
        }

        $page = $page[0];

        if ($this->request->getPost('submit')) {
            $data = [
                'title' => trim($this->request->getPost('title')),
                'text' => trim($this->request->getPost('text'))
            ];

            if (empty($data['title'])) {
                $error['data']['title'] = true;
            }

            if (empty($data['text'])) {
                $error['data']['text'] = true;
            }

            if (empty($error)) {
                $token = $this->session->get('logged_user')['success']['token'];
                $result = $lift_page->update($token, $data, $condition);

                if (empty($result)) {
                    $error['database']['pg_insert'] = true;
                } else {
                    $response = new \Phalcon\Http\Response();
                    return $response->redirect('/pages/' . $id);
                }
            }

            $page = $data;
            $this->view->setVar('result', ['error' => $error]);
        }

        $this->view->setVar('page', $page);
    }


    public function deleteAction($id)
    {
        if (!$id) {
            throw new Exception('Not found', 404);
        }

        if (empty($this->session->get("logged_user")['success']) || $this->session->get("logged_user")['success']['group'] != 1) {
            throw new Exception('Forbidden', 403);
        }

        $lift_page = new Lift_Page();
        $condition = ['id' => $id];
        $page = $lift_page->read($condition);

        if (empty($page[0])) {
            throw new Exception('Not found', 404);
        }

        $token = $this->session->get('logged_user')['success']['token'];
        $result = $lift_page->delete($token, $condition);
        $this->view->setVar('result', $result);
    }
}