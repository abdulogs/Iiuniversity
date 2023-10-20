<?php

/**
 * Messages
 */
class message {

    public static function success($value =""){
      echo '<div class="custom-alert" role="alert">
      <div class="custom-alert-body">
        <span class="fa fa-check ti-check custom-alert-icon-success"></span>
      <div class="custom-alert-content">
        <h6 class="custom-alert-heading"><b>Congratulations!</b></h6>
        <p class="custom-alert-subheading">'.$value.'</p>
      </div>
      <button class="fa fa-close alert-close ti-close" type="button" onclick="parentNode.parentNode.parentNode.removeChild(parentNode.parentNode);"
       data-dismiss="alert"></button></p>
      </div>';
    }

    public static function error($value = ""){
      echo '<div class="custom-alert" role="alert">
      <div class="media custom-alert-body">
        <span class="fa fa-close ti-close custom-alert-icon-error"></span>
      <div class="media-body custom-alert-content">
        <h6 class="custom-alert-heading"><b>Opps!</b> you got an error</h6>
        <p class="custom-alert-subheading">'.$value.'</p>
      </div>
      <button class="fa fa-close alert-close ti-close" onclick="parentNode.parentNode.parentNode.removeChild(parentNode.parentNode);"
      type="button" data-dismiss="alert"></button></p>
      </div>';
    }

  }
