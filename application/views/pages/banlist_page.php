<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<div class="content">
	<center><h3>List of banned users</h3></center>
	<div class="row">
		<table class="table table-hover table-bordered" style="text-align:center; margin-top:5%;">
			<thead>
				<tr style="color:darkblue;">
					<th>Name</th>
					<th>Date</th>
					<th>Banned by</th>
					<th>Reason</th>
					<th>Time</th>
					<th>Days Left</th>
				</tr>
			</thead>
			<tbody>
			<?php
				$query = $this->db->query("SELECT * FROM `bans` ORDER BY `banID` DESC"); 
				foreach($query->result() as $data):
			?>
			<tr>
				<td><a href="profile?id=<?=$this->user_model->extract_data($data->banName)->userID;?>" style="color:dodgerblue;"><?=$data->banName;?></a></td>
				<td><?=date_format(date_create($data->banDate), "H:i | j M Y");?></td>
				<td><?=$data->banAdmin;?></td>
				<td><?=$data->banReason;?></td>
				<td><?=date_format(date_create($data->banTime), "j M Y");?></td>
				<td>
				<?php
					if((date_create($data->banTime)->diff(date_create('now'))->d) == 0 && $this->session->admin > 4) echo "<a href=\"functions/remove_ban/".$data->banID."\" style=\"color:red; font-weight:bold; text-decoration:none;\">UNBAN</a>";
					else echo (date_create($data->banTime)->diff(date_create('now'))->d);
				?>
				</td>
			</tr>
			<?php endforeach; ?>
			</tbody>
		</table>
	</div>
</div>
