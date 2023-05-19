<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>
<div class="content">
    <div class="row">
		<div class="col-md-7">
            <div class="wheel-container">
                <canvas id='wheel_spin' width='500' height='500'>Canvas not supported, use another browser.</canvas>
                <div id="refreshspin">
                    <?php $query = $this->db->query("SELECT * FROM `users` WHERE `name`='".$this->session->username."' LIMIT 1")->row(); ?>
                    <span class="spindot" <?=($query->freeSpins > 0)?("id='startspin'"):("id='nospins'");?> <?=(empty($query->freeSpins))?(""):("title='$query->freeSpins spins'");?>>SPIN</span>
                </div>
                <span class="prizepoint"></span>
            </div>
        </div>
        <div class="card col-md-4">
            <p class="info-title">Informations</p>
            <div class="games-informations"></div><hr>
            <i id="lastwin"></i>
        </div>

    </div>






</div>