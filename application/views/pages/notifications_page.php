<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<div class="content">
    <?php
        $title_icon = array(
            "List of Friends" => "<i class='far fa-handshake' style='color:coral; font-size:20px;'></i>",
            "Reputation"      => "<i class='far fa-star' style='color:dodgerblue; font-size:20px;'></i>",
            "Market"          => "<i class='fas fa-shopping-basket' style='color:limegreen; font-size:20px;'></i>",
            "Reward"          => "<i class='fas fa-gem' style='color:yellow; font-size:20px;'></i>",
            "SYSTEM"          => "<i class='fas fa-tools' style='color:red; font-size:20px;'></i>"
        );
        $query = $this->db->query("SELECT * FROM `notifications` WHERE `name`='".$this->session->username."' ORDER BY `status`, `date` DESC");
        if($query->num_rows() > 0) echo "<center><h3>Notifications</h3></center>";
        else echo "<h3>No notifications</h3>";
    ?>
    <table class="table table-hover table-bordered" style="text-align:center;">
        <thead class="thead-light">
            <tr>
                <th>#</th>
                <th>Title</th>
                <th>Information</th>
                <th>Date</th>
                <th>Read</th>
            </tr>
        </thead>
        <tbody>
        <?php foreach($query->result() as $data): $date = date_create($data->date); ?>
        <tr>
            <td><?=$title_icon[$data->title];?></td>
            <td><b><?=$data->title;?></b></td>
            <td><?=$data->text;?></td>
            <td><?=(($date->diff(date_create('today'))->d) == 0)?("Today"):(date_format(date_create($data->date), 'j M Y | H:i'));?></td>
            <td>
            <?php
                echo ($data->status == 1)?("<i style='color:green;' class='fas fa-check-circle'></i>"):("<i style='color:red;' class='fas fa-minus-circle'></i>");
                $this->db->query("UPDATE `notifications` SET `status`='1' WHERE `status`='0' AND `notifyID`='$data->notifyID'");
            ?>
            </td>
        </tr>
        <?php endforeach; ?>
        </tbody>
    </table>
</div>