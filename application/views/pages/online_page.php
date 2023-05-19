<div class="content">
	<div class="row">
		<div class="col-md-12">
			<div class="card">
				<div class="card-header">
					<h4 class="card-title" style="text-align:center;">Users Online</h4><br>
				</div>
				<div class="card-body">
					<table class="table" style="text-align:center;">
						<thead style="color:dodgerblue;">
							<th>Name</th>
							<th>Level</th>
							<th>Hours</th>
							<th>Reputation</th>
							<th>Last Online</th>
						</thead>
						<tbody>
						<?php foreach(($this->db->query("SELECT * FROM `users` WHERE `logged`='1' ORDER BY `level` DESC, `hours` DESC"))->result() as $data): ?>
						<tr>
							<td>
							<?php if($data->userID != $this->session->id): ?>
								<a href="profile?id=<?=$data->userID;?>" style="color:dodgerblue; font-weight:bold; text-decoration:none;"><?=$data->name;?></a>
							<?php else: ?>
								<a href="profile" style="color:darkorange; font-weight:bold; text-decoration:none;"><?=$data->name;?></a>
							<?php endif; ?>
							</td>
							<td><strong style="color:grey;"><?=$data->level;?></strong></td>
							<td><strong style="color:grey;"><?=$data->hours;?></strong></td>
							<td><strong style="color:grey;"><?=$data->reputation;?></strong></td>
							<td><strong style="color:grey;"><?=date_format(date_create($data->lastOnline), "d M Y | H:i");?></strong></td>
						</tr>
						<?php endforeach; ?>
						</tbody>
					</table>
				</div>
			</div>
		</div>
	</div>
</div>
