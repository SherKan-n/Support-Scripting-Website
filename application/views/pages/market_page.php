<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<div class="content">
    <?php $rows = $this->db->query("SELECT `itemID` FROM `market` WHERE `owner`='".$this->session->username."'")->num_rows(); ?>
    <h3 style="text-align:center;">
    <?php if($rows == 0) echo '<button class="button-item" id="hide-content"><i class="fas fa-angle-double-right"></i></button>'; ?>
        Market Place
    </h3><br>
    <?php if($rows == 0): ?>
    <div id="show-content" style="display:none;">
        <h3>Item Informations</h3>
        <div class="form-row">
            <?php echo form_open("functions/item/NULL/".hash('adler32', 'add')); ?>
            <div class="form-group">
                <div class="form-row">
                    <div class="col">
                    <?php
                        echo form_label('Name', 'name');
                        echo form_input(['class'=>'form-control', 'type'=>'text', 'id'=>'name', 'name'=>'name', 'autocomplete'=>'off'], set_value('name'), 'required')."</div><br><div class=\"col\">";
                        
                        echo form_label('Price (gems)', 'price');                
                        echo form_input(['class'=>'form-control', 'id'=>'price', 'type'=>'number', 'name'=>'price', 'autocomplete'=>'off', 'min'=>'1', 'max'=>'9000'], set_value('price'), 'required')."</div><br><div class=\"col\">";

                        echo form_label('Password', 'password');                
                        echo form_input(['class'=>'form-control', 'id'=>'password', 'type'=>'password', 'name'=>'password', 'autocomplete'=>'off', 'minlength'=>'5'], set_value('password'), 'required')."<br>";
                    ?>
                    </div>
                </div>
                <?php
                    date_default_timezone_set('Europe/Bucharest');

                    echo form_label('Link Video (youtube)', 'link'); 
                    echo form_input(['class'=>'form-control', 'id'=>'link', 'type'=>'url', 'name'=>'link', 'autocomplete'=>'off'], set_value('link'))."<br>";
                    
                    echo '<div class="form-row"><div class="col-7">';
                    echo form_label('Time Rent', 'rent'); 
                    echo form_input(['class'=>'form-control', 'id'=>'rent', 'type'=>'date', 'name'=>'rent', 'autocomplete'=>'off'], set_value('rent'), 'required')."<br>";
                    echo '</div></div>';

                    echo form_label('Description', 'description');
                    echo form_textarea(['class'=>'form-control', 'id'=>'description', 'type'=>'text', 'name'=>'description', 'autocomplete'=>'off'], set_value('description'), 'required')."<br>";

                    echo form_submit(['class'=>'btn btn-warning', 'style'=>'width:150px;'], 'Place Item'); 
                ?>
            </div>
            <?php echo form_close()."<br>"; ?>
        </div>
    </div><hr>
    <?php endif; if(empty($this->session->flashdata('itemData'))):
        $query = $this->db->query("SELECT * FROM `market` ORDER BY `date` DESC");
        $i=0;
        foreach($query->result() as $data):
            $i++; 
            if($i%3==1) echo "<div class=\"market\">"; ?>
            <div class="item">
                <div class="face face1">
                    <div class="content">
                        <img src="assets/img/items/<?=(explode('|', $data->images)[0] == '-')?('unknown.jpg'):(explode('|', $data->images)[0]);?>" alt="image">
                        <h3><?=$data->name;?></h3>
                    </div>
                </div>
                <div class="face face2">
                    <div class="content">
                        <p style="margin:0;"><?=$data->description;?></p>
                        <a class="text" href="functions/item/<?=$data->itemID;?>/<?=hash('adler32', 'show');?>">Read More</a>
                    </div>
                </div>
            </div>
        <?php if(!empty($data->videoLink)) echo "</a>"; ?>
    <?php if($i%3==0) echo "</div>"; endforeach; else: $item = $this->session->flashdata('itemData'); ?>
    <div class="card p-4">
        <div style="align-self:flex-start; position:absolute; max-width:350px;">
            <h6 style="text-align:left;">Description</h6><p><?=$item['descriere'];?></p>
            <iframe style="border:2px ridge pink; border-radius:15px;" width="350" height="245" src="http://www.youtube.com/embed/<?=$item['video'];?>" frameborder="1" allowfullscreen></iframe>
        </div>
        <div class="ps-container" style="align-self:center; position:absolute; margin-left:5.2em;">
            <h6 style="text-align:center;">Images<p>(<?=$item['images']['count'];?>)</p></h6>
            <?php if($item['images']['count'] != 0): ?>
                <div id='itemImages' class="carousel slide" data-ride="carousel" style="max-width:365px; border:4px double yellow; border-radius:25%; max-height:260px;">
                    <div class="carousel-inner">
                        <div class="carousel-item active">
                            <img style="width:100%; height:100%;" src="assets/img/items/<?=$item['images']['src'][0];?>" width="365" height="260">
                        </div>
                        <?php if($item['images']['src'] != 'none'): for($i = 1; $i < 5; $i++): ?>
                        <div class="carousel-item">
                            <img style="width:100%; height:100%;" src="assets/img/items/<?=$item['images']['src'][$i];?>" width="365" height="260">
                        </div>
                        <?php endfor; else: ?>
                            <p><?=$item['images'];?></p>
                        <?php endif; ?>
                    </div>
                    <a class="carousel-control-prev" href="#itemImages" data-slide="prev"><span class="carousel-control-prev-icon"></span></a>
                    <a class="carousel-control-next" href="#itemImages" data-slide="next"><span class="carousel-control-next-icon"></span></a>
                </div>
            <?php else: ?>
            <center>
                <?php if($item['owner'] === $this->session->username):
                    echo form_open("functions/upload/NULL/".hash('adler32', 'item_images'));
                    echo form_upload(['style'=>'display:none;', 'id'=>'img_upload']);
                    echo form_close();
                ?>
                <button style="border:1px solid black; border-radius:25%;" type="button" value="Upload" onclick='document.getElementById("img_upload").click();'>Upload Images</button>
                <?php endif; ?>
            </center>
            <?php endif; ?>
            <b><?=$item['purchases'];?> purchases</b>
        </div>
        <div style="align-self:flex-end; text-align:center;">
            <img style="max-width:200px; border:1px dotted lightblue; border-radius:10%;" src="assets/img/items/<?=$item['logo'];?>">
            <h6 style="margin:10px 0 0 0;">Name</h6><p style="color:darkred; "><?=$item['name'];?></p>
            <h6 style="margin:0 0 5px 0;">Owner <a style="color:blue;"><?=$item['owner'];?></a></h6>
            <h6 style="margin:15px 0 0 0; color:#00a500;"><?=$item['price'];?> <i class="far fa-gem"></i></h6>
            <span class="badge-sonar"></span><p></p>
            <button class="btn btn-success p-2" id="confirm_buy" url="functions/item/<?=$item['id'].'/'.hash('adler32', 'buy');?>">Buy</button><br>
            <a>Time left <?=$item['date'];?></a>
        </div>
    </div>
    <?php endif; ?>
</div>