<?php

class UserStatusController extends BaseController{


  public function getStatus() {
    return View::make('user.status');
  }
}