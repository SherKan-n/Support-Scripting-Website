<?php
    defined('BASEPATH') or exit('No direct script access allowed');
    $skills_types = array(
        "<span class=\"label\" style=\"border-radius:4px; background-color:#00629c;\">C</span>",
        "<span class=\"label\" style=\"border-radius:4px; background-color:#0083cf;\">C++</span>",
        "<span class=\"label\" style=\"border-radius:4px; background-color:#9500ff;\">C#</span>",
        "<span class=\"label label-warning\" style=\"border-radius:4px;\">Java</span>",
        "<span class=\"label\" style=\"padding: 0px;\"><span class=\"label label-primary\" style=\"border-top-left-radius:4px; border-bottom-left-radius:4px; padding-right: 1px;\">Pyt</span><span class=\"label label-yellow2\" style=\"border-top-right-radius:4px; border-bottom-right-radius:4px; padding-left: 1px;\">hon</span></span>",
        "<span class=\"label label-yellow\" style=\"border-radius:4px;\">PAWN</span>",
        "<span class=\"label label-red\" style=\"border-radius:4px;\">HTML</span>",
        "<span class=\"label\" style=\"border-radius:4px; background-color:#00a2ff;\">CSS</span>",
        "<span class=\"label label-yellow2\" style=\"border-radius:4px;\">JavaScript</span>",
        "<span class=\"label label-purple\" style=\"border-radius:4px;\">PHP</span>",
        "<span class=\"label\" style=\"border-radius:4px; background-color:#ab0000;\">Ruby</span>",
        "<span class=\"label\" style=\"padding: 0px;\"><span class=\"label label-info\" style=\"border-top-left-radius:4px; border-bottom-left-radius:4px; padding-right: 1px;\">My</span><span class=\"label label-warning\" style=\"border-top-right-radius:4px; border-bottom-right-radius:4px; padding-left: 1px;\">SQL</span></span>"
    );
    $admin_types = array(
		1=>'<span class="label label-success arrowed-right arrowed-left"><i class="fas fa-user-shield"></i> Test Admin</span>',
		'<span class="label label-primary arrowed-right arrowed-left"><i class="fas fa-user-shield"></i> Advanced Admin</span>',
		'<span class="label label-primary arrowed-right arrowed-left"><i class="fas fa-user-shield"></i> Professional Admin</span>',
		'<span class="label label-warning arrowed-right arrowed-left"><i class="fas fa-user-shield"></i> Manager Admin</span>',
		'<span class="label label-owner arrowed-right arrowed-left"><i class="fas fa-shield-alt"></i> Owner</span>',
		'<span class="label label-inverse arrowed-right arrowed-left"><i class="fas fa-wrench"></i> Founder</span>'
	);
	$helper_types = array(
		1=>'<span class="label label-success arrowed-in-right arrowed-in-left"><i class="fas fa-user-cog"></i> Test Helper</span>',
		'<span class="label label-success arrowed-in-right arrowed-in-left"><i class="fas fa-user-cog"></i> Advanced Helper</span>',
		'<span class="label label-success arrowed-in-right arrowed-in-left"><i class="fas fa-user-cog"></i> Professional Helper</span>',
		'<span class="label label-success arrowed-in-right arrowed-in-left"><i class="fas fa-user-cog"></i> Manager Helper</span>'
	);
	$donator_types = array(
		1=>'<span class="label label-bronze arrowed-in-right arrowed-in-left"><i class="fas fa-award"></i> Bronze Donor</span>',
		'<span class="label label-silver arrowed-in-right arrowed-in-left"><i class="fas fa-award"></i> Silver Donor</span>',
		'<span class="label label-gold arrowed-in-right arrowed-in-left"><i class="fas fa-award"></i> Gold Donor</span>',
		'<span class="label label-platinum arrowed-in-right arrowed-in-left"><i class="fas fa-award"></i> Platinum Donor</span>',
		'<span class="label label-diamond arrowed-in-right arrowed-in-left"><i class="fas fa-award"></i> Diamond Donor</span>'
    );
    $id = isset($_GET['id']) ? (int)$_GET['id'] : ($this->session->id);
    $id = $this->db->escape_str($id);
    $playerdata = $this->user_model->extract_data('', $id);
    $name = $playerdata->name;
?>
<div class="content">
    <?php
        $query = $this->db->query("SELECT * FROM `bans` WHERE `banName`='$name' LIMIT 1");
        if($query->num_rows() == 1):
            foreach($query->result() as $row):
                $date = $row->banDate;
                $expira =  $row->banTime;
                $numeadmin = $row->banAdmin;
                $motiv = $row->banReason;
    ?>
    <div class="text-danger" style="background-color:wheat; padding-top:10px; padding-bottom:10px; text-align:center;">
    <p><b>This account is banned</b></p>
    Baned by: <b><?=$numeadmin;?></b> on date <b><?=$date;?></b>,&nbsp; reason: <b><?=$motiv;?></b><br/>
    Time left <b><?=$expira;?></b>
    </div><br>
    <?php endforeach; endif; ?>
    <div class="row">
        <div class="col-md-4">
            <div class="card card-user">
                <div class="card-body">
                    <div class="author">
                        <?php
                            if($name != $this->session->username):
                                $query = $this->db->query("SELECT * FROM `friends` WHERE `friendName`='$name'");
                                if($query->num_rows() == 0): ?>
                                    <div style="margin:24% 0 0 95%;">
                                        <a href="functions/process_friend/<?=$name;?>/<?=hash('adler32','add');?>">
                                            <i class='fas fa-user-plus' style='font-size:20px; color:green;'></i>
                                        </a>
                                    </div>
                            <?php else: ?>
                                <div style="margin:24% 0 0 95%;">
                                    <a href="functions/process_friend/<?=$name;?>/<?=hash('adler32','remove');?>">
                                        <i class='fas fa-user-times' style='font-size:20px; color:red;'></i>
                                    </a>
                                </div>
                        <?php endif; endif; ?>
                        <img class="avatar" style="height:150px; width:150px; margin-top:0<?=($name!=$this->session->username)?('0%'):('30%');?>;" src="<?php $avatar = $this->user_model->extract_data($playerdata->name)->avatarName; echo (strpos($avatar, "googleuser") === false)?("assets/avatars/$avatar"):($avatar);?>">
                        <h5 class="title" style="color:white; margin-bottom:10px; text-shadow: 1px 1px 2px black, 0 0 25px blue, 0 0 5px darkblue;"><?=$name;?></h5>
                        <div style="margin:5px 0 5px 0; text-align:center;">
                        <?php
                            if($playerdata->admin > 0) echo $admin_types[$playerdata->admin]."<br>";
                            if($playerdata->helper > 0) echo $helper_types[$playerdata->helper]."<br>";
                            if($playerdata->premium > 0) echo $donator_types[$playerdata->premium]."<br>";
                        ?>
                        </div>
                        <div style="margin-bottom:-5px;">
                        <?php if($name != $this->session->userdata('username')): ?>
                            <a href="functions/process_reputation/<?=$name;?>/<?=$playerdata->userID;?>">
                                <i style="font-size:15px; color:#146eff;" class="fas fa-plus-square" id="tooltip">
                                    <span class="tooltiptext">add reputation</span>
                                </i>
                            </a>
                        <?php endif; ?>
                        </div>
                    </div>
                </div>
                <div class="card-footer"><hr>
                    <div class="button-container">
                        <center style="margin-top:-10px; margin-bottom:-5px;">
                            <span class="label label-grey">
                                <?php
                                    if($name === $this->session->username) echo "<i class=\"far fa-pencil\" style=\"color:black; cursor:pointer;\" id=\"skills\">Skills</i>";
                                    else echo "<i class=\"far fa-pencil\" style=\"color:black; cursor:context-menu;\">Skills</i>";
                                ?>
                                <div class="modal-skills" id="smodal">
                                    <div class="modal-content-skills">
                                        <span class="close-skills" onclick="$('.modal-skills').hide(0);">&times;</span>
                                        <p>Select your best skills</p>
                                        <?php
                                            $skil = explode("|", $playerdata->skills);
                                            $languages = array(1=>'C', 'C++', 'C#', 'Java', 'Python', 'PAWN', 'HTML', 'CSS', 'JavaScript', 'PHP', 'Ruby', 'MySQL');
                                            $count = 0;
                                            $text = '';
                                            while($count++ < sizeof($languages)):
                                                $text = ($languages[$count]=='C#')?('C%23'):($languages[$count]);
                                                if($skil[$count-1] != 1) echo "<img id=\"imgskills\" value=\"".hash('adler32', $count)."\" src=\"assets/img/skills/$text.svg\" alt=\"$languages[$count]\" title=\"$languages[$count]\">";
                                                else echo "<img id=\"imgskills\" value=\"-1\" src=\"assets/img/skills/$text.svg\" alt=\"$languages[$count]\" title=\"$languages[$count]\">";
                                                if($count%7 == 0) echo "<br><br>";
                                            endwhile;
                                        ?>
                                        <p></p>
                                    </div>
                                </div>
                            </span>
                        </center>
                        <p></p>
                        <div class="row" id="refresh_skills" style="text-align:center;">
                            <div class="col-6-5">
                            <?php
                                $skil = explode("|", $playerdata->skills);
                                for($i = 0; $i < sizeof($skills_types); $i++) if($skil[$i] == 1) echo $skills_types[$i]." ";
                            ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title" style="text-align:center;">
                        <i style="color:orange; display:inline-block; font-size:30px;" class="fas fa-users"></i> &nbsp;Friends
                    </h4>
                </div>
                <div class="card-body">
                    <ul class="list-unstyled team-members">
                    <?php 
                        $query = $this->db->query("SELECT * FROM `friends` WHERE `name`='$name'");
                        if($query->num_rows() == 0) echo '<center><strong>Nothing</strong></center>';
                        foreach($query->result() as $data):
                    ?> 
                    <li>
                        <hr style="margin:0 0 5px 0;">
                        <div class="row">
                            <div class="col-md-2 col-2">
                                <div class="avatar">
                                    <img src="<?php $avatar = $this->user_model->extract_data($data->friendName)->avatarName; echo (strpos($avatar, "googleuser") === false)?("assets/avatars/$avatar"):($avatar);?>" class="img-circle img-no-padding img-responsive">
                                </div>
                            </div>
                            <div class="col-md-7 col-7">
                            <?php
                                echo "<a style='color:black; text-decoration:none;' href='profile?id=".$this->user_model->extract_data($data->friendName)->userID."'>".$data->friendName."</a><br>";
                                if($this->user_model->extract_data($data->friendName)->logged == 1) echo "<strong><span style=\"border-radius:20px; background-color:#8cff78; color:black; font-size:12px;\" class=\"label\">Online</span></strong>";
                                else echo "<strong><span style=\"border-radius:20px; background-color:#ff7878; color:white; font-size:12px;\" class=\"label\">Offline</span></strong>";
                            ?>
                            </div>
                            <div class="col-md-3 col-3 text-right">
                                <button type="button" class="btn btn-sm btn-outline-success btn-round btn-icon" data-toggle="tooltip" title="Hooray!"><i class="fa fa-envelope"></i></button>

                                
                            </div>
                        </div>
                    </li>
                    <?php endforeach; ?>
                    </ul>
                </div>
            </div>
        </div>
        <div class="col-md-8">
            <div class="card card-user">
                <div class="card-header">
                    <h5 class="card-title" style="text-align:center;">Statistics</h5>
                </div>
                <center>
                    <div class="card-body">
                        <div class="profile-info-row">
                            <div class="profile-info-name">Level</div>
                            <div class="profile-info-value"><?=$playerdata->level;?>
                            <?php if($name === $this->session->username && $playerdata->reputation >= $playerdata->level*7): ?>
                                <a href="functions/process_level/<?=hash('adler32', $name);?>/<?=hash('adler32', $playerdata->userID);?>"><i class="fas fa-sort-up"></i></a>
                            <?php endif; ?>
                            </div>
                        </div>
                        <div class="profile-info-row">
                            <div class="profile-info-name">Hours</div>
                            <div class="profile-info-value"><?=$playerdata->hours;?></div>
                        </div>
                        <div class="profile-info-row">
                            <div class="profile-info-name">Age</div>
                            <div class="profile-info-value">
                            <?php
                                if($playerdata->age > 0) echo $playerdata->age;
                                else echo "<i onclick='$(\".modal-edit-profile\").show(0);' title='edit your age' class='fas fa-edit' style='color:red; cursor:pointer;'></i>";
                            ?>
                            </div>
                        </div>
                        <?php if($this->session->username == $name): ?>
                        <div class="modal-edit-profile" id="emodal">
                            <div class="modal-content-edit-profile">
                                <span class="close-edit-profile" onclick="$('.modal-edit-profile').hide(0);">&times;</span>
                                <p title="edit once">Edit profile information</p>
                                <center><?php
                                    echo form_open("functions/edit_profile/".hash('adler32', "google"), ['autocomplete' => 'off']);
                                    if($playerdata->age < 1 && $playerdata->google_login == 1):
                                        echo form_label('Age', 'edit_age', ['style'=>'color:black; font-weight:bold;']);
                                        $data = array(
                                            'class' => 'form-control',
                                            'style' => 'text-align:center; width:50%;',
                                            'type'  => 'number',
                                            'id'    => 'edit_age',
                                            'name'  => 'edit_age',
                                            'min'   => '10',
                                            'max'   => '100'
                                        );
                                        echo form_input($data, set_value('edit_age'), 'required');
                                    endif;
                                    
                                    if($playerdata->gender != 1 && $playerdata->gender != 2 && $playerdata->google_login == 1):
                                        echo form_label('Gender', 'edit_gender', ['style'=>'color:black; font-weight:bold;']);
                                        $data = array(
                                            'class' => 'form-control',
                                            'style' => 'text-align:center; width:50%;',
                                            'id'    => 'edit_gender',
                                            'name'  => 'edit_gender',
                                            'type'  => 'number',
                                            'min'   => '1',
                                            'max'   => '2',
                                            'placeholder' => '1 is male and 2 is female'
                                        );
                                        echo form_input($data, set_value('edit_gender'), 'required');
                                    endif;

                                    if(strlen($playerdata->location) < 4 && $playerdata->google_login == 1):
                                        echo form_label('Location', 'edit_location', ['style'=>'color:black; font-weight:bold;']);
                                        $data = array(
                                            'class' => 'form-control',
                                            'style' => 'text-align:center; width:50%;',
                                            'id'    => 'edit_location',
                                            'name'  => 'edit_location',
                                            'minlength' => '4',
                                            'maxlength' => '32'
                                        );
                                        echo form_input($data, set_value('edit_location'), 'required')."<br>";
                                    endif;
                                    echo form_submit(['class'=>'btn btn-danger', 'style'=>'width:100px;', 'value'=>'Edit']);
                                    echo form_close();
                                ?></center>
                            </div>
                        </div>
                        <?php endif; ?>
                        <div class="profile-info-row">
                            <div class="profile-info-name">Gender</div>
                            <div class="profile-info-value">
                            <?php
                                if($playerdata->gender == 1) echo "male <i class=\"fas fa-mars\"></i>";
                                else if($playerdata->gender == 2) echo "female <i class=\"fas fa-venus\"></i>";
                                else echo "none <i class=\"fas fa-neuter\"></i>";
                            ?>
                            </div>
                        </div>
                        <div class="profile-info-row">
                            <div class="profile-info-name">Reputation</div>
                            <div class="profile-info-value"><?=$playerdata->reputation;?></div>
                        </div>
                        <?php if($this->session->admin > 0 || $this->session->username == $name): ?>
                            <div class="profile-info-row">
                                <div class="profile-info-name"><i class="far fa-gem"></i> Gems</div>
                                <div class="profile-info-value"><?=$playerdata->gems;?></div>
                            </div>
                        <?php endif; ?>
                        <div class="profile-info-row">
                            <div class="profile-info-name">Country</div>
                            <div class="profile-info-value">
                            <?php 
                                if(strlen($playerdata->location) > 3) echo $playerdata->location;
                                else echo "<i onclick='$(\".modal-edit-profile\").show(0);' title='edit your location' class='fas fa-edit' style='color:red; cursor:pointer;'></i>";
                            ?>
                            </div>
                        </div>
                        <div class="profile-info-row">
                            <div class="profile-info-name">Register Date</div>
                            <div class="profile-info-value"><?=date_format(date_create($playerdata->registerDate), "d M Y");?></div>
                        </div>
                        <div class="profile-info-row">
                            <div class="profile-info-name">Last Online</div>
                            <div class="profile-info-value"><?=date_format(date_create($playerdata->lastOnline), "d M Y | H:i");?></div>
                        </div>
                        <div class="profile-info-row">
                            <div class="profile-info-name"><i class="fas fa-exclamation-triangle"></i> Warnings</div>
                            <div class="profile-info-value"><?=$playerdata->warnings;?> / 3</div>
                        </div>
                    </div>
                </center>
            </div>
        </div>
    </div>
</div>
