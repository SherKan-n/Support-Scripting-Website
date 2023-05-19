<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<div class="content">
    <center>
        <h4>Forgot password</h4><br><br><br>
        <?php echo form_open("functions/recover_password"); ?>
        <div class="form-group col-md-3">
        <?php
            echo form_label('Username', 'username');
            $data = array('class'=>'form-control', 'id'=>'username', 'name'=>'forgot_username', 'placeholder'=>'Username');
            echo form_input($data, set_value('username'), 'required');
        ?>
        </div><br>
        <div class="form-group col-md-3">
        <?php
            echo form_label('Email', 'email');
            $data = array('class'=>'form-control', 'id'=>'email', 'name'=>'forgot_email', 'placeholder'=>'Email', 'value'=>set_value('email'));
            echo form_input($data, set_value('email'), 'required');
        ?>
        </div>
        <?php
            echo form_submit(['class'=>'btn btn-success'], 'Send');
            echo form_close();
        ?>
        <?php if(!empty($this->session->flashdata('formError'))): ?>
        <div class="form-group col-md-4 alert-warning" style="border:1px solid pink; font-weight:bold; color:black; border-radius:5px; padding:5px;">
            <?=$this->session->flashdata('formError');?>
        </div>
        <?php endif; ?>
    </center>
</div>
