<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<div class="content">
    <center>
        <h3>Top Users</h3>
        <div style="margin-top:5%">
            <table class="top" style="width:70%;">
                <tr>
                    <th>Status</th>
                    <th>Name</th>
                    <th>Level</th>
                    <th>Hours</th>
                    <th>Reputation</th>
                    <th>Last Online</th>
                </tr>
                <?php 
                    $query = $this->db->query("SELECT * FROM `users` WHERE `hours`>'0' ORDER BY `level` DESC, `hours` DESC LIMIT 20");
                    foreach($query->result() as $data): 
                ?>
                <tr>
                    <td>
                    <?php 
                        if($data->logged == 1) echo "<strong><span style=\"border-radius:20px; background-color:#8cff78; color:black; font-size:12px;\" class=\"label\">Online</span></strong>";
                        else echo "<strong><span style=\"border-radius:20px; background-color:#ff7878; color:white; font-size:12px;\" class=\"label\">Offline</span></strong>";
                    ?>
                    </td>
                    <td><a style="color:midnightblue; text-decoration:none;" href="profile?id=<?=$data->userID;?>"><?=$data->name;?></a></td>
                    <td><?=$data->level;?></td>
                    <td><?=$data->hours;?></td>
                    <td><?=$data->reputation;?></td>
                    <td><?=$data->lastOnline;?></td>
                </tr>
                <?php endforeach; ?>
            </table>
        </div>
    </center>
</div>