<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>
<div class="content">
    <center><h2>Register Panel</h2></center>
    <?php echo form_open("functions/process_register"); ?>
    <div class="form-row">
        <div class="form-group col-md-6">
        <?php
            echo form_label('Username', 'username');
            $data = array('class'=>'form-control', 'id'=>'username', 'name'=>'username', 'placeholder'=>'Username');
            echo form_input($data, set_value('username'), 'required');
        ?>
        </div>
        <div class="form-group col-md-6">
        <?php
            echo form_label('Password', 'password');
            $data = array('class'=>'form-control', 'id'=>'password', 'name'=>'password', 'placeholder'=>'Password', 'value'=>set_value('password'));
            echo form_password($data, set_value('password'), 'required');
        ?>
        </div>
    </div>
    <div class="form-group">
    <?php
        echo form_label('E-mail Address', 'email');
        $data = array('class'=>'form-control', 'id'=>'email', 'type'=>'email', 'name'=>'email', 'placeholder'=>'Your e-mail address');
        echo form_input($data, set_value('email'), 'required');
    ?>
    </div>
    <div class="form-group">
        <?php echo form_label('Birthday Date', 'dates'); ?>
        <div class="form-row">
            <div class="col">
            <?php
                $data = array('class'=>'form-control', 'id'=>'dates', 'type'=>'number', 'name'=>'day', 'placeholder'=>'Day', 'min'=>'1', 'max'=>'31');
                echo form_input($data, set_value('day'), 'required'); 
            ?>
            </div>
            <div class="col">
            <?php
                $options = array(1=>'January',2=>'February',3=>'March',4=>'April',5=>'May',6=>'June',7=>'July',8=>'August',9=>'September',10=>'October',11=>'November',12=>'December');
                echo form_dropdown(['class'=>'form-control', 'id'=>'dates', 'name'=>'month'], $options, [1=>'January']);
            ?>
            </div>
            <div class="col">
            <?php
                $data = array('class'=>'form-control', 'id'=>'dates', 'type'=>'number', 'name'=>'year', 'placeholder'=>'Year', 'min'=>'1990', 'max'=>getdate()['year']);
                echo form_input($data, set_value('year'), 'required'); 
            ?>
            </div>
        </div>
    </div>
    <div class="form-row">
        <div class="form-group col-md-4">
        <?php 
            echo form_label('Gender', 'gender');
            echo form_dropdown(['class'=>'form-control', 'id'=>'gender', 'name'=>'gender'], ['1'=>'Male', '2'=>'Female'], ['1'=>'Male']);
        ?>
        </div>
    </div>
    <div class="form-group">
    <?php
        echo form_label('Country', 'location');
        $data = array('class'=>'form-control', 'id'=>'location', 'name'=>'location', 'placeholder'=>'Your country');
        echo form_input($data, set_value('country'), 'required');
    ?>
    </div>
    <?php
        echo "<center>".form_submit(['class'=>'btn btn-primary', 'style'=>'width:200px;'], 'Register')."</center>";
        echo form_close();
    ?>
</div>