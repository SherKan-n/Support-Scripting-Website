<?php
	defined('BASEPATH') OR exit('No direct script access allowed');
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
?>
<div class="content">
	<br><br>
	<div class="row">
		<div class="col-md-12">
			<div class="card">
				<div class="card-header">
					<h4 class="card-title">Admins (<?=($this->db->query("SELECT `userID` FROM `users` WHERE `admin`>'0'"))->num_rows();?>)</h4>
				</div>
				<div class="card-body">
					<table class="table" style="text-align:center;">
						<thead style="color:blueviolet;">
							<th>Status</th>
							<th>Name</th>
							<th>Admin Level</th>
							<th>Rank Name</th>
							<th>Last Online</th>
						</thead>
						<tbody>
						<?php
							$query = $this->db->query("SELECT * FROM `users` WHERE `admin`>'0' ORDER BY `admin` DESC");
							foreach($query->result() as $data):
						?>
						<tr>
							<td>
							<?php
								if($data->logged == 1) echo "<strong><span style=\"border-radius:20px; background-color:#8cff78; color:black; font-size:12px;\" class=\"label\">Online</span></strong>";
								else echo "<strong><span style=\"border-radius:20px; background-color:#ff7878; color:white; font-size:12px;\" class=\"label\">Offline</span></strong>";
							?>
							</td>
							<td><a href="profile?id=<?=$data->userID;?>"><font color='#1a1a1a'><?=$data->name;?></a></font></td>
							<td><?=$data->admin;?></td>
							<td>
							<?php
								if($data->name == 'SherKan')
								{
									echo "<span class=\"label label-owner arrowed-right arrowed-left\"><i class=\"fas fa-shield-alt\"></i> Owner</span>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";
									echo "<span class=\"label label-purple arrowed-right arrowed-left\"><i class=\"fas fa-code\"></i> Developer</span>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";
								}
								echo $admin_types[$data->admin];
							?>
							</td>
							<td><?=date_format(date_create($data->lastOnline), "d M Y | H:i");?></td>
						</tr>
						<?php endforeach; ?>
						</tbody>
					</table>
				</div>
			</div>
		</div>
	</div>
	<br><br>
	<div class="row">
		<div class="col-md-12">
			<div class="card">
				<div class="card-header">
					<h4 class="card-title">Helpers (<?=($this->db->query("SELECT `userID` FROM `users` WHERE `helper`>'0'"))->num_rows();?>)</h4>
				</div>
				<div class="card-body">
					<table class="table" style="text-align:center;">
						<thead style="color:blueviolet;">
							<th>Status</th>
							<th>Name</th>
							<th>Helper Level</th>
							<th>Rank Name</th>
							<th>Last Online</th>
						</thead>
						<tbody>
						<?php
							$query = $this->db->query("SELECT * FROM `users` WHERE `helper`>'0' ORDER BY `helper` DESC");
							foreach($query->result() as $data):
						?>
						<tr>
							<td>
							<?php
								if($data->logged == 1) echo "<strong><span style=\"border-radius:20px; background-color:#8cff78; color:black; font-size:12px;\" class=\"label\">Online</span></strong>";
								else echo "<strong><span style=\"border-radius:20px; background-color:#ff7878; color:white; font-size:12px;\" class=\"label\">Offline</span></strong>";
							?>
							</td>
							<td><a href="profile?id=<?=$data->userID;?>"><font color='#1a1a1a'><?=$data->name;?></a></font></td>
							<td><?=$data->helper;?></td>
							<td><?=$helper_types[$data->helper];?></td>
							<td><?=date_format(date_create($data->lastOnline), "j M Y | H:i");?></td>
						</tr>
						<?php endforeach; ?>
						</tbody>
					</table>
				</div>
			</div>
		</div>
	</div>
	<br><br>
	<div class="row">
		<div class="col-md-12">
			<div class="card">
				<div class="card-header">
					<h4 class="card-title">Premium Users (<?=($this->db->query("SELECT `userID` FROM `users` WHERE `premium`>'0'"))->num_rows();?>)</h4>
				</div>
				<div class="card-body">
					<table class="table" style="text-align:center;">
						<thead style="color:blueviolet;">
							<th>Status</th>
							<th>Name</th>
							<th>Premium Level</th>
							<th>Rank Name</th>
							<th>Last Online</th>
						</thead>
						<tbody>
						<?php
							$query = $this->db->query("SELECT * FROM `users` WHERE `premium`>'0' ORDER BY `premium` DESC");
							foreach($query->result() as $data):
						?>
						<tr>
							<td>
							<?php
								if($data->logged == 1) echo "<strong><span style=\"border-radius:20px; background-color:#8cff78; color:black; font-size:12px;\" class=\"label\">Online</span></strong>";
								else echo "<strong><span style=\"border-radius:20px; background-color:#ff7878; color:white; font-size:12px;\" class=\"label\">Offline</span></strong>";
							?>
							</td>
							<td><a href="profile?id=<?=$data->userID;?>"><font color='#1a1a1a'><?=$data->name;?></a></font></td>
							<td><?=$data->premium;?> (<?=$data->donations;?> donations)</td>
							<td><?=$donator_types[$data->premium];?></td>
							<td><?=date_format(date_create($data->lastOnline), "d M Y | H:i");?></td>
						</tr>
						<?php endforeach; ?>
						</tbody>
					</table>
				</div>
			</div>
		</div>
	</div>
</div>
