<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<div class="content">
    <center>
    <i id="changeContent" value="show" class="fas fa-sync"></i><h2 id="changeTitle" style="text-align:center;">Ban user</h2>
    <div id="banContent">
        <?php echo form_open('functions/process_punish/'.hash('adler32', 'ban')); ?>
        <table class="table table-striped table-hover table-bordered" style="width:auto;">
            <tr>
                <td style="text-align:center;">Username:</td>
                <td>
                    <?php echo form_input(['type'=>'text', 'name'=>'username', 'autocomplete'=>'off', 'id'=>"searchName"], set_value('username'), 'required'); ?>
                    <br><span id="shownames"></span>
                </td>
                <td><font size="1.5">Enter the exact username you want to ban</font></td>
            </tr>
            <tr>
                <td style="text-align:center;">Days:</td>
                <td><?php echo form_input(['type'=>'number', 'name'=>'days', 'min'=>'1', 'autocomplete'=>'off'], set_value('days'), 'required'); ?></td>
                <td><font size="1.5">Enter the number of days</font></td>
            </tr>
            <tr>
                <td style="text-align:center;">Reason:</td>
                <td><?php echo form_input(['type'=>'text', 'name'=>'reason', 'autocomplete'=>'off'], set_value('reason'), 'required'); ?></td>
                <td><font size="1.5">The reason you want to ban him</font></td>
            </tr>
            <tr>
                <td colspan="2" style="text-align:center; color:tomato; font-weight:bold;"><?=$this->session->flashdata('formError');?></td>
                <td colspan="3" style="text-align:center;"><?php echo form_submit(['class'=>'btn btn-inverse', 'style'=>'width:120px;'], 'Ban'); ?></td>
            </tr>
        </table>
        <?php echo form_close(); ?>
    </div>
    <div id="warnContent" style="display:none;">
        <?php echo form_open('functions/process_punish/'.hash('adler32', 'warn')); ?>
        <table class="table table-striped table-hover table-bordered" style="width:auto;">
            <tr>
                <td style="text-align:center;">Username:</td>
                <td>
                    <?php echo form_input(['type'=>'text', 'name'=>'username', 'autocomplete'=>'off', 'id'=>"searchName2"], set_value('username'), 'required'); ?>
                    <br><span id="shownames2"></span>
                </td>
                <td><font size="1.5">Enter the exact username you want to warn</font></td>
            </tr>
            <tr>
                <td style="text-align:center;">Reason:</td>
                <td><?php echo form_input(['type'=>'text', 'name'=>'reason', 'autocomplete'=>'off'], set_value('reason'), 'required'); ?></td>
                <td><font size="1.5">The reason you want to warn him</font></td>
            </tr>
            <tr>
                <td colspan="2" style="text-align:center; color:tomato; font-weight:bold;"><?=$this->session->flashdata('formError');?></td>
                <td colspan="3" style="text-align:center;"><?php echo form_submit(['class'=>'btn btn-inverse', 'style'=>'width:120px;'], 'Warn'); ?></td>
            </tr>
        </table>
        <?php echo form_close(); ?>
    </div>
    </center>
</div>