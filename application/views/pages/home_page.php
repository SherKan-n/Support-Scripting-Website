<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<div class="content">
    <div class="row">
        <div class="col-lg-3 col-md-6 col-sm-6">
            <div class="card card-stats">
                <div class="card-body">
                    <div class="row">
                        <div class="col-5 col-md-4">
                            <div class="icon-big text-center icon-warning">
                                <i class="fas fa-globe text-success"></i>
                            </div>
                        </div>
                        <div class="col-7 col-md-8">
                            <div class="numbers">
                                <a href="online_users" style="text-decoration:none;"><p class="card-category"><strong>Users Online</strong></p></a>
                                <p class="card-title">
                                <?php 
                                    echo $this->db->query("SELECT `userID` FROM `users` WHERE `logged`='1'")->num_rows();
                                    echo " / ".$this->db->query("SELECT `userID` FROM `users`")->num_rows();
                                ?>
                                <p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-footer"><hr>
                    <div class="stats" style="text-align:center;">
                    <i class="far fa-grin-alt" style="font-size:15px; color:limegreen;"></i>
                    <?php $data = ($this->db->query("SELECT `name` FROM `users` ORDER BY `registerDate` DESC LIMIT 1"))->row(); ?>
                    Last registered <strong style="color:limegreen;"><?=(empty($data->name))?('-'):($data->name);?></strong>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-md-6 col-sm-6">
            <div class="card card-stats">
                <div class="card-body">
                    <div class="row">
                        <div class="col-5 col-md-4">
                            <div class="icon-big text-center icon-warning">
                                <i class="fas fa-lock text-danger"></i>
                            </div>
                        </div>
                        <div class="col-7 col-md-8">
                            <div class="numbers">
                                <a href="banlist" style="text-decoration:none;"><p class="card-category"><strong>Banned Users</strong></p></a>
                                <p class="card-title"><?=($this->db->query("SELECT `banID` FROM `bans`"))->num_rows();?><p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-footer"><hr>
                    <div class="stats" style="text-align:center;">
                        <i class="far fa-frown" style="font-size:15px; color:red;"></i>
                        <?php $data = ($this->db->query("SELECT `banName` FROM `bans` ORDER BY `banDate` DESC LIMIT 1"))->row(); ?>
                        Last banned <strong style="color:tomato;"><?=(empty($data->banName))?(''):($data->banName);?></strong>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-md-6 col-sm-6">
            <div class="card card-stats">
                <div class="card-body">
                    <div class="row">
                        <div class="col-5 col-md-4">
                            <div class="icon-big text-center icon-warning">
                                <i class="fas fa-shield-alt text-warning"></i>
                            </div>
                        </div>
                        <div class="col-7 col-md-8">
                            <div class="numbers">
                                <a href="staff" style="text-decoration:none;"><p class="card-category"><strong>Staff</strong></p></a>
                                <p class="card-title">
                                <?php
                                    echo ($this->db->query("SELECT `userID` FROM `users` WHERE (`admin`>'0' OR `helper`>'0') AND `logged`='1'"))->num_rows();
                                    echo " / ".($this->db->query("SELECT `userID` FROM `users` WHERE `admin`>'0' OR `helper`>'0'"))->num_rows();
                                ?>
                                <p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-footer"><hr>
                    <div class="stats" style="text-align:center;">
                        <i class="fas fa-gavel" style="color:orange; font-size:15px;"></i>
                        <?php $data = ($this->db->query("SELECT `name` FROM `users` WHERE (`admin`>'0' OR `helper`>'0') ORDER BY `tickets` DESC LIMIT 1"))->row(); ?>
                        Best in staff <strong style="color:orange;"><?=(empty($data->name))?('-'):($data->name);?></strong>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-md-6 col-sm-6">
            <div class="card card-stats">
                <div class="card-body">
                    <div class="row">
                        <div class="col-5 col-md-4">
                            <div class="icon-big text-center icon-warning">
                                <i class="fas fa-shopping-basket text-primary"></i>
                            </div>
                        </div>
                        <div class="col-7 col-md-8">
                            <div class="numbers">
                                <a href="market" style="text-decoration:none;"><p class="card-category"><strong>Market Place</strong></p></a>
                                <p class="card-title"><?=($this->db->query("SELECT `itemID` FROM `market`"))->num_rows();?><p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-footer"><hr>
                    <div class="stats" style="text-align:center;">
                        <i class="fas fa-cloud-download-alt" style="font-size:15px; color:dodgerblue;"></i>
                        <?php $data = ($this->db->query("SELECT `itemID` FROM `market` ORDER BY `date` DESC LIMIT 1"))->row(); ?>
                        Last item added
                        <?php if(!empty($data->itemID)): ?>
                            &nbsp;<a href="functions/item/<?=$data->itemID;?>/<?=hash('adler32', 'show');?>"><i class="fas fa-external-link-alt" style="color:dodgerblue; font-weight:bold; font-size:15px;"></i></a>
                        <?php else: ?>
                            <strong><font color="dodgerblue">None</font></strong>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-4">
            <div class="card">
                <a>test</a>
            </div>
        </div>
        <div class="col-md-8">
            <div class="card card-chart">
            <?php $data = $this->db->query("SELECT * FROM `updates` ORDER BY `date` DESC, `updateID` DESC LIMIT 1")->row(); ?>
            <?php if(empty($data)): ?>
            <div class="card-header">
                <h5>No Updates</h5>
            </div>
            <?php else: ?>
            <div class="card-header">
                <h5 class="card-title">The Latest Update (<?=$data->version;?>)</h5>
                <p class="card-category"><?=date_format(date_create($data->date), "d M Y");?></p>
            </div>
            <?php if($this->session->admin > 4):
                echo '<div class="card-body" id="update">';
                echo "<a style='cursor:pointer;'>".$data->text."</a>";
                echo form_textarea(['class'=>'form-control', 'style'=>'display:none;', 'type'=>'text', 'autocomplete'=>'off', 'value'=>$data->text], set_value($data->text), 'required');
            else:
                echo '<div class="card-body">';
                echo "<a>".$data->text."</a>";
            endif; ?>
            </div>
            <?php endif; ?>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <a>text</a>
            </div>
        </div>
    </div>
</div>
