<?php
namespace application\controllers;

class UserController extends Controller {
    public function signup() {
        $json = getJson();  //배열로 넘어옴
        $rs = $this->model->signUp($json);
        if($rs) {
            $this->flash(_LOGINUSER, $rs);
            return [_RESULT => $rs];
        }
        return [_RESULT => 0];
    }

    public function logout() {
        $this->flash(_LOGINUSER);
        
        return [_RESULT => 1];
    }
}