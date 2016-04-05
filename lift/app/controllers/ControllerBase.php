<?php

use Phalcon\Mvc\Controller;

class ControllerBase extends Controller
{
    public function initialize()
    {
        $request = new Phalcon\Http\Request();
        if ($request->isAjax()) {
            $this->view->setRenderLevel(1);
        }

        $logged_user = !empty($this->session->get('logged_user')['success']) ? $this->session->get('logged_user')['success'] : null;

        $this->view->setVars([
            'logged_user' => $logged_user,
            'controller' => $this->dispatcher->getControllerName(),
            'action' => $this->dispatcher->getActionName()
        ]);
    }

    public function loadImage($key)
    {

        switch ($_FILES[$key]['error']) {
            case UPLOAD_ERR_OK:
                $message = false;;
                break;
            case UPLOAD_ERR_INI_SIZE:
            case UPLOAD_ERR_FORM_SIZE:
                $message .= ' - file too large (limit of ' . get_max_upload() . ' bytes).';
                break;
            case UPLOAD_ERR_PARTIAL:
                $message .= ' - file upload was not completed.';
                break;
            case UPLOAD_ERR_NO_FILE:
                $message .= ' - zero-length file uploaded.';
                break;
            default:
                $message .= ' - internal error #' . $_FILES[$key]['error'];
                break;
        }

        if (empty($_FILES[$key]['name'])) {
            return false;
        }

        $result = ['status' => 'error'];
        $allowed_types = ['image/jpeg', 'image/png', 'image/gif'];
        $file = $_FILES[$key];

        if (!in_array($file['type'], $allowed_types)) {
            return $result;
        }

        switch ($file['type']) {
            case 'image/png':
                $extension = 'png';
                break;

            case 'image/gif':
                $extension = 'gif';
                break;

            default:
                $extension = 'jpg';
                break;
        };

        $new_name = basename($file['name']);
        $new_name = str_replace(['?', '/', '\\', "'", '"', ';', '>', '<'], '_', $new_name);
        $new_name = md5(rand() . htmlspecialchars($new_name)) . '.' . $extension;
        $new_path = getcwd() . '/upload/' . $new_name;

        if (move_uploaded_file($file['tmp_name'], $new_path)) {
            $result['status'] = 'success';
            $result['name'] = $new_name;
        };

        if (!empty($message)) {
            $result['error'] = $message;
        };
        return $result;
    }

    protected function getUsersByEmails($emails)
    {
        if (empty($emails)) {
            return false;
        }

        $result = ['status' => 'success', 'users' => null];
        $lift_user = new Lift_User();
        $emails = explode(' ', $emails);

        foreach ($emails as $email) {
            if (empty($email)) {
                continue;
            }

            $user = $lift_user->read(['email' => trim($email)]);

            if (empty($user)) {
                $result['status'] = 'error';
            } else {
                $result['users'][] = $user[0];
            }
        }

        return $result;
    }

    protected function getHeadings()
    {
        $lift_heading = new Lift_Heading();
        return $lift_heading->readAll()['success'];
    }

    protected function getSubjects()
    {
        $lift_subject = new Lift_Subject();
        return $lift_subject->readAll()['success'];
    }

    protected function makePagination($amount, $max, $page = 1)
    {
        $page = $page ? $page : 1;
        $count = ceil($amount / $max);
        $pagination = [
            'amount' => $amount,
            'max' => $max,
            'count' => $count,
            'page' => $page,
            'next' => ($page < $count) ? ($page + 1) : 0,
            'last' => ($page > 1) ? ($page - 1) : 0,
            'start' => ($page - 1) * $max
        ];

        return $pagination;
    }
}
