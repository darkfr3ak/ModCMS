<?php
if (realpath(__FILE__) == realpath($_SERVER['DOCUMENT_ROOT'].$_SERVER['SCRIPT_NAME'])){
    Header("Location: ../../index.php");
}
/* 
 * Copyright (C) 2014 darkfr3ak <info at darkfr3ak.de>
 *
 * This program is free software; you can redistribute it and/or
 * modify it under the terms of the GNU General Public License
 * as published by the Free Software Foundation; either version 2
 * of the License, or (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with this program; if not, write to the Free Software
 * Foundation, Inc., 59 Temple Place - Suite 330, Boston, MA  02111-1307, USA.
 */

$allFiles = $this->getFiles();
$userFiles = $this->loadBasket($_SESSION['user_id']);
?>
        <div class="page-header">
            <div class="pull-right">
                <?php
                if(count($userFiles) > 0){
                ?>
                <a href="index.php?app=download&task=showCart" class="btn btn-default">
                    <span class="glyphicon glyphicon-shopping-cart"></span> Geplante Downloads
                </a>
                <?php
                }
                ?>
            </div>
            <h2>Downloads</h2>
        </div>
        <?php
        foreach ($allFiles as $file) {
        ?>
        <article class="download-item row">
            <div class="col-xs-12 col-sm-12 col-md-3">
                <a href="index.php?app=download&task=file&id=<?php echo $file->file_id; ?>" title="Lorem ipsum" class="thumbnail"><img src="<?php echo $this->getCurrentApp(); ?>images/product-icon.png" alt="<?php echo $file->file_dispName; ?>" /></a>
            </div>
            <div class="col-xs-12 col-sm-12 col-md-2">
		<ul class="meta-search">
                    <li><i class="glyphicon glyphicon-calendar"></i> <span>Version: <?php echo $file->file_version; ?></span></li>
                    <li><i class="glyphicon glyphicon-time"></i> <span><?php echo $this->formatDate($file->file_date); ?></span></li>
                    <li><i class="glyphicon glyphicon-tags"></i> <span><?php echo $file->file_category; ?></span></li>
                </ul>
            </div>
            <div class="col-xs-12 col-sm-12 col-md-7 excerpet">
		<h3><a href="index.php?app=download&task=file&id=<?php echo $file->file_id; ?>" title=""><?php echo $file->file_dispName; ?></a></h3>
                <p><?php echo $file->file_desc; ?></p>						
                <span class="plus"><a href="index.php?app=download&task=add&id=<?php echo $file->file_id; ?>" title="Add to Basket"><i class="glyphicon glyphicon-plus"></i></a></span>
            </div>
            <span class="clearfix borda"></span>
	</article>
        <?php
        }
        ?>
<div class="modal" id="modal">
<div class="modal-dialog">
<div class="modal-content">
<div class="modal-header">
<button type="button" class="close" data-dismiss="modal" aria-hidden="true">
&times;</button>
<h4 class="modal-title">Modal Title Goes Here</h4>
</div>
<div class="modal-body">
Load Data...
</div>
<div class="modal-footer">
<a href="#" class="btn btn-default" data-dismiss="modal">Close</a>
<a href="#" class="btn btn-primary">Do Nothing</a>
</div>
</div><!-- /.modal-content -->
</div><!-- /.modal-dialog -->
</div>