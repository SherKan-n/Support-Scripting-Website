<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>
<div class="content">
    <center>
        <h4>Search for an user</h4><br><br>
        <label for="inp" class="inp">
        <?php echo form_open('functions/search_player'); ?>
            <input type="text" id="inp" placeholder="&nbsp;" name="username" autocomplete="off" minlength="3" required>
            <span class="label">Username</span>
            <span class="border"></span>
        <?php echo form_close(); ?>
        </label>
    </center><br><br><br>
    <table class="table table-hover table-bordered" style="text-align:center;">
        <thead>
        <?php
            $text = $this->input->get('username', true);
            $this->db->like('name', $text);
            $this->db->limit(10);
            $query = $this->db->get('users');
            if($query->num_rows() > 0 && !empty($text)): ?>
            <tr>
                <th>Status</th>
                <th>Name</th>
                <th>Level</th>
                <th>Hours</th>
                <th>Reputation</th>
                <th>Last Online</th>
            </tr>
        </thead>
        <tbody>
        <?php foreach($query->result() as $data): ?>
        <tr>
            <td>
            <?php
                if($data->logged == 1) echo "<strong><span style=\"border-radius:20px; background-color:#8cff78; color:black; font-size:12px;\" class=\"label\">Online</span></strong>";
                else echo "<strong><span style=\"border-radius:20px; background-color:#ff7878; color:white; font-size:12px;\" class=\"label\">Offline</span></strong>";
            ?>
            </td>
            <td><a href="profile?id=<?=$data->userID;?>" style="color:darkcyan;"><?=$data->name;?></a></td>
            <td><?=$data->level;?></td>
            <td><?=$data->hours;?></td>
            <td><?=$data->reputation;?></td>
            <td><?=date_format(date_create($data->lastOnline), "d M Y | H:i");?></td>
        </tr>
        <?php endforeach; endif; ?>
        </tbody>
    </table>
</div>
